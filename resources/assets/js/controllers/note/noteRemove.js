angular.module('app.controllers')
	.controller('ProjectNoteRemoveController', ['$scope', '$location', '$routeParams','ProjectNote', 
				function($scope, $location, $routeParams, ProjectNote){
		$scope.note = ProjectNote.get({
							id: $routeParams.id, 
							noteId: $routeParams.noteId
						});

		$scope.remove = function () {
			$scope.note.$delete({id:$routeParams.id, noteId:$scope.note.id}).then(function() {
				$location.path('/project/'+$routeParams.id+'/notes');
			});
		};

		$scope.cancelar = function() {
			$location.path('/project/'+$routeParams.id+'/notes');
		};
	}]);