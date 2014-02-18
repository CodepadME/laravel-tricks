@section('title', $user->fullName)

@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <div class="content-box">
                <div class="trick-user">
                    <div class="trick-user-image">
                        <img src="{{ $user->photocss }}" class="user-avatar">
                    </div>
                    <div class="trick-user-data">
                        <h1 class="page-title">
                            {{ $user->fullName }}
                        </h1>
                        <div class="text-muted">
                            <b>Joined:</b> {{ $user->created_at->diffForHumans() }}
                        </div>
                    </div>
                </div>
                <table>
                    <tr>
                        <th>Total tricks:</th>
                        <td>{{ count($tricks) }}</td>
                    </tr>
                    <tr>
                        <th width="140">Last trick:</th>
                        <td>{{ $user->lastActivity($tricks) }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <div class="row push-down">
        <div class="col-lg-12">
            <h1 class="page-title">Submitted tricks</h1>
        </div>
    </div>

    @include('tricks.grid', [ 'tricks' => $tricks ])
</div>


@stop
