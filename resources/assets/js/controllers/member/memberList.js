angular.module('app.controllers')
	.controller('ProjectMemberListController', ['$scope', '$routeParams','ProjectMember', 'User', 
		function($scope, $routeParams, ProjectMember, User){
			$scope.member = new ProjectMember();		
			$scope.projectId = $routeParams.id;

		$scope.save = function () {
			if($scope.formMember.$valid){
				$scope.member.$save({id: $routeParams.id}).then(function(data){
					$scope.member = new ProjectMember();
					$scope.userSelected = '';
					$scope.loadMembers();
				});
			}
		};

		$scope.loadMembers = function () {
			$scope.members = ProjectMember.query({id: $routeParams.id, orderBy: 'id',sortedBy:'desc'});
		};

		$scope.loadMembers();

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