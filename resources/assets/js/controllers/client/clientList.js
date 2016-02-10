angular.module('app.controllers')
	.controller('ClientListController', ['$scope','Client', function($scope, Client){
		$scope.clients = [];

		$scope.pagination = {
	        current: 1,
	        total: 0,
	        perPage:10
	    };

		$scope.pageChanged = function(newPage) {
	        getClients(newPage);
	    };

	    function getClients(page) {
	    	Client.query({
	    		limit: $scope.pagination.perPage,
	    		page: page
	    	},function(data){
	    		$scope.clients = data.data;
	    		$scope.pagination.total = data.meta.pagination.total;
	    	});
	    };

		getClients(1);

	}]);