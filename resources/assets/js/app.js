var app = angular.module('app', ['ngRoute','angular-oauth2',
									'app.controllers', 'app.filters', 'app.services', 'app.directives',
									'ui.bootstrap.typeahead', 'ui.bootstrap.datepicker', 'ui.bootstrap.tpls', 'ui.bootstrap.modal', 'ui.bootstrap.dropdown',
									'ngFileUpload', 'http-auth-interceptor', 'angularUtils.directives.dirPagination',
									'mgcrea.ngStrap.navbar',
]);

angular.module('app.controllers', ['ngMessages', 'angular-oauth2']);
angular.module('app.filters', []);
angular.module('app.directives', []);
angular.module('app.services', ['ngResource']);

app.provider('appConfig', ['$httpParamSerializerProvider', function($httpParamSerializerProvider){
	var config = {
		baseUrl: 'http://codeproject.curso',
		project: {
			status: [
				{value: 1, label:'Não Iniciado'},
				{value: 2, label:'Iniciado'},
				{value: 3, label:'Concluido'}
			]
		},
		task: {
			status: [
				{value: 1, label:'Não Iniciada'},
				{value: 2, label:'Incompleta'},
				{value: 3, label:'Completa'}
			]
		},
		urls:{
			projectFile: '/project/{{id}}/file/{{fileId}}'
		},
		utils: {
			transformRequest: function(data){
				if(angular.isObject(data)){
					return $httpParamSerializerProvider.$get()(data);
				} 
				return data;
			},
			transformResponse: function(data, headers){
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
		}
	};
	return {
		config: config,
		$get: function(){
			return config;
		}
	};
}]);

app.config(['$routeProvider', '$httpProvider', 'OAuthProvider', 'OAuthTokenProvider', 'appConfigProvider',
		function($routeProvider, $httpProvider, OAuthProvider, OAuthTokenProvider, appConfigProvider) {

	$httpProvider.defaults.headers.post['Content-Type'] = 'application/x-www-form-urlencoded;charset=utf-8';
	$httpProvider.defaults.headers.put['Content-Type'] = 'application/x-www-form-urlencoded;charset=utf-8';

	$httpProvider.defaults.transformRequest = appConfigProvider.config.utils.transformRequest;
	$httpProvider.defaults.transformResponse = appConfigProvider.config.utils.transformResponse;

	$httpProvider.interceptors.splice(0,1);
	$httpProvider.interceptors.splice(0,1);
	$httpProvider.interceptors.push('oauthFixInterceptor');
	
	$routeProvider
		.when('/login',{
			templateUrl: 'build/assets/views/login.html',
			controller: 'LoginController'
		})
		.when('/logout',{
			resolve: {
				logout: ['$rootScope','$location', 'OAuthToken',function($rootScope,$location,OAuthToken){
					OAuthToken.removeToken();
					$rootScope.logado = false;

					$location.path('login');
				}]
			}
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
		.when('/client/new',{
			templateUrl: 'build/assets/views/client/new.html',
			controller: 'ClientNewController'
		})
		.when('/client/:id/show',{
			templateUrl: 'build/assets/views/client/view.html',
			controller: 'ClientViewController'
		})
		
		.when('/client/:id/edit',{
			templateUrl: 'build/assets/views/client/edit.html',
			controller: 'ClientEditController'
		})
		.when('/client/:id/remove',{
			templateUrl: 'build/assets/views/client/remove.html',
			controller: 'ClientRemoveController'
		})
		//ProjectNote LIST
		.when('/projects',{
			templateUrl: 'build/assets/views/project/list.html',
			controller: 'ProjectListController'
		})//Project NEW
		.when('/project/new',{
			templateUrl: 'build/assets/views/project/new.html',
			controller: 'ProjectNewController'
		})//Project SHOW
		.when('/project/:id/show',{
			templateUrl: 'build/assets/views/project/show.html',
			controller: 'ProjectShowController'
		})//Project EDIT 
		.when('/project/:id/edit',{
			templateUrl: 'build/assets/views/project/edit.html',
			controller: 'ProjectEditController'
		})//Project REMOVE
		.when('/project/:id/remove',{
			templateUrl: 'build/assets/views/project/remove.html',
			controller: 'ProjectRemoveController'
		})
		//ProjectNote LIST
		.when('/project/:id/notes',{
			templateUrl: 'build/assets/views/note/list.html',
			controller: 'ProjectNoteListController'
		})//ProjectNote NEW
		.when('/project/:id/note/new',{
			templateUrl: 'build/assets/views/note/new.html',
			controller: 'ProjectNoteNewController'
		})//ProjectNote SHOW
		.when('/project/:id/note/:noteId/show',{
			templateUrl: 'build/assets/views/note/show.html',
			controller: 'ProjectNoteShowController'
		})//ProjectNote EDIT 
		.when('/project/:id/note/:noteId/edit',{
			templateUrl: 'build/assets/views/note/edit.html',
			controller: 'ProjectNoteEditController'
		})//ProjectNote REMOVE
		.when('/project/:id/note/:noteId/remove',{
			templateUrl: 'build/assets/views/note/remove.html',
			controller: 'ProjectNoteRemoveController'
		})
		//ProjectFile LIST
		.when('/project/:id/files',{
			templateUrl: 'build/assets/views/file/list.html',
			controller: 'ProjectFileListController'
		})//ProjectFile NEW
		.when('/project/:id/file/new',{
			templateUrl: 'build/assets/views/file/new.html',
			controller: 'ProjectFileNewController'
		})//ProjectFile SHOW
		.when('/project/:id/file/:fileId/show',{
			templateUrl: 'build/assets/views/file/show.html',
			controller: 'ProjectFileShowController'
		})//ProjectFile EDIT 
		.when('/project/:id/file/:fileId/edit',{
			templateUrl: 'build/assets/views/file/edit.html',
			controller: 'ProjectFileEditController'
		})//ProjectFile REMOVE
		.when('/project/:id/file/:fileId/remove',{
			templateUrl: 'build/assets/views/file/remove.html',
			controller: 'ProjectFileRemoveController'
		})

		//ProjectTask LIST
		.when('/project/:id/tasks',{
			templateUrl: 'build/assets/views/task/list.html',
			controller: 'ProjectTaskListController'
		})//ProjectTask NEW
		.when('/project/:id/task/new',{
			templateUrl: 'build/assets/views/task/new.html',
			controller: 'ProjectTaskNewController'
		})//ProjectTask SHOW
		.when('/project/:id/task/:taskId/show',{
			templateUrl: 'build/assets/views/task/show.html',
			controller: 'ProjectTaskShowController'
		})//ProjectTask EDIT 
		.when('/project/:id/task/:taskId/edit',{
			templateUrl: 'build/assets/views/task/edit.html',
			controller: 'ProjectTaskEditController'
		})//ProjectTask REMOVE
		.when('/project/:id/task/:taskId/remove',{
			templateUrl: 'build/assets/views/task/remove.html',
			controller: 'ProjectTaskRemoveController'
		})
		
		//ProjectMember LIST
		.when('/project/:id/members',{
			templateUrl: 'build/assets/views/member/list.html',
			controller: 'ProjectMemberListController'
		})//ProjectMember REMOVE
		.when('/project/:id/member/:memberId/remove',{
			templateUrl: 'build/assets/views/member/remove.html',
			controller: 'ProjectMemberRemoveController'
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

app.run(['$rootScope', '$location', '$http', '$cookies', '$modal', 'httpBuffer', 'OAuth', 
	function($rootScope, $location, $http, $cookies, $modal, httpBuffer, OAuth) {
	//AUTORIZAÇÃO
	$rootScope.$on('$routeChangeStart',function(event,next,current){
		if(next.$$route.originalPath != '/login'){
			if (!OAuth.isAuthenticated()){
				$location.path('login');
			}
		}
	});

	$rootScope.userLogado = $cookies.getObject('user');

    $rootScope.$on('oauth:error', function(event, data) {
      // Ignore `invalid_grant` error - should be catched on `LoginController`.
      if ('invalid_grant' === data.rejection.data.error) {
        return;
      }

      // Refresh token when a `invalid_token` error occurs.
      if ('access_denied' === data.rejection.data.error) {

      	httpBuffer.append(data.rejection.config, data.deferred);

      	if (!$rootScope.loginModalOpened){
	      	var modalInstance = $modal.open({
	      		templateUrl: 'build/assets/views/templates/loginModal.html',
	      		controller: 'LoginModalController'

	      	});
	      	$rootScope.loginModalOpened = true;
	    }
      	return;
      	/*if (!$rootScope.isRefreshingToken)
      	{
	      	$rootScope.isRefreshingToken = true;
	        return OAuth.getRefreshToken().then(function(response) {
	        	$rootScope.isRefreshingToken = false;
	        	return $http(data.rejection.config).then(function(resp){
	        		return data.deferred.resolve(resp);
	        	});
	        });
        }
        else
        {
        	return $http(data.rejection.config).then(function(resp){
	        	return data.deferred.resolve(resp);
	        });
        }*/
      }

      // Redirect to `/login` with the `error_reason`.
      return $location.path('login');
    });
  }]);