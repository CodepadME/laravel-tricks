@section('title', 'Registration')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-lg-push-4 col-md-6 col-md-push-3 col-sm-8 col-sm-push-2">
                <div class="content-box register-form">
                    <h1 class="page-title">Registration</h1>
                    @if(Session::get('errors'))
                        <div class="alert alert-danger alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                             <h5>There were errors during registration:</h5>
                             @foreach($errors->all('<li>:message</li>') as $message)
                                {{$message}}
                             @endforeach
                        </div>
                    @endif

                    @if(Session::get('github_email_not_verified'))
                        <div class="alert alert-danger alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <h5>You don't have any verified emails in your Github profile, please register using email</h5>
                        </div>
                    @endif

                    {{ Form::open(['route' => 'auth.register']) }}
                        <div class="form-group">
                            {{ Form::label('username', 'Username', ['class'=>'control-label'])}}
                            {{ Form::text('username', null, ['class'=>'form-control','placeholder'=>'Username'])}}
                        </div>
                        <div class="form-group">
                            {{ Form::label('email', 'E-mail', ['class'=>'control-label'])}}
                            {{ Form::text('email', null, ['class'=>'form-control','placeholder'=>'E-mail'])}}
                        </div>
                        <div class="form-group">
                            {{ Form::label('password', 'Password', ['class'=>'control-label'])}}
                            {{ Form::password('password', ['class'=>'form-control','placeholder'=>'Password'])}}
                        </div>
                        <div class="form-group">
                            {{ Form::label('password_confirmation', 'Confirm Password', ['class'=>'control-label'])}}
                            {{ Form::password('password_confirmation', ['class'=>'form-control','placeholder'=>'Confirm Password'])}}
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary btn-block btn-login">Register</button>
                        </div>
                    {{ Form::close() }}

                    <p class="text-center" style="margin-top:10px;">OR</p>
                    <a class="btn btn-default btn-block btn-login-github" href="{{url('login/github')}}"><i class="fa fa-github"></i> Register with Github</a>
                    <ul class="nav nav-list">
                        <li class="text-center"><a href="{{ url('login') }}">Already have an account?</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@stop
