angular.module('app.controllers')
	.controller('ProjectFileRemoveController', ['$scope', '$location', '$routeParams','ProjectFile', 
				function($scope, $location, $routeParams, ProjectFile){
		$scope.file = ProjectFile.get({
							id: $routeParams.id, 
							fileId: $routeParams.fileId
						});

		$scope.remove = function () {
			$scope.file.$delete({id:$routeParams.id, fileId:$scope.file.id}).then(function() {
				$location.path('/project/'+$routeParams.id+'/files');
			});
		};

		$scope.cancelar = function() {
			$location.path('/project/'+$routeParams.id+'/files');
		};
	}]);