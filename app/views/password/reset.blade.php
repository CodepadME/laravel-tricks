@section('title', trans('password.resetting_password'))

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-lg-push-4 col-md-6 col-md-push-3 col-sm-8 col-sm-push-2">
                <div class="content-box login-form">
                    <h1 class="page-title">{{ trans('password.resetting_password') }}</h1>

                    @if(Session::has('error'))
                        <div class="alert alert-danger alert-dismissable">
                          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                          {{ trans('password.invalid_password_or_mail') }}
                        </div>
                    @endif

                    {{ Form::open(['route' => 'auth.reset']) }}
                        {{ Form::hidden('token', $token) }}

                        <div class="form-group">
                            {{ Form::label('email', trans('password.email'), [ 'class' => 'control-label' ]) }}
                            {{ Form::text('email', null, ['class'=>'form-control', 'placeholder' => trans('password.email_reset_placeholder')])}}
                        </div>
                        <div class="form-group">

                            {{ Form::password('password', array('class'=>'form-control middle','placeholder'=>trans('password.new_password')))}}
                        </div>
                        <div class="form-group">
                            {{ Form::password('password_confirmation', array('class'=>'form-control bottom','placeholder'=>trans('password.confirm_password')))}}
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary btn-block btn-login">{{ trans('password.reset') }}</button>
                        </div>
                    {{ Form::close() }}

                    <ul class="nav nav-list">
                        <li class="text-center"><a href="{{ url('login') }}">{{ trans('password.remember_password') }}</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@stop
