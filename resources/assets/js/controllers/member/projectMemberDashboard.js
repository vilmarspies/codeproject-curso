angular.module('app.controllers')
	.controller('ProjectMemberDashboardController', ['$scope', '$routeParams','ProjectMember', 'appConfig',
		function($scope, $routeParams, ProjectMember, appConfig){
		$scope.project = {};
		ProjectMember.query({
			orderBy: 'created_at',
			sortedBy: 'asc',
			limit: 5
		},function(data)
		{
			$scope.projects = data.data;
		});

		$scope.status = appConfig.project.status;
		$scope.statusTasks = appConfig.task.status;

		$scope.showProject = function(selected){
			$scope.project = selected;
		}

		$scope.taskClicked = function(id){
			console.log(id)
		}
	}]);