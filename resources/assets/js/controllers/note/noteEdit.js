angular.module('app.controllers')
	.controller('ProjectNoteEditController', ['$scope', '$location', '$routeParams','ProjectNote', 
				function($scope, $location, $routeParams, ProjectNote){
		$scope.note = ProjectNote.get({id: $routeParams.id, noteId:$routeParams.noteId});

		$scope.save = function () {
			if ($scope.formNote.$valid){
				ProjectNote.update({id:$routeParams.id, noteId:$scope.note.id}, $scope.note,function(){
					$location.path('/project/'+ $scope.note.project_id + '/notes');
				});
			}
		}
	}]);