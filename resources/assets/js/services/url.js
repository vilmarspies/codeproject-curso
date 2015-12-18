angular.module('app.services')
	.service('Url',['$interpolate', function($interpolate){
		return {
			getUrlFromUrlSymbol: function (url, params) {
				// url '/project/{{id}}/files/{{fileId}}'
				// params id=1, fileId = 2
				// return /project/1/files/2
				var urlMod = $interpolate(url)(params);
				return urlMod.replace(/\/\//g,'\/')
								.replace(/\/$/,'');

			},
			getUrlResource: function (url) {
				// url '/project/{{id}}/files/{{fileId}}'
				//return  /project/:id/files/:fileId
				return url.replace(new RegExp('{{','g'),':')
							.replace(new RegExp('}}','g'),'');
			}
		}
	}]);