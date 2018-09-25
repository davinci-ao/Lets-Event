@extends('layouts.app')

@section('content')
<div class="container">

	<div class="row justify-content-center">
		<div class="col-md-8">
			@foreach ($errors->all() as $message) 
				<div id="message" class="alert alert-danger">
    				{{ $message }}
    			</div>
			@endforeach

			<div class="card">
				<div class="card-header">Register for the event "{{ $event->name }}"</div>
				<div class="card-body">
					<form action="{{ route('RegisterEventAction')}}" method="POST">
						@csrf
						<input type="hidden" value="{{ $event->id }}" name="id">
						<button type="submit" class="btn btn-primary">Register</button>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection