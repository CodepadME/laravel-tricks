@section('title', trans('home.registration'))

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-lg-push-4 col-md-6 col-md-push-3 col-sm-8 col-sm-push-2">
                <div class="content-box register-form">
                    <h1 class="page-title">{{ trans('home.registration') }}</h1>
                    @if(Session::get('errors'))
                        <div class="alert alert-danger alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                             <h5>{{ trans('home.errors_during_registration') }}</h5>
                             @foreach($errors->all('<li>:message</li>') as $message)
                                {{$message}}
                             @endforeach
                        </div>
                    @endif

                    @if(Session::get('github_email_not_verified'))
                        <div class="alert alert-danger alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <h5>{{ trans('home.github_mail_not_verified') }}</h5>
                        </div>
                    @endif

                    {{ Form::open(['route' => 'auth.register']) }}
                        <div class="form-group">
                            {{ Form::label('username', trans('home.username'), ['class'=>'control-label'])}}
                            {{ Form::text('username', null, ['class'=>'form-control','placeholder'=>trans('home.username_placeholder')])}}
                        </div>
                        <div class="form-group">
                            {{ Form::label('email', trans('home.email'), ['class'=>'control-label'])}}
                            {{ Form::text('email', null, ['class'=>'form-control','placeholder'=>trans('home.email_placeholder')])}}
                        </div>
                        <div class="form-group">
                            {{ Form::label('password', trans('home.password'), ['class'=>'control-label'])}}
                            {{ Form::password('password', ['class'=>'form-control','placeholder'=>trans('home.password_placeholder')])}}
                        </div>
                        <div class="form-group">
                            {{ Form::label('password_confirmation', trans('home.confirm_password'), ['class'=>'control-label'])}}
                            {{ Form::password('password_confirmation', ['class'=>'form-control','placeholder'=>trans('home.confirm_password_placeholder')])}}
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary btn-block btn-login">{{ trans('home.register') }}</button>
                        </div>
                    {{ Form::close() }}

                    <p class="text-center" style="margin-top:10px;">{{ trans('home.or') }}</p>
                    <a class="btn btn-default btn-block btn-login-github" href="{{url('login/github')}}"><i class="fa fa-github"></i> {{ trans('home.register_with_github') }}</a>
                    <ul class="nav nav-list">
                        <li class="text-center"><a href="{{ url('login') }}">{{ trans('home.already_have_an_account') }}</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@stop
