@section('title', trans('home.login.page-title'))

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-lg-push-4 col-md-6 col-md-push-3 col-sm-8 col-sm-push-2">
                <div class="content-box login-form">
                    <h1 class="page-title">{{trans('home.login.page-title')}}</h1>
                    @if(Session::get('home.login_errors'))
                        <div class="alert alert-danger alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <h5>{{trans('home.login.login-error-message')}}</h5>
                        </div>
                    @endif

                    @if(Session::has('password_reset'))
                        <div class="alert alert-success alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <h5>{{trans('home.login.password-reset-message')}}</h5>
                        </div>
                    @endif

                    {{ Form::open(['route' => 'auth.login']) }}
                        <div class="form-group">
                            {{ Form::label('username', trans('home.login.username'), [ 'class' => 'control-label' ]) }}
                            {{ Form::text('username', null, ['class'=>'form-control', 'placeholder' => (trans('home.login.username') . '...')])}}
                        </div>
                        <div class="form-group">
                            {{ Form::label('password', trans('home.login.password'), [ 'class' => 'control-label' ]) }}
                            {{ Form::password('password', ['class'=>'form-control', 'placeholder'=> (trans('home.login.password') . '...')])}}
                        </div>
                        <div class="checkbox">
                            <label>
                                {{ Form::checkbox('remember') }} {{trans('home.login.remember')}}
                            </label>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary btn-block btn-login">{{trans('home.login.submit')}}</button>
                        </div>
                    {{ Form::close() }}

                    <p class="text-center" style="margin-top:10px;">OR</p>
                    <a class="btn btn-default btn-block btn-login-github" href="{{url('login/github')}}"><i class="fa fa-github"></i> {{trans('home.login.login-github')}}</a>
                    <ul class="nav nav-list">
                        <li class="text-center"><a href="{{ url('password/remind') }}">{{trans('home.login.forgot-password')}}</a></li>
                        <li class="text-center"><a href="{{ url('register') }}">{{trans('home.login.register')}}</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@stop
