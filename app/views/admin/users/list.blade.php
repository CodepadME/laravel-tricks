@section('title','Viewing users')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-lg-12">
			<div class="page-header">
				<h1>Showing all users ({{ $users->getTotal() }})</h1>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-12">
			<table class="table">
			   	<thead>
			    	<tr>
				     	<th>Avatar</th>
						<th>Username</th>
						<th>Email</th>
						<th>Tricks</th>
						<th>Date Registered</th>
						<th>Github Profile?</th>
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
