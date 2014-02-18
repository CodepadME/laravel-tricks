@section('title','Editing category')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-lg-6"> 
			<div class="page-header">
			  	<h1>Editing a category <a href="{{ url('admin/categories')}}" class="btn btn-lg btn-default pull-right">Cancel</a></h1>
			</div>

            @if($errors->all())
                <div class="bs-callout bs-callout-danger">
                    <h4>Please fix the errors below:</h4>
                    {{ HTML::ul($errors->all())}}
                </div>
            @endif

			{{ Form::model($category,array('class'=>'form-horizontal'))}}
        	<div class="form-group">
        	    <label for="name" class="col-lg-2 control-label">Name</label>
        	    <div class="col-lg-10">
        	    	{{ Form::text('name',null,array('class'=>'form-control'))}}
        	    </div>
        	</div>
            <div class="form-group">
                <label for="description" class="col-lg-2 control-label">Description</label>
                <div class="col-lg-10">
                    {{ Form::textarea('description',null,array('class'=>'form-control','rows'=>'5'))}}
                </div>
            </div>
        	<div class="form-group">
        		<div class="col-lg-10 col-lg-offset-2">
        		{{ Form::submit('Save category',array('class'=>'btn btn-primary btn-block')); }}
        		</div>
        	</div>
        	{{ Form::close()}}
	    </div>
	</div>
</div>
@stop