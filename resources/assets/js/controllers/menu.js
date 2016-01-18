angular.module('app.controllers')
	.controller('MenuController', ['$scope','$cookies', function($scope, $cookies){
	$scope.userLogado = $cookies.getObject('user');
}]);
