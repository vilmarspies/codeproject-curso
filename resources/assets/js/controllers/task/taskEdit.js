angular.module('app.controllers')
	.controller('ProjectTaskEditController', ['$scope', '$location', '$routeParams','ProjectTask', 
				function($scope, $location, $routeParams, ProjectTask){
		$scope.task = ProjectTask.get({id: $routeParams.id, taskId:$routeParams.taskId});

		$scope.save = function () {
			if ($scope.formTask.$valid){
				ProjectTask.update({id:$scope.task.project_id, taskId:$scope.task.id}, $scope.task,function(){
					$location.path('/project/'+ $scope.task.project_id + '/tasks');
				});
			}
		}
	}]);