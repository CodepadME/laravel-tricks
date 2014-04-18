@section('title', trans('home.login'))

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-lg-push-4 col-md-6 col-md-push-3 col-sm-8 col-sm-push-2">
                <div class="content-box login-form">
                    <h1 class="page-title">{{ trans('home.login_title') }}</h1>
                    @if(Session::get('login_errors'))
                        <div class="alert alert-danger alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <h5>{{ trans('home.email_or_password_incorrect') }}</h5>
                        </div>
                    @endif

                    @if(Session::has('password_reset'))
                        <div class="alert alert-success alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
			    <h5>{{ trans('home.password_has_been_reset') }}</h5>
                        </div>
                    @endif

                    {{ Form::open(['route' => 'auth.login']) }}
                        <div class="form-group">
                            {{ Form::label('username', 'Username', [ 'class' => 'control-label' ]) }}
                            {{ Form::text('username', null, ['class'=>'form-control', 'placeholder' => trans('home.username_placeholder')])}}
                        </div>
                        <div class="form-group">
                            {{ Form::label('password', 'Password', [ 'class' => 'control-label' ]) }}
                            {{ Form::password('password', ['class'=>'form-control', 'placeholder'=>trans('home.password_placeholder')])}}
                        </div>
                        <div class="checkbox">
                            <label>
                                {{ Form::checkbox('remember') }} {{ trans('home.remember_me') }}
                            </label>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary btn-block btn-login">{{ trans('home.login') }}</button>
                        </div>
                    {{ Form::close() }}

                    <p class="text-center" style="margin-top:10px;">OR</p>
                    <a class="btn btn-default btn-block btn-login-github" href="{{url('login/github')}}"><i class="fa fa-github"></i> {{ trans('home.login_with_github') }}</a>
                    <ul class="nav nav-list">
                        <li class="text-center"><a href="{{ url('password/remind') }}">{{ trans('home.forgot_your_password') }}</a></li>
                        <li class="text-center"><a href="{{ url('register') }}">{{ trans('home.do_not_have_account_yet') }}</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@stop
