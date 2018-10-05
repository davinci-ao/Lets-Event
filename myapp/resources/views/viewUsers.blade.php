@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row justify-content-center">
		<div class="col-md-8">

			@if(Session::has('message'))
			@if(Session::has('positive'))
			<div  class="alert alert-success">
				@else 
				<div  class="alert alert-danger">
					@endif		
					<p> {{ Session('message') }} </p>
				</div>
				@endif

				<div class="card">
					<div class="card-header" ><h1 class='headEventName'>Users</h1></div>
					<div class="card-body">
						@foreach($users as $user)
						<p>{{$user->firstname . " " . $user->lastname}} </p> <a href="{{ route('editUser', $user->id) }}">Edit this user</a>
						@endforeach
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script>







</script>

@endsection
