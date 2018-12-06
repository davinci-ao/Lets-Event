@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row justify-content-center">
		<div class="col-md-8">
			<div class="card">
				<div class="card-header">Notifications</div>

				<div class="card-body">
					@if (session('default'))
					<div class="alert alert-default">
						{{ session('default') }}
					</div>
					@elseif (session('warning'))
					<div class="alert alert-warning">
						{{ session('warning') }}
					</div>
					<div class="col-md-5">
						<div class="card">
							<div class="card-header">Your personal data</div>
							<div class="card-body">
								<p>Firstname: {{ $user->firstname }}</p>
								<p>Lastname: {{ $user->lastname }}</p>
								<p>Email: {{ $user->email }}</p>
								<p>Role: {{ $user->role }}</p>
								<p>Education location: {{ $location->name}}</p>
								@if ($user->role == 'student')
								<p>Student number: {{ $user->student_nr }}</p>
								@elseif ($user->role == 'teacher')
								<p>Teacher code: {{ $user->student_nr }}</p>
								@endif
							</div>
						</div>
					</div>
					@endif
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
