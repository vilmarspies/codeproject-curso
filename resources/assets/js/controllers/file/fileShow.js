angular.module('app.controllers')
	.controller('ProjectFileShowController', ['$scope', '$location', '$routeParams','ProjectFile', 
				function($scope, $location, $routeParams, ProjectFile){
		$scope.file = ProjectFile.get({id: $routeParams.id, fileId:$routeParams.fileId});

	}]);