angular.module('app.controllers')
	.controller('ProjectFileEditController', ['$scope', '$location', '$routeParams','ProjectFile', 
				function($scope, $location, $routeParams, ProjectFile){
		$scope.file = ProjectFile.get({id: $routeParams.id, fileId:$routeParams.fileId});

		$scope.save = function () {
			if ($scope.formFile.$valid){
				ProjectFile.update({id:$routeParams.id, fileId:$scope.file.id}, $scope.file,function(){
					$location.path('/project/'+ $scope.file.project_id + '/files');
				});
			}
		}
	}]);