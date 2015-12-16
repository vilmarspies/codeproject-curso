angular.module('app.services')
	.service('ProjectFile',['$resource', '$routeParams', 'appConfig', function($resource, $routeParams, appConfig){
		return $resource(appConfig.baseUrl + '/project/:id/file/:fileId', {id: '@id', taskId:'@fileId'},{
			update: {
				method: 'PUT'
			}
		});
	}]);