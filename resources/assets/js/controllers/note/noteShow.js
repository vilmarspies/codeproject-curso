angular.module('app.controllers')
	.controller('ProjectNoteShowController', ['$scope', '$location', '$routeParams','ProjectNote', 
				function($scope, $location, $routeParams, ProjectNote){
		$scope.note = ProjectNote.get({id: $routeParams.id, noteId:$routeParams.noteId});

	}]);