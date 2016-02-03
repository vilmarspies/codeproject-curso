angular.module('app.filters')
	.filter('dateDiaMes', [function() {
		return function(input) {
			//return moment().calendar(input, 'D/M/YYYY');
			moment.locale('pt-br');
			return moment(input).format('DD MMM');
		};
}]);