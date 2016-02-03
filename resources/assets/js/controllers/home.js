angular.module('app.controllers')
	.controller('HomeController', ['$scope','$cookies','Project', 'appConfig', function($scope, $cookies, Project, appConfig){
		$scope.projects = [];
		$scope.status = appConfig.project.status;

		Project.query({
			orderBy: 'created_at',
			sortedBy: 'asc',
			limit: 5
		},function(data)
		{
			$scope.projects = data.data;
		});
		
	}]);