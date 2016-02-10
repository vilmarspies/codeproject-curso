angular.module('app.controllers')
	.controller('ProjectListController', ['$scope', '$routeParams','Project',  'appConfig',
		function($scope, $routeParams, Project, appConfig){
		
		$scope.projects = [];

	    $scope.pagination = {
	        current: 1,
	        total: 0,
	        perPage:10,
	        paginated: []
	    };

		$scope.status = appConfig.project.status;

		$scope.pageChanged = function(newPage) {
	        $scope.projects = $scope.pagination.paginated[newPage-1]; 
	    };

	    function getProjects() {
	    	Project.all({},function(data){
	    		var ttlprojects = data;
	    		$scope.pagination.total = data.length;
	    		ttlprojects = _.orderBy(ttlprojects, ['client.name'],['asc']);
				$scope.pagination.paginated = _.chunk(ttlprojects, $scope.pagination.perPage);
				$scope.projects = $scope.pagination.paginated[0]; 

				console.log($scope.pagination.total);
	    	});
	    };

		getProjects();

	}]);