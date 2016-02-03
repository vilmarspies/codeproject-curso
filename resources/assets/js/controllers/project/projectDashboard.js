angular.module('app.controllers')
	.controller('ProjectDashboardController', ['$scope', '$routeParams','Project', 'appConfig', 'ProjectMember', 'User',
		function($scope, $routeParams, Project, appConfig, ProjectMember, User){
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

		$scope.taskClicked = function(id){
			console.log(id)
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
	}]);