angular.module('app.controllers')
	.controller('ProjectFileListController', ['$scope', '$routeParams','ProjectFile', function($scope, $routeParams, ProjectFile){
		$scope.tasks = ProjectFile.query({id: $routeParams.id});
	}]);