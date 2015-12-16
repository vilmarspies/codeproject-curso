angular.module('app.services')
	.service('ProjectTask',['$resource', '$routeParams', 'appConfig', function($resource, $routeParams, appConfig){
		return $resource(appConfig.baseUrl + '/project/:id/task/:taskId', {id: '@id', taskId:'@taskId'},{
			update: {
				method: 'PUT'
			}
		});
	}]);