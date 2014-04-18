<div class="row js-trick-container">
	@if($tricks->count())
		@foreach($tricks as $trick)
			@include('tricks.card', [ 'trick' => $trick ])
		@endforeach
	@else
		<div class="col-lg-12">
			<div class="alert alert-danger">
				{{ trans('tricks.no_tricks_found') }}				
			</div>
		</div>
	@endif
</div>
@if($tricks->count())
	<div class="row">
	    <div class="col-md-12 text-center">
	    	@if(isset($appends))
	        	{{ $tricks->appends($appends)->links(); }}
	        @else
				{{ $tricks->links(); }}
	        @endif
	    </div>
	</div>
@endif

@section('scripts')
	@if(count($tricks))
		<script src="{{ asset('js/vendor/masonry.pkgd.min.js') }}"></script>
		<script>
$(function(){$container=$(".js-trick-container");$container.masonry({gutter:0,itemSelector:".trick-card",columnWidth:".trick-card"});$(".js-goto-trick a").click(function(e){e.stopPropagation()});$(".js-goto-trick").click(function(e){e.preventDefault();var t="{{ route('tricks.show') }}";var n=$(this).data("slug");window.location=t+"/"+n})})
		</script>
	@endif
@stop
