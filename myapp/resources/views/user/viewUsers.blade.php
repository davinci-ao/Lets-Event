@extends('layouts.app')

@section('content')
<div class="container">

	@if(Session::has('message'))
		@if(Session::has('positive'))
			<div class="alert alert-success hideMsg">
		@else 
			<div class="alert alert-danger hideMsg">
		@endif		
			{{ Session('message') }}
		</div>
	@endif
			
	<div class="row justify-content-center">
		<div class="col-md-8">
			<div class="card">
				<div class="card-header" ><h1 class='headEventName'>Users</h1></div>
				<div class="card-body">
					<table class="table">
						<thead>
							<tr>
								<th>Name</th>
								<th>Options</th>
							</tr>
						</thead>
						<tbody>
							@foreach($users as $user)
								<tr>
									<td>{{$user->firstname . " " . $user->lastname}}</td>
									<td>
										<a class="btn btn-primary" href="{{ route('editUser', $user->id) }}">Edit user</a>
									</td>
								</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>

@endsection
