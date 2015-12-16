angular.module('app.controllers')
	.controller('ProjectTaskRemoveController', ['$scope', '$location', '$routeParams','ProjectTask', 
				function($scope, $location, $routeParams, ProjectTask){
		$scope.task = ProjectTask.get({
							id: $routeParams.id, 
							taskId: $routeParams.taskId
						});

		$scope.remove = function () {
			$scope.task.$delete({id:$routeParams.id, taskId:$scope.task.id}).then(function() {
				$location.path('/project/'+$routeParams.id+'/tasks');
			});
		};

		$scope.cancelar = function() {
			$location.path('/project/'+$routeParams.id+'/tasks');
		};
	}]);