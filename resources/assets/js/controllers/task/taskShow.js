angular.module('app.controllers')
	.controller('ProjectTaskShowController', ['$scope', '$location', '$routeParams','ProjectTask', 
				function($scope, $location, $routeParams, ProjectTask){
		$scope.note = ProjectTask.get({id: $routeParams.id, taskId:$routeParams.taskId});

	}]);