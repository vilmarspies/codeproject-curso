angular.module('app.controllers')
	.controller('ProjectFileNewController', ['$scope', '$routeParams', '$location','Url', 'Upload', 'appConfig',
					function($scope, $routeParams, $location, Url, Upload, appConfig){

		$scope.save = function () {
			if ($scope.formFile.$valid){
				Upload.upload({
		            url: appConfig.baseUrl+ Url.getUrlFromUrlSymbol(appConfig.urls.projectFile, {id:$routeParams.id, fileId: ''}),
		            fields: {
		            	'name': $scope.file.name,
		            	'description': $scope.file.description
		            },
		            file: $scope.file.file
		        }).then(function (resp) {
		            $location.path('/project/'+$routeParams.id+'/files')
		        });
				/*$scope.file.$save({id:$routeParams.id}).then(function(){
					$location.path('/project/'+$routeParams.id+'/files')
				});*/
			}
		}
	}]);