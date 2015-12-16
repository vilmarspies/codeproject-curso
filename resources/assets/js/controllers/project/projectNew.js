angular.module('app.controllers')
	.controller('ProjectNewController', ['$scope','$cookies', '$location','Project', 'Client', 'appConfig',
					function($scope,$cookies, $location, Project, Client, appConfig){
		$scope.project = new Project();
		$scope.clients = Client.query();
		$scope.status = appConfig.project.status;

		$scope.project.owner_id = $cookies.getObject('user').id;

		$scope.save = function () {
			if ($scope.formProject.$valid){
				$scope.project.$save().then(function(){
					$location.path('/projects');
				});
			}
		}
	}]);