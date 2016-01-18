angular.module('app.controllers')
	.controller('ProjectTaskEditController', ['$scope', '$location', '$routeParams','ProjectTask', 'appConfig', 
				function($scope, $location, $routeParams, ProjectTask, appConfig){
		$scope.task = ProjectTask.get({id: $routeParams.id, taskId:$routeParams.taskId});
		$scope.status = appConfig.task.status;

		$scope.due_date = { 
			status: {
				opened: false
			}
		};

		$scope.start_date = { 
			status: {
				opened: false
			}
		};

		$scope.openDue = function ($event) {

			$scope.due_date.status.opened = true;
		};

		$scope.openStart = function ($event) {

			$scope.start_date.status.opened = true;
		};

		$scope.save = function () {
			if ($scope.formTask.$valid){
				ProjectTask.update({id:$routeParams.id, taskId:$scope.task.id}, $scope.task,function(){
					$location.path('/project/'+ $scope.task.project_id + '/tasks');
				});
			}
		}
	}]);