@section('title', trans('login.page-title'))

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-lg-push-4 col-md-6 col-md-push-3 col-sm-8 col-sm-push-2">
                <div class="content-box login-form">
                    <h1 class="page-title">{{trans('login.page-title')}}</h1>
                    @if(Session::get('login_errors'))
                        <div class="alert alert-danger alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <h5>{{trans('login.login-error-message')}}</h5>
                        </div>
                    @endif

                    @if(Session::has('password_reset'))
                        <div class="alert alert-success alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <h5>{{trans('login.password-reset-message')}}</h5>
                        </div>
                    @endif

                    {{ Form::open(['route' => 'auth.login']) }}
                        <div class="form-group">
                            {{ Form::label('username', trans('login.username'), [ 'class' => 'control-label' ]) }}
                            {{ Form::text('username', null, ['class'=>'form-control', 'placeholder' => (trans('registration.username') . '...')])}}
                        </div>
                        <div class="form-group">
                            {{ Form::label('password', trans('login.password'), [ 'class' => 'control-label' ]) }}
                            {{ Form::password('password', ['class'=>'form-control', 'placeholder'=> (trans('login.password') . '...')])}}
                        </div>
                        <div class="checkbox">
                            <label>
                                {{ Form::checkbox('remember') }} {{trans('login.remember')}}
                            </label>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary btn-block btn-login">{{trans('login.submit')}}</button>
                        </div>
                    {{ Form::close() }}

                    <p class="text-center" style="margin-top:10px;">OR</p>
                    <a class="btn btn-default btn-block btn-login-github" href="{{url('login/github')}}"><i class="fa fa-github"></i> {{trans('login.login-github')}}</a>
                    <ul class="nav nav-list">
                        <li class="text-center"><a href="{{ url('password/remind') }}">{{trans('login.forgot-password')}}</a></li>
                        <li class="text-center"><a href="{{ url('register') }}">{{trans('login.register')}}</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@stop
