angular.module('app.controllers')
	.controller('ProjectEditController', ['$scope', '$location', '$routeParams','Project', 'appConfig',
				function($scope, $location, $routeParams, Project, appConfig){
		$scope.project = Project.get({id: $routeParams.id});
		$scope.status = appConfig.project.status;

		$scope.save = function () {
			if ($scope.formProject.$valid){
				Project.update({id:$scope.project.id}, $scope.project,function(){
					$location.path('/projects');
				});
			}
		}
	}]);