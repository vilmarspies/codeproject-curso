angular.module('app.services')
	.service('Project',['$resource', '$filter', '$httpParamSerializer', '$routeParams', 'appConfig', 
		function($resource, $filter, $httpParamSerializer, $routeParams, appConfig){
			function transformData (data) {
				if(angular.isObject(data) && data.hasOwnProperty('due_date')){
					newData = angular.copy(data);
					newData.due_date = $filter('date')(data.due_date, 'yyyy-MM-dd');
					return appConfig.utils.transformRequest(newData);
				} 
				return data;
			}
		return $resource(appConfig.baseUrl + '/project/:id', {id: '@id'},{
			save: {
				method: 'POST',
				transformRequest: transformData
			},
			get: {
				method: 'GET',
				transformResponse: function(data, headers){
					var obj = appConfig.utils.transformResponse(data, headers);
					if(angular.isObject(obj) && obj.hasOwnProperty('due_date')){
						var arrayDate = obj.due_date.split('-');
						obj.due_date = new Date(arrayDate[0], (arrayDate[1]-1), arrayDate[2]);
					} 
					return obj;
				}
			},
			update: {
				method: 'PUT',
				transformRequest: transformData
			}
		});
	}]);