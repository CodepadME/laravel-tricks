@section('title', trans('search.search_results_for', array('term' => $term)))

@section('scripts')
<script type="text/javascript">
$(function(){var s=$('.search-box');var t=s.val();s.focus().val('').val(t);});
</script>

@if(count($tricks))
	<script src="{{ asset('js/vendor/masonry.pkgd.min.js') }}"></script>
	<script>
	$(function(){$container=$(".js-trick-container");$container.masonry({gutter:0,itemSelector:".trick-card",columnWidth:".trick-card"});$(".js-goto-trick a").click(function(e){e.stopPropagation()});$(".js-goto-trick").click(function(e){e.preventDefault();var t="{{ route('tricks.show') }}";var n=$(this).data("slug");window.location=t+"/"+n})})
	</script>
@endif
@stop

@section('content')
	<div class="container">
		@if($term != '')
		<div class="row push-down">
			<div class="col-lg-8 col-md-6 col-sm-6 col-xs-12">
				<h1 class="page-title">{{ $tricks->getTotal(); }} Search {{Str::plural('result', count($tricks));}} for &quot;<strong>{{{$term}}}</strong>&quot;</h1>
			</div>
			<div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
				@include('partials.search',['term'=>$term])
			</div>
		</div>

		@include('tricks.grid', ['tricks' => $tricks, 'appends' => [ 'q' => $term ]])

		@else
			<div class="row push-down">
				<div class="col-lg-8 col-md-6 col-sm-6 col-xs-12">
					<h1 class="page-title">{{ trans('search.please_provide_search_term') }}</h1>
				</div>
				<div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
					@include('partials.search')
				</div>
			</div>
		@endif
	</div>
@stop
