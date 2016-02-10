angular.module('app.controllers')
	.controller('HomeController', ['$scope','$cookies','Project', 'appConfig', function($scope, $cookies, Project, appConfig){
		$scope.project = {};
		$scope.projects = [];
		$scope.projectsSelected = [];
		$scope.status = appConfig.project.status;
		$scope.grade = true;

		Project.query({
			orderBy: 'created_at',
			sortedBy: 'asc',
			limit: 5
		},function(data)
		{
			$scope.projectsSelected = data.data;
			$scope.projects = data.data;
		});

		$scope.changed = function(){
			$scope.projectsSelected = [];
			if ($scope.project == null)
					$scope.projectsSelected = $scope.projects;
			else
				$scope.projectsSelected.push($scope.project);
		};
		
	}]);