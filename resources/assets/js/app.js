var app = angular.module('app', ['app.controllers']);

angular.module('app.controllers', []);

app.config(function($routeProvider) {
	$routeProvider
		.when('/login',{
			templateUrl: 'build/assets/views/login.html',
			controller: 'LoginController'
		})
		.when('/home',{
			templateUrl: 'build/assets/views/home.html',
			controller: 'HomeController'
		});
		
});