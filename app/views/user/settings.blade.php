@section('title', trans('user.settings'))

@section('styles')
<link rel="stylesheet" href="{{ URL::asset('css/jquery.Jcrop.min.1.css') }}">
@stop

@section('scripts')
<script type="text/javascript">
  var FileAPI = {
          debug: false
          , staticPath: "{{ url('js/vendor/uploader') }}/"
          , postNameConcat: function (name, idx){
        return  name + (idx != null ? '['+ idx +']' : '');
      }
  };
</script>
<script src="{{ asset('js/vendor/uploader/FileAPI.min.js') }}"></script>
<script src="{{ asset('js/vendor/uploader/FileAPI.exif.js') }}"></script>
<script src="{{ asset('js/vendor/uploader/jquery.fileapi.js') }}"></script>
<script src="{{ asset('js/vendor/uploader/jquery.Jcrop.min.js') }}"></script>

<script type="text/javascript">
jQuery(function ($){
  $('#cropper-preview').on('click', '.js-upload', function (){
     $('#upload-avatar').fileapi('upload');
     $('#cropper-preview').fadeOut();
  });
  $('#upload-avatar').fileapi({
     url: '{{ route("user.avatar") }}',
     accept: 'image/*',
     data: { _token: "{{ csrf_token() }}" },
     imageSize: { minWidth: 100, minHeight: 100 },
     elements: {
        active: { show: '.js-upload', hide: '.js-browse' },
        preview: {
           el: '.js-preview',
           width: 96,
           height: 96
        },
        progress: '.js-progress'
     },

     onSelect: function (evt, ui){
        var file = ui.all[0];
        if( file ){
          $('#cropper-preview').show();

          $('.js-img').cropper({
             file: file,
             bgColor: '#fff',
             maxSize: [$('#cropper-preview').width()-40, $(window).height()-100],
             minSize: [100, 100],
             selection: '90%',
             aspectRatio: 1,
             onSelect: function (coords){
                $('#upload-avatar').fileapi('crop', file, coords);
             }
          });
        }
     },

    onComplete: function(evt, xhr)
     {
      try {
        var result = FileAPI.parseJSON(xhr.xhr.responseText);
        $('#avatar-hidden').attr("value",result.images.filename);
      } catch (er){
        FileAPI.log('PARSE ERROR:', er.message);
      }
     }
  });
});
</script>
@stop

@section('content')
<div class="container">
  <div class="row push-down">
    <div class="col-lg-8 col-md-6 col-sm-6 col-xs-12">
      <h1 class="page-title">{{ trans('user.user_settings') }}</h1>
    </div>
    <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12 text-right">
      <a href="{{ url('user')}}" class="btn btn-primary">{{ trans('user.back_to_profile') }}</a>
    </div>
  </div>

  <div class="row">
    <div class="col-lg-6 col-lg-push-3 col-md-6 col-md-push-3 col-sm-8 col-sm-push-2 col-xs-12">
      <div class="content-box">

          <h3 class="content-title">{{ trans('user.account_settings') }}</h3>


          @if(Session::has('update_password'))
            <div class="alert alert-info">
              <button type="button" class="close" data-dismiss="alert">&times;</button>
              <strong>{{ trans('user.notice') }}</strong>
              <p>{{ trans('user.notice_password') }}</p>
            </div>
          @endif
          @if(Session::has('settings_updated'))
            <div class="alert alert-success">
              <button type="button" class="close" data-dismiss="alert">&times;</button>
	      {{ trans('user.settings_updated') }}              
            </div>
          @endif
          @if(Session::get('errors'))
            <div class="alert alert-danger alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            @foreach($errors->all('<li>:message</li>') as $message)
              {{$message}}
            @endforeach
            </div>
          @endif
          {{ Form::open(array('role'=>'form','id'=>'loginform','class'=>'form-horizontal'))}}
          <fieldset>
            <div class="form-group {{Session::get('username_required')? 'has-error': ''}}">
              <label for="username" class="col-lg-4 control-label">{{ trans('user.username') }}</label>
              <div class="col-lg-8">
                {{ Form::text('username', Auth::user()->username, array('class'=>'form-control','placeholder'=>'Username'))}}
                @if(Session::get('username_required'))
                  <span class="help-block">{{ trans('user.github_user_already_taken') }}</span>
                @endif
              </div>

            </div>
            <div class="form-group">
              <label for="email" class="col-lg-4 control-label">{{ trans('user.email') }}</label>
              <div class="col-lg-8">
                <input type="email" disabled class="form-control" id="email" placeholder="{{Auth::user()->email}}">
              </div>
            </div>

            <div class="form-group">
              <label for="avatar" class="col-lg-4 control-label">{{ trans('user.profile_picture') }}</label>
              <div class="col-lg-8">
                <input type="hidden" id="avatar-hidden" name="avatar" value="">
                <div id="upload-avatar" class="upload-avatar">
                  <div class="userpic" style="background-image: url('{{{ Auth::user()->photocss}}}');">
                     <div class="js-preview userpic__preview"></div>
                  </div>
                  <div class="btn btn-sm btn-primary js-fileapi-wrapper">
                     <div class="js-browse">
                        <span class="btn-txt">{{ trans('user.choose') }}</span>
                        <input type="file" name="filedata">
                     </div>
                     <div class="js-upload" style="display: none;">
                        <div class="progress progress-success"><div class="js-progress bar"></div></div>
                        <span class="btn-txt">{{ trans('user.uploading') }}</span>
                     </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="form-group">
              <label for="password" class="col-lg-4 control-label">{{ trans('user.password') }}</label>
              <div class="col-lg-8">
                {{ Form::password('password', array('class'=>'form-control','placeholder'=> trans('user.new_password')))}}
              </div>
            </div>
            <div class="form-group">
              <label for="password_confirmation" class="col-lg-4 control-label">{{ trans('user.confirm_password') }}</label>
              <div class="col-lg-8">
                {{ Form::password('password_confirmation', array('class'=>'form-control','placeholder'=>trans('user.confirm_password')))}}
              </div>
            </div>
            <div class="form-group">
              <div class="col-lg-offset-7 col-lg-12">
                <input class="btn btn-sm" type="reset" value="{{ trans('user.reset_form') }}">
                <input class="btn btn-primary" type="submit" value="{{ trans('user.update') }}">
              </div>
             </div>
          </fieldset>
          {{ Form::close() }}
      </div>
    </div>

    <div class="col-md-7">
     <div id="cropper-preview" style="display:none;">
       <div class="panel panel-info">
         <div class="panel-heading">
           <h3 class="panel-title">{{ trans('user.crop_picture') }}</h3>
         </div>
         <div class="panel-body">
           <div class="js-img"></div>
           <p>
             <div class="js-upload btn btn-primary">{{ trans('user.upload') }}</div>
           </p>
         </div>
       </div>
     </div>
    </div>

  </div>
</div>
@stop
