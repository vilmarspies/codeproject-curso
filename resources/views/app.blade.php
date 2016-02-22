<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pt-BR" ng-app="app">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Laravel</title>
	
	@if(Config::get('app.debug'))
		
		<link rel="stylesheet" type="text/css" href="{{asset('build/assets/css/flaticon.css')}}">
		<link rel="stylesheet" type="text/css" href="{{asset('build/assets/css/font-awesome.css')}}">
		<link rel="stylesheet" type="text/css" href="{{asset('build/assets/css/vendor/angular-ui-notification.min.css')}}">
		<link rel="stylesheet" type="text/css" href="{{asset('build/assets/css/components.css')}}">
		<link rel="stylesheet" type="text/css" href="{{asset('build/assets/css/app.css')}}">
	@else
		<link rel="stylesheet" type="text/css" href="{{elixir('assets/css/all.css')}}">
	@endif

	<!-- Fonts -->
	<link href='//fonts.googleapis.com/css?family=Roboto:400,300' rel='stylesheet' type='text/css'>

	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
</head>
<body>

<load-template url="build/assets/views/templates/menu.html"></load-template>

<div ng-view></div>

<footer class="footer-global">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="text-center">&copy; Project Manager - 2015</div>
                    </div>
                </div>
            </div>
        </footer>

	<!-- Scripts -->
	@if(Config::get('app.debug'))
			<script type="text/javascript" src="{{asset('build/assets/js/vendor/jquery.min.js')}}"></script>
			<script type="text/javascript" src="{{asset('build/assets/js/vendor/bootstrap.min.js')}}"></script>
			<script type="text/javascript" src="{{asset('build/assets/js/vendor/angular.min.js')}}"></script>
			<script type="text/javascript" src="{{asset('build/assets/js/vendor/angular-route.min.js')}}"></script>
			<script type="text/javascript" src="{{asset('build/assets/js/vendor/angular-resource.min.js')}}"></script>
			<script type="text/javascript" src="{{asset('build/assets/js/vendor/angular-animate.min.js')}}"></script>
			<script type="text/javascript" src="{{asset('build/assets/js/vendor/angular-messages.min.js')}}"></script>
			<script type="text/javascript" src="{{asset('build/assets/js/vendor/ui-bootstrap-tpls.min.js')}}"></script>
			<script type="text/javascript" src="{{asset('build/assets/js/vendor/navbar.min.js')}}"></script>
			<script type="text/javascript" src="{{asset('build/assets/js/vendor/angular-cookies.min.js')}}"></script>
			<script type="text/javascript" src="{{asset('build/assets/js/vendor/query-string.js')}}"></script>
			<script type="text/javascript" src="{{asset('build/assets/js/vendor/angular-oauth2.min.js')}}"></script>
			<script type="text/javascript" src="{{asset('build/assets/js/vendor/ng-file-upload.min.js')}}"></script>
			<script type="text/javascript" src="{{asset('build/assets/js/vendor/http-auth-interceptor.js')}}"></script>
			<script type="text/javascript" src="{{asset('build/assets/js/vendor/dirPagination.js')}}"></script>
			<script type="text/javascript" src="{{asset('build/assets/js/vendor/moment-with-locales.min.js')}}"></script>
			<script type="text/javascript" src="{{asset('build/assets/js/vendor/lodash.min.js')}}"></script>
			<script type="text/javascript" src="{{asset('build/assets/js/vendor/pusher.min.js')}}"></script>
			<script type="text/javascript" src="{{asset('build/assets/js/vendor/pusher-angular.min.js')}}"></script>
			<script type="text/javascript" src="{{asset('build/assets/js/vendor/angular-ui-notification.min.js')}}"></script>

			<script type="text/javascript" src="{{asset('build/assets/js/app.js')}}"></script>
			
			<!-- Controllers -->
			<script type="text/javascript" src="{{asset('build/assets/js/controllers/menu.js')}}"></script>
			<script type="text/javascript" src="{{asset('build/assets/js/controllers/login.js')}}"></script>
			<script type="text/javascript" src="{{asset('build/assets/js/controllers/refreshModal.js')}}"></script>
			<script type="text/javascript" src="{{asset('build/assets/js/controllers/home.js')}}"></script>
			<script type="text/javascript" src="{{asset('build/assets/js/controllers/client/clientDashboard.js')}}"></script>
			<script type="text/javascript" src="{{asset('build/assets/js/controllers/client/clientList.js')}}"></script>
			<script type="text/javascript" src="{{asset('build/assets/js/controllers/client/clientNew.js')}}"></script>
			<script type="text/javascript" src="{{asset('build/assets/js/controllers/client/clientEdit.js')}}"></script>
			<script type="text/javascript" src="{{asset('build/assets/js/controllers/client/clientView.js')}}"></script>
			<script type="text/javascript" src="{{asset('build/assets/js/controllers/client/clientRemove.js')}}"></script>

			<script type="text/javascript" src="{{asset('build/assets/js/controllers/project/projectDashboard.js')}}"></script>
			<script type="text/javascript" src="{{asset('build/assets/js/controllers/project/projectList.js')}}"></script>
			<script type="text/javascript" src="{{asset('build/assets/js/controllers/project/projectShow.js')}}"></script>
			<script type="text/javascript" src="{{asset('build/assets/js/controllers/project/projectNew.js')}}"></script>
			<script type="text/javascript" src="{{asset('build/assets/js/controllers/project/projectEdit.js')}}"></script>
			<script type="text/javascript" src="{{asset('build/assets/js/controllers/project/projectRemove.js')}}"></script>

			<script type="text/javascript" src="{{asset('build/assets/js/controllers/note/noteList.js')}}"></script>
			<script type="text/javascript" src="{{asset('build/assets/js/controllers/note/noteShow.js')}}"></script>
			<script type="text/javascript" src="{{asset('build/assets/js/controllers/note/noteNew.js')}}"></script>
			<script type="text/javascript" src="{{asset('build/assets/js/controllers/note/noteEdit.js')}}"></script>
			<script type="text/javascript" src="{{asset('build/assets/js/controllers/note/noteRemove.js')}}"></script>

			<script type="text/javascript" src="{{asset('build/assets/js/controllers/file/fileList.js')}}"></script>
			<script type="text/javascript" src="{{asset('build/assets/js/controllers/file/fileShow.js')}}"></script>
			<script type="text/javascript" src="{{asset('build/assets/js/controllers/file/fileNew.js')}}"></script>
			<script type="text/javascript" src="{{asset('build/assets/js/controllers/file/fileEdit.js')}}"></script>
			<script type="text/javascript" src="{{asset('build/assets/js/controllers/file/fileRemove.js')}}"></script>

			<script type="text/javascript" src="{{asset('build/assets/js/controllers/task/taskList.js')}}"></script>
			<script type="text/javascript" src="{{asset('build/assets/js/controllers/task/taskShow.js')}}"></script>
			<script type="text/javascript" src="{{asset('build/assets/js/controllers/task/taskNew.js')}}"></script>
			<script type="text/javascript" src="{{asset('build/assets/js/controllers/task/taskEdit.js')}}"></script>
			<script type="text/javascript" src="{{asset('build/assets/js/controllers/task/taskRemove.js')}}"></script>

			<script type="text/javascript" src="{{asset('build/assets/js/controllers/member/memberList.js')}}"></script>
			<script type="text/javascript" src="{{asset('build/assets/js/controllers/member/memberRemove.js')}}"></script>
			<script type="text/javascript" src="{{asset('build/assets/js/controllers/member/projectMemberDashboard.js')}}"></script>

			<!-- DIRECTIVES -->
			<script type="text/javascript" src="{{asset('build/assets/js/directives/projectFileDownload.js')}}"></script>
			<script type="text/javascript" src="{{asset('build/assets/js/directives/loginForm.js')}}"></script>
			<script type="text/javascript" src="{{asset('build/assets/js/directives/loadTemplate.js')}}"></script>
			<script type="text/javascript" src="{{asset('build/assets/js/directives/menuActivated.js')}}"></script>
			<script type="text/javascript" src="{{asset('build/assets/js/directives/tabProject.js')}}"></script>

			<!-- FILTERS -->
			<script type="text/javascript" src="{{asset('build/assets/js/filters/date-br.js')}}"></script>
			<script type="text/javascript" src="{{asset('build/assets/js/filters/dateMoment.js')}}"></script>
			<script type="text/javascript" src="{{asset('build/assets/js/filters/dateDiaMes.js')}}"></script>

			<!-- SERVICES -->
			<script type="text/javascript" src="{{asset('build/assets/js/services/url.js')}}"></script>
			<script type="text/javascript" src="{{asset('build/assets/js/services/oauthFixInterceptor.js')}}"></script>
			<script type="text/javascript" src="{{asset('build/assets/js/services/client.js')}}"></script>
			<script type="text/javascript" src="{{asset('build/assets/js/services/project.js')}}"></script>
			<script type="text/javascript" src="{{asset('build/assets/js/services/file.js')}}"></script>
			<script type="text/javascript" src="{{asset('build/assets/js/services/note.js')}}"></script>
 			<script type="text/javascript" src="{{asset('build/assets/js/services/task.js')}}"></script>
 			<script type="text/javascript" src="{{asset('build/assets/js/services/member.js')}}"></script>
 			

 			<script type="text/javascript" src="{{asset('build/assets/js/services/user.js')}}"></script>
			
	@else
		<script type="text/javascript" src="{{elixir('assets/js/all.js')}}"></script>
	@endif

</body>
</html>