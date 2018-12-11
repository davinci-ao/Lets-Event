@extends('layouts.app')

@section('content')



<div class="container">
	<div class="card">
		<div class="card-header">Notifications</div>
		<div class="alert {{ Session::get('alert-class', 'alert-info') }}">
			{{ $message }}
		</div>
		<div class="card-body"></div>
	</div>
	<div class="row justify-content-center">
		<div class="col-md-7">
			<div class="card">
				<div class="card-header">Events you registered for</div>
				<div class="card-body">
					<table class="table">
						<tbody>
							@foreach ($events as $event)
							<tr class="row">
								<td class="col-md-5"><a  href="{{ route('event.show', $event->id)}}" > {{ $event->name }}</a></td>
								<td class="col-md-4">{{date('Y-m-d', $event->date_time)}}</td>
								<td class="col-md-3">{{ date('G:i', $event->date_time) }}</td>
							</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			</div>
		</div>
		<div class="col-md-5">
			<div class="card">
				<div class="card-header">Your personal data</div>
				<div class="card-body">
					<p>Firstname: {{$user->firstname}}</p>
					<p>Lastname: {{$user->lastname}}</p>
					<p>Email: {{$user->email}}</p>
					<p>Role: {{$user->role}}</p>
					<p>Education location: {{$location->name}}</p>
					@if ($user->role == 'student')
						<p>Student number: {{$user->student_nr}}</p>
					@elseif ($user->role == 'teacher')
						<p>Teacher code: {{$user->student_nr}}</p>
					@endif
				</div>
			</div>
		</div>
	</div>
</div>
</div>
</div>
</div>
@endsection
