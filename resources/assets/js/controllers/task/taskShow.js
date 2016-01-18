angular.module('app.controllers')
	.controller('ProjectTaskShowController', ['$scope', '$location', '$routeParams','ProjectTask', 'appConfig',
				function($scope, $location, $routeParams, ProjectTask, appConfig){
		$scope.task = ProjectTask.get({id: $routeParams.id, taskId:$routeParams.taskId});
		$scope.status = appConfig.task.status;
	}]);