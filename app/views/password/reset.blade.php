@section('title', 'Resetting password')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-lg-push-4 col-md-6 col-md-push-3 col-sm-8 col-sm-push-2">
                <div class="content-box login-form">
                    <h1 class="page-title">Resetting password</h1>

                    @if(Session::has('error'))
                        <div class="alert alert-danger alert-dismissable">
                          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                          The password reset token or email is invalid
                        </div>
                    @endif

                    {{ Form::open(['route' => 'auth.reset']) }}
                        {{ Form::hidden('token', $token) }}

                        <div class="form-group">
                            {{ Form::label('email', 'Email', [ 'class' => 'control-label' ]) }}
                            {{ Form::text('email', null, ['class'=>'form-control', 'placeholder' => 'E-Mail'])}}
                        </div>
                        <div class="form-group">

                            {{ Form::password('password', array('class'=>'form-control middle','placeholder'=>'New Password'))}}
                        </div>
                        <div class="form-group">
                            {{ Form::password('password_confirmation', array('class'=>'form-control bottom','placeholder'=>'Confirm New Password'))}}
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary btn-block btn-login">Reset password</button>
                        </div>
                    {{ Form::close() }}

                    <ul class="nav nav-list">
                        <li class="text-center"><a href="{{ url('login') }}">Remembered password? Login</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@stop
