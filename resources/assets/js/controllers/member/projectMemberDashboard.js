angular.module('app.controllers')
	.controller('ProjectMemberDashboardController', ['$scope', '$routeParams','ProjectMember', 'ProjectTask' , 'User', 'appConfig',
		function($scope, $routeParams, ProjectMember, ProjectTask, User, appConfig){
		$scope.project = {};
		$scope.member = new ProjectMember();

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
		$scope.formatName = function(model)
		{
			if (model){
				return model.name;
			}
			return '';
		};

		$scope.getUsers = function(name) {
			return  User.query({
				search: name,
				searchFields:'name:like'
			}).$promise;
		};

		$scope.selectUser = function (item) {
			$scope.member.member_id = item.id;
		};
		

		$scope.updateTask = function (task) {
			ProjectTask.update({id:task.project_id, taskId:task.id}, task, function(){
				//$location.path('/project/'+ $scope.task.project_id + '/tasks');
			});
			task.status = 3;
		};
	}]);