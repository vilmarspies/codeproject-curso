angular.module('app.controllers')
	.controller('ProjectTaskRemoveController', ['$scope', '$location', '$routeParams','ProjectTask', 'appConfig',
				function($scope, $location, $routeParams, ProjectTask, appConfig){
		$scope.task = ProjectTask.get({
							id: $routeParams.id, 
							taskId: $routeParams.taskId
						});
		$scope.status = appConfig.task.status;

		$scope.remove = function () {
			$scope.task.$delete({id:$routeParams.id, taskId:$scope.task.id}).then(function() {
				$scope.cancelar();
			});
		};

		$scope.cancelar = function() {
			$location.path('/project/'+$routeParams.id+'/tasks');
		};
	}]);