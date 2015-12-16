angular.module('app.controllers')
	.controller('ProjectShowController', ['$scope', '$location', '$routeParams','Project', 'appConfig',
				function($scope, $location, $routeParams, Project, appConfig){
		$scope.project = Project.get({id: $routeParams.id});
		$scope.status = appConfig.project.status;

	}]);