angular.module('app.controllers')
	.controller('ProjectFileListController', ['$scope', '$routeParams','ProjectFile', function($scope, $routeParams, ProjectFile){
		$scope.files = ProjectFile.query({id: $routeParams.id});
	}]);