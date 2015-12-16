var app = angular.module('app', ['ngRoute','angular-oauth2','app.controllers', 'app.services', 'app.filters']);

angular.module('app.controllers', ['ngMessages', 'angular-oauth2']);
angular.module('app.filters', []);
angular.module('app.services', ['ngResource']);

app.provider('appConfig',function(){
	var config = {
		baseUrl: 'http://codeproject.curso',
		project:{
			status: [
				{value: 1, label:'Não Iniciado'},
				{value: 2, label:'Iniciado'},
				{value: 3, label:'Concluido'}
			]
		}
	};
	return {
		config: config,
		$get: function(){
			return config;
		}
	};
});

app.config(['$routeProvider', '$httpProvider', 'OAuthProvider', 'OAuthTokenProvider', 'appConfigProvider',
				function($routeProvider, $httpProvider, OAuthProvider, OAuthTokenProvider, appConfigProvider) {
	$httpProvider.defaults.transformResponse = function(data,headers) {
		var headersGetter = headers();
		if (headersGetter['content-type'] == 'application/json' || headersGetter['content-type']=='text/json'){
			var dataJson = JSON.parse(data);
			if(dataJson.hasOwnProperty('data')){
				dataJson = dataJson.data;
			}
			return dataJson;
		}
		return data;
	}
	$routeProvider
		.when('/login',{
			templateUrl: 'build/assets/views/login.html',
			controller: 'LoginController'
		})
		.when('/home',{
			templateUrl: 'build/assets/views/home.html',
			controller: 'HomeController'
		})
		.when('/',{
			templateUrl: 'build/assets/views/home.html',
			controller: 'HomeController'
		})
		.when('/clients',{
			templateUrl: 'build/assets/views/client/list.html',
			controller: 'ClientListController'
		})
		.when('/clients/new',{
			templateUrl: 'build/assets/views/client/new.html',
			controller: 'ClientNewController'
		})
		.when('/clients/:id/show',{
			templateUrl: 'build/assets/views/client/view.html',
			controller: 'ClientViewController'
		})
		
		.when('/clients/:id/edit',{
			templateUrl: 'build/assets/views/client/edit.html',
			controller: 'ClientEditController'
		})
		.when('/clients/:id/remove',{
			templateUrl: 'build/assets/views/client/remove.html',
			controller: 'ClientRemoveController'
		})
		//ProjectNote LIST
		.when('/projects',{
			templateUrl: 'build/assets/views/project/list.html',
			controller: 'ProjectListController'
		})//Project NEW
		.when('/projects/new',{
			templateUrl: 'build/assets/views/project/new.html',
			controller: 'ProjectNewController'
		})//Project SHOW
		.when('/projects/:id/show',{
			templateUrl: 'build/assets/views/project/show.html',
			controller: 'ProjectShowController'
		})//Project EDIT 
		.when('/projects/:id/edit',{
			templateUrl: 'build/assets/views/project/edit.html',
			controller: 'ProjectEditController'
		})//Project REMOVE
		.when('/projects/:id/remove',{
			templateUrl: 'build/assets/views/project/remove.html',
			controller: 'ProjectRemoveController'
		})
		//ProjectNote LIST
		.when('/project/:id/notes',{
			templateUrl: 'build/assets/views/note/list.html',
			controller: 'ProjectNoteListController'
		})//ProjectNote NEW
		.when('/project/:id/notes/new',{
			templateUrl: 'build/assets/views/note/new.html',
			controller: 'ProjectNoteNewController'
		})//ProjectNote SHOW
		.when('/project/:id/notes/:noteId/show',{
			templateUrl: 'build/assets/views/note/show.html',
			controller: 'ProjectNoteShowController'
		})//ProjectNote EDIT 
		.when('/project/:id/notes/:noteId/edit',{
			templateUrl: 'build/assets/views/note/edit.html',
			controller: 'ProjectNoteEditController'
		})//ProjectNote REMOVE
		.when('/project/:id/notes/:noteId/remove',{
			templateUrl: 'build/assets/views/note/remove.html',
			controller: 'ProjectNoteRemoveController'
		})
		//ProjectNote LIST
		.when('/project/:id/files',{
			templateUrl: 'build/assets/views/note/list.html',
			controller: 'ProjectFileListController'
		})//ProjectFile NEW
		.when('/project/:id/files/new',{
			templateUrl: 'build/assets/views/note/new.html',
			controller: 'ProjectFileNewController'
		})//ProjectFile SHOW
		.when('/project/:id/files/:fileId/show',{
			templateUrl: 'build/assets/views/file/show.html',
			controller: 'ProjectFileShowController'
		})//ProjectFile EDIT 
		.when('/project/:id/files/:fileId/edit',{
			templateUrl: 'build/assets/views/file/edit.html',
			controller: 'ProjectFileEditController'
		})//ProjectFile REMOVE
		.when('/project/:id/files/:fileId/remove',{
			templateUrl: 'build/assets/views/file/remove.html',
			controller: 'ProjectFileRemoveController'
		})
		//ProjectNote LIST
		.when('/project/:id/tasks',{
			templateUrl: 'build/assets/views/task/list.html',
			controller: 'ProjectTaskListController'
		})//ProjectTask NEW
		.when('/project/:id/tasks/new',{
			templateUrl: 'build/assets/views/task/new.html',
			controller: 'ProjectTaskNewController'
		})//ProjectTask SHOW
		.when('/project/:id/tasks/:noteId/show',{
			templateUrl: 'build/assets/views/task/show.html',
			controller: 'ProjectTaskShowController'
		})//ProjectTask EDIT 
		.when('/project/:id/tasks/:noteId/edit',{
			templateUrl: 'build/assets/views/task/edit.html',
			controller: 'ProjectTaskEditController'
		})//ProjectTask REMOVE
		.when('/project/:id/tasks/:noteId/remove',{
			templateUrl: 'build/assets/views/task/remove.html',
			controller: 'ProjectTaskRemoveController'
		});

		OAuthProvider.configure({
			baseUrl: appConfigProvider.config.baseUrl,
	    	clientId: 'appid1',
	    	clientSecret: 'secret', // optional
	    	grantPath: 'oauth/access_token'
	    });

	    OAuthTokenProvider.configure({
	    	name: 'token',
	    	options: {
	    		secure: false
	    	}
	    });
}]);

app.run(['$rootScope', '$window', 'OAuth', function($rootScope, $window, OAuth) {
    $rootScope.$on('oauth:error', function(event, rejection) {
      // Ignore `invalid_grant` error - should be catched on `LoginController`.
      if ('invalid_grant' === rejection.data.error) {
        return;
      }

      // Refresh token when a `invalid_token` error occurs.
      if ('invalid_token' === rejection.data.error) {
        return OAuth.getRefreshToken();
      }

      // Redirect to `/login` with the `error_reason`.
      return $window.location.href = '/login?error_reason=' + rejection.data.error;
    });
  }]);