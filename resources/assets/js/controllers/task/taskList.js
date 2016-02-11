angular.module('app.controllers')
	.controller('ProjectTaskListController', ['$scope', '$routeParams','ProjectTask', 'appConfig', 
		function($scope, $routeParams, ProjectTask, appConfig){
			$scope.task = new ProjectTask();		
			$scope.projectId = $routeParams.id;
			$scope.status = appConfig.task.status;

		$scope.save = function () {
			if($scope.formTask.$valid){
				$scope.task.status = appConfig.task.status[0].value;
				$scope.task.start_date = new Date();
				$scope.task.$save({id: $routeParams.id}).then(function(data){
					$scope.task = new ProjectTask();
					$scope.loadTask();
				});
			}
		};

		$scope.loadTask = function () {
			$scope.tasks = ProjectTask.query({id: $routeParams.id,orderBy: 'id',sortedBy:'desc'});
		};
		$scope.loadTask();
	}]);