angular.module('app.controllers')
	.controller('LoginController', ['$rootScope', '$scope','$location', '$cookies', 'User','OAuth', 
		function($rootScope, $scope, $location, $cookies, User, OAuth){
			$scope.user = {
				username:'',
				password: ''
			};
			$scope.error = {
				message:'',
				error:false
			};

			$scope.login = function(){
				if ($scope.formLogin.$valid){
					OAuth.getAccessToken($scope.user).then(function(){
						User.authenticated( {}, {}, function(data){
							$cookies.putObject('user', data);
							$location.path('home');
						})
						
					},function(data) {
						$scope.error.error = true;
						$scope.error.message = data.data.error_description;
					});
				}
			};
	}]);