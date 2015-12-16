angular.module('app.controllers')
	.controller('ProjectTaskNewController', ['$scope', '$routeParams', '$location','ProjectTask', 
					function($scope, $routeParams, $location, ProjectTask){
		$scope.task = new ProjectTask();
		$scope.task.project_id = $routeParams.id;

		$scope.save = function () {
			if ($scope.formTask.$valid){
				$scope.task.$save({id:$routeParams.id}).then(function(){
					$location.path('/project/'+$routeParams.id+'/notes')
				});
			}
		}
	}]);