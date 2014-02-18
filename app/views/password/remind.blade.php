@section('title', 'Reset password')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-lg-push-4 col-md-6 col-md-push-3 col-sm-8 col-sm-push-2">
                <div class="content-box login-form">
                    <h1 class="page-title">Reset password</h1>

                    @if(Session::has('success'))
                      <div class="alert alert-success alert-dismissable">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        An e-mail with the password reset link has been sent.
                      </div>
                    @endif

                    {{ Form::open(['route' => 'auth.remind']) }}
                        <div class="form-group">
                            {{ Form::label('email', 'Email', [ 'class' => 'control-label' ]) }}
                            {{ Form::text('email', null, ['class'=>'form-control', 'placeholder' => 'E-mail to send password reminder...'])}}
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
