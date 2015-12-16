angular.module('app.controllers')
	.controller('HomeController', ['$scope','$cookies', function($scope, $cookies){
		$scope.logado = $cookies.getObject('user');
		//console.log($cookies.getObject('user').email);
	}]);