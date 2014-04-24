@section('title', trans('tricks.trick'))

@section('styles')
	<link rel="stylesheet" href="{{ URL::asset('css/highlight/laratricks.css') }}">
	<link rel="stylesheet" href="{{ URL::asset('js/selectize/css/selectize.bootstrap3.css') }}">
	<style type="text/css">
    #editor-content {
      position: relative;
      top: 0;
      right: 0;
      bottom: 0;
      left: 0;
      height: 300px;
      -webkit-border-radius: 4px;
      -moz-border-radius: 4px;
      border-radius: 4px;
      border: 1px solid #cccccc;
    }
    </style>
@stop

@section('scripts')
	<script type="text/javascript" src="{{url('js/selectize/js/standalone/selectize.min.1.js')}}"></script>
	<script src="http://d1n0x3qji82z53.cloudfront.net/src-min-noconflict/ace.js"></script>
	<script type="text/javascript" src="{{ asset('js/trick-new-edit.min.1.js') }}"></script>
@stop

@section('content')
	<div class="container">
		<div class="row">
			<div class="col-lg-8 col-lg-push-2 col-md-8 col-md-push-2 col-sm-12 col-xs-12">
				<div class="content-box">
					<h1 class="page-title">
						{{ trans('tricks.creating_new_trick') }}
					</h1>
					@if(Session::get('errors'))
					    <div class="alert alert-danger alert-dismissable">
					        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					         <h5>{{ trans('tricks.errors_while_creating') }}</h5>
					         @foreach($errors->all('<li>:message</li>') as $message)
					            {{$message}}
					         @endforeach
					    </div>
					@endif
					{{ Form::open(array('class'=>'form-vertical','id'=>'save-trick-form','role'=>'form'))}}
					    <div class="form-group">
					    	<label for="title">{{ trans('tricks.title') }}</label>
					    	{{Form::text('title', null, array('class'=>'form-control','placeholder'=>trans('tricks.title_placeholder') ));}}
					    </div>
					    <div class="form-group">
					    	<label for="description">{{ trans('tricks.description') }}</label>
					    	{{Form::textarea('description',null, array('class'=>'form-control','placeholder'=>trans('tricks.trick_description_placeholder'),'rows'=>'3'));}}
					    </div>
					    <div class="form-group">
					      <label>{{ trans('tricks.trick_code') }}</label>
					      <div id="editor-content" class="content-editor"></div>
					      {{Form::textarea('code', null, ['id'=>'code-editor','style'=>'display:none;']);}}
					    </div>
					    <div class="form-group">
					    	<p>{{ Form::select('tags[]', $tagList, null, array('multiple','id'=>'tags','placeholder'=>trans('tricks.tag_trick_placeholder'),'class' => 'form-control')); }}</p>
					    </div>
					    <div class="form-group">
					    	<p>{{ Form::select('categories[]', $categoryList, null, array('multiple','id'=>'categories','placeholder'=>trans('tricks.categorize_trick_placeholder'),'class' => 'form-control')); }}</p>
					    </div>
					    <div class="form-group">
					        <div class="text-right">
					          <button type="submit"  id="save-section" class="btn btn-primary ladda-button" data-style="expand-right">
					            {{ trans('tricks.save_trick') }}
					          </button>
					        </div>
					    </div>
					{{Form::close()}}
				</div>
			</div>
		</div>
	</div>
@stop
