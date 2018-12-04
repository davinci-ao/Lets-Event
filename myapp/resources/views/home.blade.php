@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row justify-content-center">
		<div class="col-md-8">
			<div class="card">
				<div class="card-header">Notifications</div>

				<div class="card-body">
					<div class="alert {{ Session::get('alert-class', 'alert-info') }}">
						{{ $message }}
					</div>
				</div>
			</div>
			<br>
			<div class="card">
				<div class="card-header">Events you registered for</div>
				<div class="card-body">
					@foreach($events as $event)
					<a href="{{ route('event.show', $event->id)}}">{{$event->name}}</a><br>
					@endforeach
				</div>
			</div>
			<br>
			<div class="card">
				<div class="card-header">Your personal data</div>
				<div class="card-body">
					<p>Firstname: {{$user->firstname}}</p>
					<p>Lastname: {{$user->lastname}}</p>
					<p>Email: {{$user->email}}</p>
					<p>Role: {{$user->role}}</p>
					<p>Education location: {{$location->name}}</p>
					<p>Student number: {{$user->student_nr}}</p>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
