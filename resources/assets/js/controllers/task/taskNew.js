angular.module('app.controllers')
	.controller('ProjectTaskNewController', ['$scope', '$routeParams', '$location','ProjectTask',  'appConfig',
					function($scope, $routeParams, $location, ProjectTask, appConfig){
		$scope.task = new ProjectTask();
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
				$scope.task.$save({id:$routeParams.id}).then(function(){
					$location.path('/project/'+$routeParams.id+'/tasks');
				});
			}
		}
	}]);