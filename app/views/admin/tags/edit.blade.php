@section('title','Editing tag')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-lg-6"> 
			<div class="page-header">
			  	<h1>Editing a tag <a href="{{ url('admin/tags')}}" class="btn btn-lg btn-default pull-right">Cancel</a></h1>
			</div>
            @if($errors->all())
                <div class="bs-callout bs-callout-danger">
                    <h4>Please fix the errors below:</h4>
                    {{ HTML::ul($errors->all())}}
                </div>
            @endif

			{{ Form::model($tag,array('class'=>'form-horizontal'))}}
        	<div class="form-group">
        	    <label for="name" class="col-lg-2 control-label">Name</label>
        	    <div class="col-lg-10">
        	    	{{ Form::text('name',$tag->name,array('class'=>'form-control'))}}
        	    </div>
        	</div>
        	<div class="form-group">
        		<div class="col-lg-10 col-lg-offset-2">
        		{{ Form::submit('Save tag',array('class'=>'btn btn-primary btn-block')); }}
        		</div>
        	</div>
        	{{ Form::close()}}
	    </div>
	</div>
</div>
@stop