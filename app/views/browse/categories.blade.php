@section('title', trans('browse.categories'))

@section('content')
    <div class="container">
        <div class="row push-down">
            <div class="col-lg-8 col-md-6 col-sm-6 col-xs-12">
                <h1 class="page-title">{{ trans('browse.categories') }}</h1>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
                @include('partials.search')
            </div>
        </div>

        <div class="row">
            <div class="col-lg-6 col-lg-push-3 col-md-6 col-md-push-3 col-sm-8 col-sm-push-2">
                <div class="content-box">
                    <ul class="nav nav-list">
                        @foreach($categories as $category)
                            <li>
                                <a href="{{ route('tricks.browse.category', $category->slug) }}">
                                    {{ $category->name }}
                                    <span class="text-muted pull-right">{{$category->trick_count}}</span>
                                </a>

                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>

    </div>
@stop
