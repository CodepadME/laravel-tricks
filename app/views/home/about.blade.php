@section('title', trans('home.about_tricks_website'))

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-6 col-md-offset-3">
			<h1 class="text-center">{{ trans('home.about_title') }}</h1>
			<div class="row">
				<div class="col-md-6">
					{{ trans('home.about_what_is_this') }}
				</div>

				<div class="col-md-6">
					{{ trans('home.about_who') }}
				</div>
			</div>
			<div class="row">
				<div class="col-md-12 text-center">
					<h2>{{ trans('home.share_title') }}</h2>
					<p>
						<a href="#" class="btn btn-info btn-lg" onclick="window.open(
		                      'https://twitter.com/share?url='+encodeURIComponent('{{url('/')}}')+'&amp;text='+encodeURIComponent('{{ trans('home.twitter_text') }}') + '&amp;count=none/',
		                      'twitter-share-dialog',
		                      'width=626,height=436,top='+((screen.height - 436) / 2)+',left='+((screen.width - 626)/2 ));
		                    return false;">
		                  <i class="fa fa-twitter"></i> {{ trans('home.share_twitter') }}
		                </a>

		                <a href="#" class="btn btn-lg btn-primary" style="border-color: #4B7FCC; color: #428bca;" onclick="window.open(
                              'https://www.facebook.com/sharer/sharer.php?u='+encodeURIComponent('{{url('/')}}') +'&amp;t=' + encodeURIComponent('{{ trans('home.facebook_text') }}'),
                              'facebook-share-dialog',
                              'width=626,height=436,top='+((screen.height - 436) / 2)+',left='+((screen.width - 626)/2 ));
                            return false;">
                          <i class="fa fa-facebook"></i> {{ trans('home.share_facebook') }}
                        </a>
					</p>
				</div>
			</div>
		</div>
	</div>
</div>
@stop



