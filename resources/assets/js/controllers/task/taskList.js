angular.module('app.controllers')
	.controller('ProjectTaskListController', ['$scope', '$routeParams','ProjectTask', function($scope, $routeParams, ProjectTask){
		$scope.tasks = ProjectTask.query({id: $routeParams.id});
	}]);