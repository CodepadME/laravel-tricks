@section('title', trans('home.welcome'))

@section('content')
	<div class="container">
		<div class="row push-down">
			<div class="col-lg-8 col-md-6 col-sm-6 col-xs-12">
				<h1 class="page-title">{{ trans('home.latest_tricks') }}</h1>
			</div>
			<div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
				@include('partials.search')
			</div>
		</div>

		@include('tricks.grid', ['tricks' => $tricks])
	</div>
@stop
