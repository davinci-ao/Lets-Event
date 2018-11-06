<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<!-- CSRF Token -->
		<meta name="csrf-token" content="{{ csrf_token() }}">

		<title>{{ config('app.name', 'Laravel') }}</title>

		<!-- Scripts -->
		<script src="{{ asset('js/app.js') }}" defer></script>
		<script src="{{ asset('js/custom.js') }}" defer></script>
		<script src="{{ asset('js/select2.min.js') }}" defer></script>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
		<script defer src="https://use.fontawesome.com/releases/v5.5.0/js/all.js" integrity="sha384-GqVMZRt5Gn7tB9D9q7ONtcp4gtHIUEW/yG7h98J7IpE3kpi+srfFyyB/04OV6pG0" crossorigin="anonymous"></script>
		<!-- Fonts -->
		<link rel="dns-prefetch" href="https://fonts.gstatic.com">
		<link href="https://fonts.googleapis.com/css?family=Raleway:300,400,600" rel="stylesheet" type="text/css">
		<!-- Styles -->
		<link href="{{ asset('css/app.css') }}" rel="stylesheet">
		<link href="{{ asset('css/LetsEvent.css') }}" rel="stylesheet">
		<link href="{{ asset('css/select2.min.css') }}" rel="stylesheet">
	</head>
	<body>
		<div id="app">
			<nav class="navbar navbar-expand-md navbar-light navbar-laravel">
				<div class="container">
					<a class="navbar-brand" href="{{ url('/') }}">
						{{ config('app.name', 'Laravel') }}
					</a>
					<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
						<span class="navbar-toggler-icon"></span>
					</button>

					<div class="collapse navbar-collapse" id="navbarSupportedContent">
						<!-- Left Side Of Navbar -->
						<ul class="navbar-nav mr-auto">

						</ul>

						<!-- Right Side Of Navbar -->
						<ul class="navbar-nav ml-auto">
							<!-- Authentication Links -->
							@guest
							<li><a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a></li>
							<li><a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a></li>
							@else
							<li class="nav-item dropdown">
								@if (Auth()->user()->status == 'ban')
									<a class="dropdown-item" href="{{ route('logout') }}"
									   onclick="event.preventDefault();
										document.getElementById('logout-form').submit();">
										{{ __('Logout') }}
									</a>  									
								@else
									<a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
										{{ Auth::user()->firstname }} {{ Auth::user()->lastname }}
										@if (Auth::user()->status == 'warning') 
										<i class="fas fa-exclamation-circle" style="color: red"></i>
										@endif
										<span class="caret"></span>
									</a>
								@endif

								<div class="dropdown-menu" aria-labelledby="navbarDropdown">
									<a class="dropdown-item" href="{{ route('home') }}" >Home</a>
									@if ( Auth::user()->role == "teacher" ) 
										<a class="dropdown-item" href="{{ route('category.index') }}" >View Categories</a>
										<a class="dropdown-item" href="{{ route('import') }}" >Import CSV</a>
										<a class="dropdown-item" href="{{ route('userIndex') }}" >View Users</a>
									@endif
									<a class="dropdown-item" href="{{ route('eventIndex') }}" >View Events</a>
									<a class="dropdown-item" href="{{ route('logout') }}"
									   onclick="event.preventDefault();
										document.getElementById('logout-form').submit();">
										{{ __('Logout') }}
									</a>  

									<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
										@csrf
									</form>
								</div>
							</li>
							@endguest
						</ul>
					</div>
				</div>
			</nav>
	    <main class="py-4">
			@yield('content')
		</main>
	</div>
</body>
</html>
