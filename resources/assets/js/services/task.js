angular.module('app.services')
	.service('ProjectTask',['$resource', '$filter', '$httpParamSerializer', '$routeParams', 'appConfig', 
		function($resource, $filter, $httpParamSerializer, $routeParams, appConfig){
			function transformData (data) {
				if(angular.isObject(data)) {
					var newData = angular.copy(data);
					if (data.hasOwnProperty('start_date'))
						newData.start_date = $filter('date')(data.start_date, 'yyyy-MM-dd');
					if (data.hasOwnProperty('due_date'))
						newData.due_date = $filter('date')(data.due_date, 'yyyy-MM-dd');
					return appConfig.utils.transformRequest(newData);
				}
				return data;
			}
		return $resource(appConfig.baseUrl + '/project/:id/task/:taskId', {id: '@id', taskId:'@taskId'},{
			get: {
				method: 'GET',
				transformResponse: function(data, headers){
					var obj = appConfig.utils.transformResponse(data, headers);
					if(angular.isObject(obj)){
						if (obj.hasOwnProperty('start_date') && obj.start_date){
							var arrayDate = obj.start_date.split('-');
							obj.start_date = new Date(arrayDate[0], (arrayDate[1]-1), arrayDate[2]);
						}
						if(angular.isObject(obj) && obj.hasOwnProperty('due_date') && obj.due_date){
							var arrayDate = obj.due_date.split('-');
							obj.due_date = new Date(arrayDate[0], (arrayDate[1]-1), arrayDate[2]);
						}
					} 
			
					return obj;
				}
			},
			save: {
				method: 'POST',
				transformRequest: transformData
			},
			update: {
				method: 'PUT',
				transformRequest: transformData
			}
		});
	}]);
