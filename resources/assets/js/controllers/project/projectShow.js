angular.module('app.controllers')
	.controller('ProjectShowController', ['$scope', '$location', '$routeParams','Project', 
				function($scope, $location, $routeParams, Project){
		$scope.project = Project.get({id: $routeParams.id});

	}]);