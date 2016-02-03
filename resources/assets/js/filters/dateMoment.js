angular.module('app.filters')
	.filter('dateMoment', [function() {
		return function(input) {
			//return moment().calendar(input, 'D/M/YYYY');
			moment.locale('pt-br');
			return moment(input).fromNow();
		};
}]);