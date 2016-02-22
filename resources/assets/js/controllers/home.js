angular.module('app.controllers')
	.controller('HomeController', ['$scope','$cookies','$timeout', '$pusher','Project', 'appConfig', 
		function($scope, $cookies, $timeout, $pusher, Project, appConfig){
		$scope.project = {};
		$scope.projects = [];
		$scope.tasks = [];
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

		var pusher = $pusher(window.client);
		var channel = pusher.subscribe('user.'+$cookies.getObject('user').id);
		channel.bind('CodeProject\\Events\\TaskWasIncluded',
		  function(data) {
		  		if ($scope.tasks.length == 6){
		  			$scope.tasks.slice($scope.tasks.length-1,1);
		  		}
		  		$timeout(function(){
		  			$scope.tasks.unshift(data.task);
		  			
		  		},300);
		  }
		);

		channel.bind('CodeProject\\Events\\TaskWasUpdated',
		  function(data) {
		  		if ($scope.tasks.length == 6){
		  			$scope.tasks.slice($scope.tasks.length-1,1);
		  		}
		  		$timeout(function(){
		  			$scope.tasks.unshift(data.task);
		  			
		  		},300);
		  }
		);


		$scope.changed = function(){
			$scope.projectsSelected = [];
			if ($scope.project == null)
					$scope.projectsSelected = $scope.projects;
			else
				$scope.projectsSelected.push($scope.project);
		};
		
	}]);