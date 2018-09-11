@extends('layouts.app')

@section('content')
@if ($status == 'success')
<div class="container">
	<div class="row justify-content-center">
		<div class="col-md-8">
			<div class="alert alert-success">
			  <strong>Success!</strong> Indicates a successful or positive action.
			</div>
		</div>
	</div>
</div>
@endif
<div class="container">
	<div class="row justify-content-center">
		<div class="col-md-8">
			<div class="card">
				<div class="card-header">Create Event</div>

				<div class="card-body">
					<form action="{{action('EventsController@createEvent')}}" method="POST">
						@csrf
						<p>  Name  <input type="text" name="eventName" placeholder="Masked Gala" id="eventName" required></p>
						<p>  Date  <input type="date" name="eventDate" id="eventDate" required></p>
						<p>  Time  <input type="time" name="eventTime" id="eventTime" step="1" required></p>
						<p>  Price € <input type="number" name="eventPrice" placeholder="22,50" step="any" id="eventPrice">
						</p>
						<p>  Location <input type="text" name="eventLocation" placeholder="Azurro" id="eventLocation" required>
						</p>
						<p><input type="submit" value="Save"></p>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
