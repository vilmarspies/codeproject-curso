angular.module('app.controllers')
	.controller('ProjectNoteListController', ['$scope', '$routeParams','ProjectNote', function($scope, $routeParams, ProjectNote){
		$scope.notes = ProjectNote.query({id: $routeParams.id});
		$scope.projectId = $routeParams.id;
	}]);