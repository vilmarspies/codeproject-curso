angular.module('app.directives')
.directive('ProjectFileDownload',
	['$timeout','appConfig', 'ProjectFile', function($timeout, appConfig, ProjectFile){
		return {
			restrict: 'E', 
			templateUrl: appConfig.baseUrl + '/build/assets/views/templates/projectFileDownload.html',
			link: function (scope, element, attrs) {

				var anchor = element.children()[0];

				scope.$on('salvar-arquivo',function(event, data){
					$(anchor).removeClass('disabled fa-spinner').addClass('fa-download');
					$(anchor).attr({
						href: 'data:application-octet-stream;base64,'+data.file,
						download: data.name
					});
					$timeout(function(){
						scope.downloadFile=function() {
							
						};
						$(anchor)[0].click();
					});
				});
			},
			controller: ['$scope', '$element', '$attrs', function ($scope, $element, $attrs) {
				$scope.downloadFile = function () {
					var anchor = $element.children()[0];
					$(anchor).removeClass('fa-download').addClass('fa-spinner disabled');

					ProjectFile.download({id:null,fileId:$attrs.idFile},function(data) {
						$scope.$emit('salvar-arquivo',data);
					});
				};
			}]
		};
	}]);