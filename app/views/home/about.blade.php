@section('title','About Laravel-Tricks website')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-6 col-md-offset-3">
			<h1 class="text-center">About Laravel tricks </h1>
			<div class="row">
				<div class="col-md-6">
					<h2>What is this</h2>
					<p>Laravel Tricks was created to help <a href="http://laravel.com" target="_blank">Laravel</a> community find and share interesting ways of using <a href="http://laravel.com" target="_blank">Laravel</a> framework</p>

					<p>The idea is simple: When you work with Laravel long enough you find some cool ways of using it, and to other people they might seem as &quot;tricks&quot; so we thought to create a centralized place for all Laravel users to share those findings.</p>
				</div>

				<div class="col-md-6">
					<h2>Who?</h2>
					<p>Laravel Tricks website was created by <a target="_blank" href="http://twitter.com/stidges">Stidges</a> and <a target="_blank" href="http://twitter.com/msurguy">Maks Surguy</a>  in November 2013</p>

					<h3>Want the source?</h3>
					The source of this website is available on <a target="_blank" href="https://github.com/CodepadME/laravel-tricks" title="Get the source of this site">Github</a>.
				</div>
			</div>
			<div class="row">
				<div class="col-md-12 text-center">
					<h2>Share &amp; follow</h2>
					<p>
						<a href="#" class="btn btn-info btn-lg" onclick="window.open(
		                      'https://twitter.com/share?url='+encodeURIComponent('{{url('/')}}')+'&amp;text='+encodeURIComponent('Tips and Tricks for @laravelphp from @laraveltricks #php #dev #tips') + '&amp;count=none/',
		                      'twitter-share-dialog',
		                      'width=626,height=436,top='+((screen.height - 436) / 2)+',left='+((screen.width - 626)/2 ));
		                    return false;">
		                  <i class="fa fa-twitter"></i> Share on Twitter
		                </a>

		                <a href="#" class="btn btn-lg btn-primary" style="border-color: #4B7FCC; color: #428bca;" onclick="window.open(
                              'https://www.facebook.com/sharer/sharer.php?u='+encodeURIComponent('{{url('/')}}') +'&amp;t=' + encodeURIComponent('Useful Tips and Tricks for Laravel PHP framework'),
                              'facebook-share-dialog',
                              'width=626,height=436,top='+((screen.height - 436) / 2)+',left='+((screen.width - 626)/2 ));
                            return false;">
                          <i class="fa fa-facebook"></i> Share on Facebook
                        </a>
					</p>
				</div>
			</div>
		</div>
	</div>
</div>
@stop



