angular.module('app.services')
	.service('ProjectFile',['$resource', '$routeParams', 'appConfig', 'Url', function($resource, $routeParams, appConfig, Url){
		var url = appConfig.baseUrl + Url.getUrlResource(appConfig.urls.projectFile)
		return $resource(url, {id: '@id', taskId:'@fileId'},{
			update: {
				method: 'PUT'
			},
			download: {
				url: appConfig.baseUrl + Url.getUrlResource(appConfig.urls.projectFile) + '/download',
				method: 'GET'
			}
		});
	}]);