angular.module('app.services')
	.service('ProjectNote',['$resource', '$routeParams', 'appConfig', function($resource, $routeParams, appConfig){
		return $resource(appConfig.baseUrl + '/project/:id/note/:noteId', {id: '@id', noteId:'@noteId'},{
			update: {
				method: 'PUT'
			}
		});
	}]);