angular.module('app.controllers')
	.controller('ProjectMemberRemoveController', ['$scope', '$location', '$routeParams','ProjectMember',
				function($scope, $location, $routeParams, ProjectMember){
		$scope.member = ProjectMember.get({
							id: $routeParams.id, 
							memberId: $routeParams.memberId
						});

		$scope.remove = function () {
			$scope.member.$delete({id:$routeParams.id, memberId:$scope.member.id}).then(function() {
				$scope.cancelar();
			});
		};

		$scope.cancelar = function() {
			$location.path('/project/'+$routeParams.id+'/members');
		};
	}]);