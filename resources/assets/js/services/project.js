angular.module('app.services')
	.service('Project',['$resource', '$routeParams', 'appConfig', function($resource, $routeParams, appConfig){
		return $resource(appConfig.baseUrl + '/project/:id', {id: '@id'},{
			update: {
				method: 'PUT'
			}
		});
	}]);