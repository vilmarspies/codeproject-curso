angular.module('app.controllers')
	.controller('ProjectFileShowController', ['$scope', '$location', '$routeParams','ProjectFile', 
				function($scope, $location, $routeParams, ProjectFile){
		$scope.note = ProjectFile.get({id: $routeParams.id, taskId:$routeParams.fileId});

	}]);