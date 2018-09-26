@extends('layouts.app')

@section('content')	
@if ($status == 'success')
<div class="container">
	<div class="row justify-content-center">
		<div class="col-md-8">
			<div id="message" class="alert alert-success">
				<strong>Success!</strong> Event '{{ $success }}' is created.
			</div>
			@if( Session::has( 'alert-danger' ))
			<div id="message" class="alert alert-danger">
				{{ Session::get( 'alert-danger' ) }}
			</div>
			@endif
		</div>
	</div>
</div>
@elseif ($status == 'fail')
<div class="container">
	<div class="row justify-content-center">
		<div class="col-md-8">
			<div id="message" class="alert alert-danger">
				<strong>Error!</strong> Event is not created.
			</div>
		</div>
	</div>
</div>
@endif
<div class="container">
	<div class="row justify-content-center">
		<div class="col-md-8">
			<a  href="{{ route('eventIndex') }}" >Back to overview</a>
			<div class="card">
				<div class="card-header">Create Event</div>

				<div class="card-body">
					<form class="form-horizontal" action="{{ route('createEvent') }}" method="POST">
						@csrf
						<div class="form-group">
							<label class="control-label col-sm-2" for="name">  Name*  </label><input type="text" name="eventName" style="width:70%" placeholder="Masked Gala" id="eventName" required>
						</div>
						<div class="form-group">
							<label class="control-label col-sm-2" for="date">  Date*  </label><input type="date" name="eventDate" style="width:155px" id="eventDate" required>
						</div>
						<div class="form-group">
							<label class="control-label col-sm-2" for="time">  Time*  </label><input type="time" name="eventTime" style="width:100px" id="eventTime"  required>
						</div>
						<div class="form-group">
							<label class="control-label col-sm-2" for="price">  Price </label><input type="number" name="eventPrice" style="width:80px" placeholder="€ 22,50" step="any" id="eventPrice">
						</div>
						<div class="form-group">
							<label class="control-label col-sm-2" for="price"> Location* </label>

							<select name="eventLocation">
								@foreach($locations as $location)
								<option value="{{ $location->id }} ">{{ $location->name }}</option>
								@endforeach
							</select>
						</div>
						<div class="form-group">
							<label class="control-label col-sm-2" for="description">  Description  </label><textarea name="eventDescription" id="eventDescription" style="width:70%"></textarea>
						</div>
						<input type="submit" value="Save">

					</form><br><h6>* = This field is required!</h6>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
