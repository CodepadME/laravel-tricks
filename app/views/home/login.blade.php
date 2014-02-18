@section('title', 'Login')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-lg-push-4 col-md-6 col-md-push-3 col-sm-8 col-sm-push-2">
                <div class="content-box login-form">
                    <h1 class="page-title">Login</h1>
                    @if(Session::get('login_errors'))
                        <div class="alert alert-danger alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <h5>E-mail or password was incorrect, please try again</h5>
                        </div>
                    @endif

                    @if(Session::has('password_reset'))
                        <div class="alert alert-success alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <h5>Your password has been reset, please log in</h5>
                        </div>
                    @endif

                    {{ Form::open(['route' => 'auth.login']) }}
                        <div class="form-group">
                            {{ Form::label('username', 'Username', [ 'class' => 'control-label' ]) }}
                            {{ Form::text('username', null, ['class'=>'form-control', 'placeholder' => 'Username...'])}}
                        </div>
                        <div class="form-group">
                            {{ Form::label('password', 'Password', [ 'class' => 'control-label' ]) }}
                            {{ Form::password('password', ['class'=>'form-control', 'placeholder'=>'Password...'])}}
                        </div>
                        <div class="checkbox">
                            <label>
                                {{ Form::checkbox('remember') }} Remember me
                            </label>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary btn-block btn-login">Login</button>
                        </div>
                    {{ Form::close() }}

                    <p class="text-center" style="margin-top:10px;">OR</p>
                    <a class="btn btn-default btn-block btn-login-github" href="{{url('login/github')}}"><i class="fa fa-github"></i> Login with Github</a>
                    <ul class="nav nav-list">
                        <li class="text-center"><a href="{{ url('password/remind') }}">Forgot your password?</a></li>
                        <li class="text-center"><a href="{{ url('register') }}">Don't have an account yet?</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@stop
