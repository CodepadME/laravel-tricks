@section('title', trans('tricks.trick'))

@section('styles')
	<link rel="stylesheet" href="{{ URL::asset('js/selectize/css/selectize.bootstrap3.css') }}">
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
					@if(Auth::check() && (Auth::user()->id == $trick->user_id))
						<div class="pull-right">
							<a data-toggle="modal" href="#deleteModal">{{ trans('tricks.delete') }}</a>
							@include('tricks.delete',['link'=>$trick->deleteLink])
						</div>
					@endif
					<h1 class="page-title">
						{{ trans('tricks.editing_trick') }}
					</h1>
					@if(Session::get('errors'))
					    <div class="alert alert-danger alert-dismissable">
					        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					         <h5>{{ trans('tricks.errors_while_editing') }}</h5>
					         @foreach($errors->all('<li>:message</li>') as $message)
					            {{$message}}
					         @endforeach
					    </div>
					@endif
					@if(Session::has('success'))
					    <div class="alert alert-success alert-dismissable">
					        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					         <h5>{{ Session::get('success') }}</h5>
					    </div>
					@endif
					{{ Form::open(array('class'=>'form-vertical','id'=>'save-trick-form','role'=>'form'))}}
					    <div class="form-group">
					    	<label for="title">{{ trans('tricks.title') }}</label>
					    	{{Form::text('title', $trick->title, array('class'=>'form-control','placeholder'=>trans('tricks.title_placeholder')));}}
					    </div>
					    <div class="form-group">
					    	<label for="description">{{ trans('tricks.description') }}</label>
					    	{{Form::textarea('description',$trick->description, array('class'=>'form-control','placeholder'=>trans('tricks.trick_description_placeholder'),'rows'=>'3'));}}
					    </div>
					    <div class="form-group">
					      <label>{{ trans('tricks.trick_code') }}</label>
					      <div id="editor-content" class="content-editor"></div>
					      {{Form::textarea('code', $trick->code, ['id'=>'code-editor','style'=>'display:none;']);}}
					    </div>
					    <div class="form-group">
					    	{{ Form::select('tags[]', $tagList, $selectedTags, array('multiple','id'=>'tags','placeholder'=>trans('tricks.tag_trick_placeholder'),'class' => 'form-control')); }}
					    </div>
					    <div class="form-group">
					    	{{ Form::select('categories[]', $categoryList, $selectedCategories, array('multiple','id'=>'categories','placeholder'=>trans('tricks.categorize_trick_placeholder'),'class' => 'form-control')); }}
					    </div>
					    <div class="form-group">
					        <div class="text-right">
					          <button type="submit"  id="save-section" class="btn btn-primary ladda-button" data-style="expand-right">
					            {{ trans('tricks.update_trick') }}
					          </button>
					        </div>
					    </div>
					{{Form::close()}}
				</div>
			</div>
		</div>
	</div>
@stop
