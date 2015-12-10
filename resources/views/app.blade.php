<!DOCTYPE html>
<html lang="en" ng-app="app">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Laravel</title>
	
	@if(Config::get('app.debug'))
		<link rel="stylesheet" type="text/css" href="{{asset('build/assets/css/app.css')}}">
		<link rel="stylesheet" type="text/css" href="{{asset('build/assets/css/components.css')}}">
		<link rel="stylesheet" type="text/css" href="{{asset('build/assets/css/flaticon.css')}}">
		<link rel="stylesheet" type="text/css" href="{{asset('build/assets/css/font-awesome.css')}}">
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
	<nav class="navbar navbar-default">
		<div class="container-fluid">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar">
					<span class="sr-only">Toggle Navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="#">Laravel</a>
			</div>

			<div class="collapse navbar-collapse" id="navbar">
				<ul class="nav navbar-nav">
					<li><a href="{{ url('/') }}">Welcome</a></li>
				</ul>

				<ul class="nav navbar-nav navbar-right">
					@if(auth()->guest())
						@if(!Request::is('auth/login'))
							<li><a href="{{ url('/auth/login') }}">Login</a></li>
						@endif
						@if(!Request::is('auth/register'))
							<li><a href="{{ url('/auth/register') }}">Register</a></li>
						@endif
					@else
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">{{ auth()->user()->name }} <span class="caret"></span></a>
							<ul class="dropdown-menu" role="menu">
								<li><a href="{{ url('/auth/logout') }}">Logout</a></li>
							</ul>
						</li>
					@endif
				</ul>
			</div>
		</div>
	</nav>

<div ng-view></div>

	<!-- Scripts -->
	@if(Config::get('app.debug'))
			<script type="text/javascript" src="{{asset('build/assets/js/vendor/jquery.min.js')}}"></script>
			<script type="text/javascript" src="{{asset('build/assets/js/vendor/angular.min.js')}}"></script>
			<script type="text/javascript" src="{{asset('build/assets/js/vendor/angular-route.min.js')}}"></script>
			<script type="text/javascript" src="{{asset('build/assets/js/vendor/angular-resource.min.js')}}"></script>
			<script type="text/javascript" src="{{asset('build/assets/js/vendor/angular-animate.min.js')}}"></script>
			<script type="text/javascript" src="{{asset('build/assets/js/vendor/angular-messages.min.js')}}"></script>
			<script type="text/javascript" src="{{asset('build/assets/js/vendor/ui-bootstrap.min.js')}}"></script>
			<script type="text/javascript" src="{{asset('build/assets/js/vendor/navbar.min.js')}}"></script>
			<script type="text/javascript" src="{{asset('build/assets/js/vendor/angular-cookies.min.js')}}"></script>
			<script type="text/javascript" src="{{asset('build/assets/js/vendor/query-string.js')}}"></script>
			<script type="text/javascript" src="{{asset('build/assets/js/vendor/angular-oauth2.min.js')}}"></script>

			<script type="text/javascript" src="{{asset('build/assets/js/app.js')}}"></script>
			
			<!-- Controllers -->
			<script type="text/javascript" src="{{asset('build/assets/js/controllers/login.js')}}"></script>
			<script type="text/javascript" src="{{asset('build/assets/js/controllers/home.js')}}"></script>
			<script type="text/javascript" src="{{asset('build/assets/js/controllers/client/clientList.js')}}"></script>
			<script type="text/javascript" src="{{asset('build/assets/js/controllers/client/clientNew.js')}}"></script>
			<script type="text/javascript" src="{{asset('build/assets/js/controllers/client/clientEdit.js')}}"></script>
			<script type="text/javascript" src="{{asset('build/assets/js/controllers/client/clientView.js')}}"></script>
			<script type="text/javascript" src="{{asset('build/assets/js/controllers/client/clientRemove.js')}}"></script>

			<script type="text/javascript" src="{{asset('build/assets/js/controllers/note/noteList.js')}}"></script>
			<script type="text/javascript" src="{{asset('build/assets/js/controllers/note/noteShow.js')}}"></script>
			<script type="text/javascript" src="{{asset('build/assets/js/controllers/note/noteNew.js')}}"></script>
			<script type="text/javascript" src="{{asset('build/assets/js/controllers/note/noteEdit.js')}}"></script>
			<script type="text/javascript" src="{{asset('build/assets/js/controllers/note/noteRemove.js')}}"></script>

			<!-- SERVICES -->
			<script type="text/javascript" src="{{asset('build/assets/js/services/client.js')}}"></script>
			<script type="text/javascript" src="{{asset('build/assets/js/services/note.js')}}"></script>
	@else
		<script type="text/javascript" src="{{elixir('assets/js/all.js')}}"></script>
	@endif
</body>
</html>
