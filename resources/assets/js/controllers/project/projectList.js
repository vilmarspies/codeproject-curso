angular.module('app.controllers')
	.controller('ProjectListController', ['$scope', '$routeParams','Project', 'ProjectMember', 'appConfig',
		function($scope, $routeParams, Project, ProjectMember, appConfig){
		
		$scope.projects = [];

	    $scope.pagination = {
	        current: 1,
	        total: 0,
	        perPage:5,
	        paginated: []
	    };

		$scope.status = appConfig.project.status;

		$scope.pageChanged = function(newPage) {
	        $scope.projects = $scope.pagination.paginated[newPage-1]; 
	    };

	    $scope.previous = function(evt)
	    {
	    	evt.preventDefault();
	    }

	    $scope.previous = function(evt)
	    {
	    	evt.preventDefault();	
	    }

		function getResultsPage() {
			Project.query({
				limit: null
			},function(data){
				$scope.projects = data.data;
				ProjectMember.query({
					limit: null
				},function(data){
					var ttlprojects = _.concat($scope.projects, data.data);
					$scope.pagination.total = ttlprojects.length;
					ttlprojects = _.orderBy(ttlprojects, ['client.name'],['asc']);
					$scope.pagination.paginated = _.chunk(ttlprojects, $scope.pagination.perPage);
					$scope.projects = $scope.pagination.paginated[0]; 
				});
			});


	    };

		getResultsPage();


	}]);