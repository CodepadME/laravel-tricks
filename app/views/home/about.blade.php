@section('title', trans('home.about.page-title'))

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-6 col-md-offset-3">
			<h1 class="text-center">{{trans('home.about.title')}}</h1>
			<div class="row">
				<div class="col-md-6">
					<h2>{{trans('home.about.whats')}}</h2>
					{{trans('home.about.whats-comments')}}
				</div>

				<div class="col-md-6">
					<h2>{{trans('home.about.who')}}</h2>
					{{trans('home.about.who-comments')}}

					<h3>{{trans('home.about.source')}}</h3>
					{{trans('home.about.source-comments')}}
				</div>
			</div>
			<div class="row">
				<div class="col-md-12 text-center">
					<h2>{{trans('home.about.share-and-follow')}}</h2>
					<p>
						<a href="#" class="btn btn-info btn-lg" onclick="window.open(
		                      'https://twitter.com/share?url='+encodeURIComponent('{{url('/')}}')+'&amp;text='+encodeURIComponent('Tips and Tricks for @laravelphp from @laraveltricks #php #dev #tips') + '&amp;count=none/',
		                      'twitter-share-dialog',
		                      'width=626,height=436,top='+((screen.height - 436) / 2)+',left='+((screen.width - 626)/2 ));
		                    return false;">
		                  <i class="fa fa-twitter"></i> {{trans('home.about.share-on-twitter')}}
		                </a>

		                <a href="#" class="btn btn-lg btn-primary" style="border-color: #4B7FCC; color: #428bca;" onclick="window.open(
                              'https://www.facebook.com/sharer/sharer.php?u='+encodeURIComponent('{{url('/')}}') +'&amp;t=' + encodeURIComponent('Useful Tips and Tricks for Laravel PHP framework'),
                              'facebook-share-dialog',
                              'width=626,height=436,top='+((screen.height - 436) / 2)+',left='+((screen.width - 626)/2 ));
                            return false;">
                          <i class="fa fa-facebook"></i> {{trans('home.about.share-on-facebook')}}
                        </a>
					</p>
				</div>
			</div>
		</div>
	</div>
</div>
@stop



