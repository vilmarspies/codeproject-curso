angular.module('app.controllers')
	.controller('ProjectNoteNewController', ['$scope', '$routeParams', '$location','ProjectNote', 
					function($scope, $routeParams, $location, ProjectNote){
		$scope.note = new ProjectNote();

		$scope.save = function () {
			if ($scope.formNote.$valid){
				$scope.note.$save({id:$routeParams.id}).then(function(){
					$location.path('/project/'+$routeParams.id+'/notes')
				});
			}
		}
	}]);