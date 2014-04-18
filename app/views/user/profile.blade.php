@section('title', trans('user.profile'))

@section('content')
<div class="container">
	@if(Session::has('first_use'))
	  <div class="alert alert-success alert-dismissable text-center">
		<button type="button" class="close" data-dismiss="alert">&times;</button>
		<h4>Welcome to Laravel tricks!</h4>
		<p>Explore the tricks, create and share some of your own!</p>
	  </div>
	@endif

	@if(Session::has('success'))
	    <div class="alert alert-success alert-dismissable">
	        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
	         <h5>{{ Session::get('success') }}</h5>
	    </div>
	@endif

	<div class="row push-down">
		<div class="col-lg-8 col-md-6 col-sm-6 col-xs-12">
			<h1 class="page-title">My tricks </h1>
		</div>
		<div class="col-lg-4 col-md-6 col-sm-6 col-xs-12 text-right">
			<a href="{{ url('user/tricks/new')}}" class="btn btn-primary"><span class="glyphicon glyphicon-plus"></span> Create new</a>
		</div>
	</div>

	@include('tricks.grid', [ 'tricks' => $tricks ])
</div>
@stop
