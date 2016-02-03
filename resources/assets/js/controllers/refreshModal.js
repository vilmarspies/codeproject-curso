angular.module('app.controllers')
	.controller('RefreshModalController', ['$rootScope', '$scope','$location', '$cookies',
					'$modalInstance', '$interval', 'authService', 'User','OAuth', 'OAuthToken', 
		function($rootScope, $scope, $location, $cookies, $modalInstance, $interval, authService, User, OAuth, OAuthToken){
			$scope.user = {
				username:'',
				password: ''
			};
			$scope.error = {
				message:'',
				error:false
			};

			$scope.$on('event:auth-loginConfirmed',function() {
				$rootScope.loginModalOpened = false;
				$modalInstance.close();
			}); 

			$scope.$on('event:auth-loginCancelled',function() {
				OAuthToken.removeToken();
			});

			$scope.$on('$routeChangeStart', function () {
				$rootScope.loginModalOpened = false;
				$modalInstance.dismiss('cancel');
			});

			OAuth.getRefreshToken().then(function () {
                $interval(function () {
                    authService.loginConfirmed();
                }, 5000);
            }, function (data) {
                $scope.cancel();
            });

			$scope.login = function(){
				if ($scope.formLogin.$valid){
					OAuth.getAccessToken($scope.user).then(function(){
						User.authenticated( {}, {}, function(data){
							$cookies.putObject('user', data);
							$rootScope.logado = true;
							$rootScope.userLogado = data;
							authService.loginConfirmed();
							
						});
						
					},function(data) {
						$scope.error.error = true;
						$scope.error.message = data.data.error_description;
					});
				}
			};

			$scope.cancel = function () {
				authService.loginCancelled();
				$location.path('login');
			}
	}]);