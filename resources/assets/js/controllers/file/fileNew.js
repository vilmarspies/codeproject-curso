angular.module('app.controllers')
	.controller('ProjectFileNewController', ['$scope', '$routeParams', '$location','ProjectFile', 
					function($scope, $routeParams, $location, ProjectFile){
		$scope.file = new ProjectFile();
		$scope.file.project_id = $routeParams.id;

		$scope.save = function () {
			if ($scope.formFile.$valid){
				$scope.file.$save({id:$routeParams.id}).then(function(){
					$location.path('/project/'+$routeParams.id+'/files')
				});
			}
		}
	}]);