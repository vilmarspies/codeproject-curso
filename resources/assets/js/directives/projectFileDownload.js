angular.module('app.directives')
.directive('projectFileDownload',
	['$timeout','appConfig', 'ProjectFile', function($timeout, appConfig, ProjectFile){
		return {
			restrict: 'E', 
			scope: {
				file: '='
		    },
			templateUrl: appConfig.baseUrl + '/build/assets/views/templates/projectFileDownload.html',
			link: function (scope, element, attrs) {
				var anchor = element.children()[0];
				var i = $(anchor).children();
				scope.$on('salvar-arquivo',function(event, data){
					console.log(data);
					$(anchor).removeClass('disabled');
					
					$(i).addClass('fa-download').removeClass('fa-spinner');
					$(anchor).attr({
						href: 'data:application-octet-stream;base64,'+data.file,
						download: data.name
					});
					$timeout(function(){
						scope.downloadFile = function() {};
						$(anchor)[0].click();
					});
				});
			},
			controller: ['$scope', '$element', '$attrs', function ($scope, $element, $attrs) {
				$scope.downloadFile = function () {
					var anchor = $element.children()[0];
					$(anchor).addClass('disabled');
					var i = $(anchor).children();
					$(anchor).append($attrs.nameFile);
					$(i).addClass('fa-spinner').removeClass('fa-download');

					ProjectFile.download({id:$attrs.idProject,fileId:$attrs.idFile},function(data) {
						$scope.$emit('salvar-arquivo',data);
					});
				};
			}]
		};
}]);