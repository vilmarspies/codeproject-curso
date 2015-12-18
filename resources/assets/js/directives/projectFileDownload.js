angular.module('app.directives')
.directive('ProjectFileDownload',
	['appConfig', 'ProjectFile', function(appConfig, ProjectFile){
		return {
			restrict: 'E', 
			templateUrl: appConfig.baseUrl + '/build/assets/views/templates/projectFileDownload.html',
			link: function (scope, element, attrs) {
					
			},
			controller: ['$scope', '$attrs', function ($scope, $attrs) {

			}]
		};
	}]);	