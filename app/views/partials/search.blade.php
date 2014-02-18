{{ Form::open(['url'=>'search','method'=>'GET']);}}
	<input type="text" name="q" class="search-box form-control" placeholder="Search..." value="{{{isset($term) ? $term : ''}}}">
	<input style="display:none;" type="submit" value="search">
{{ Form::close()}}
