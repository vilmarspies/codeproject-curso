angular.module('app.controllers')
	.controller('ProjectDashboardController', ['$scope', '$routeParams','Project', 'appConfig', 'ProjectMember', 'ProjectTask', 'User',
		function($scope, $routeParams, Project, appConfig, ProjectMember, ProjectTask, User){
		$scope.project = {};
		$scope.member = new ProjectMember();

		Project.query({
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

		$scope.saveMember = function () {
			if($scope.formMember.$valid){
				
				$scope.member.$save({id: $scope.project.id}).then(function(data){
					$scope.member = new ProjectMember();
					$scope.userSelected = '';
					var memberSaved = {
						'id':data.id,
						'member_id': data.member.id,
						'name': data.member.name
					};
					$scope.project.members.data.push(memberSaved);

				});
			}
			else{
				
			}
		};

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
			task.status = 3;
			ProjectTask.update({id:task.project_id, taskId:task.id}, task, function(data){
				console.log(data);
				$scope.project.progress = data.project.progress;
			});
			
		};
	}]);