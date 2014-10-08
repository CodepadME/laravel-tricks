<div class="navbar navbar-default navbar-static-top">
	<div class="container">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".header-collapse">
				<span class="sr-only">{{ trans('partials.toggle_navigation') }}</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>

			<a class="navbar-brand" href="{{ url('/') }}">
				<img width="207" height="50" src="{{ asset('img/logo@2x.png') }}">
			</a>
		</div>

		<div class="collapse navbar-collapse header-collapse">
			<ul class="nav navbar-nav">

				{{ Navigation::make(Request::path()) }}

				@if(Auth::guest())
					<li class="visible-xs"><a href="{{ url('register') }}">{{ trans('partials.register') }}</a></li>
					<li class="visible-xs"><a href="{{ url('login') }}">{{ trans('partials.login') }}</a></li>
				@else
					<li class="visible-xs"><a href="{{ url('user') }}">{{ trans('partials.my_profile') }}</a></li>
					<li class="visible-xs"><a href="{{ url('logout') }}">{{ trans('partials.logout') }}</a></li>
				@endif

			</ul>

			<div class="navbar-right hidden-xs">
				@if(Auth::guest())
					<a href="{{ url('register') }}" class="btn btn-primary">{{ trans('partials.register') }}</a>
					<a href="{{ url('login') }}" class="btn btn-primary">{{ trans('partials.login') }}</a>
				@else
				<ul class="nav">
					<li class="dropdown {{( Request::segment(2) == 'settings' || Request::segment(2)=='favorites' ? 'active' : false )}}">
					  <a href="#" class="dropdown-toggle btn btn-primary" data-toggle="dropdown">
					  <img src="{{ Auth::user()->photocss }}" width="26px" class="user-avatar-mini"> {{ trans('partials.profile') }}
					  <b class="caret"></b>
					  </a>
					  <ul class="dropdown-menu">
				  	<li class="{{( Request::segment('1') == 'user' && Request::segment('2') == '' ? 'active' : false )}}"><a href="{{ url('user')}}">{{ trans('partials.my_tricks') }}</a></li>
					    <li class="{{( Request::segment('2') == 'favorites' ? 'active' : false )}}"><a href="{{ url('user/favorites')}}">{{ trans('partials.my_favorites') }}</a></li>
					    <li class="{{( Request::segment('2') == 'settings' ? 'active' : false )}}"><a href="{{ url('user/settings')}}">{{ trans('partials.settings') }}</a></li>
					    <li><a href="{{ url('logout')}}">{{ trans('partials.logout') }}</a></li>
					  </ul>
					</li>
				</ul>
				@endif
			</div>
		</div>

	</div>
</div>
