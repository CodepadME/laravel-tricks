@section('title', trans('admin.viewing_users'))

@section('content')
<div class="container">
	<div class="row">
		<div class="col-lg-12">
			<div class="page-header">
				<h1>{{ trans('admin.showing_all_users') }} ({{ $users->getTotal() }})</h1>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-12">
			<table class="table">
			   	<thead>
			    	<tr>
				     	<th>{{ trans('admin.avatar') }}</th>
						<th>{{ trans('admin.username') }}</th>
						<th>{{ trans('admin.email') }}</th>
						<th>{{ trans('admin.tricks') }}</th>
						<th>{{ trans('admin.date_registered') }}</th>
						<th>{{ trans('admin.github_profile') }}</th>
			    	</tr>
			   	</thead>
			   	<tbody>
				  	@foreach($users as $user)
				    <tr>
				    	<td><img src="{{ $user->photocss }}" class="img-rounded" style="width:40px; height:40px;"></td>
				        <td><a href="{{url($user->username)}}" target="_blank">{{$user->username}}</a></td>
				       	<td>{{$user->email}}</td>
				       	<td>{{count($user->tricks)}}</td>
				       	<td>{{$user->created_at}}</td>
				       	<td>{{$user->profile ? 'yes' : 'no'}}</td>
				     </tr>
				    @endforeach
			    </tbody>
			</table>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-12">
			<div class="text-center">{{ $users->links(); }}</div>
		</div>
	</div>
</div>
@stop
