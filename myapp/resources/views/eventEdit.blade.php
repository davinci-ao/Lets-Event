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
				<div class="card-header" >
					Editing the event "{{ $event->name }}"
					<a  class="btn btn-primary" style="float: right;"  href="{{ route('viewEvent', $event->id) }}" >Back to event</a>
				</div>
				<div class="card-body">
					
					<form action="{{ route('editSaveEvent')}}" method="POST">
						@csrf
						<div class="form-group">
							<label class="control-label col-sm-2" for="name">  Name*  </label><input type="text" value="{{ $event->name }} " name="eventName" style="width:70%" placeholder="Masked Gala" id="eventName" required>
						</div>
						<div class="form-group">
							<label class="control-label col-sm-2" for="date">  Date*  </label><input type="text" value="{{ $event->datum }} " name="eventDate" style="width:155px" id="eventDate" onclick="type='date'" required>
						</div>
						<div class="form-group">
							<label class="control-label col-sm-2" for="time">  Time*  </label><input type="text" value="{{ $event->time }} " name="eventTime" style="width:100px" id="eventTime" onclick="type='date'" required>
						</div>
						<div class="form-group">
							<label class="control-label col-sm-2" for="price">  Price </label><input type="number" value="{{ $event->price }}" name="eventPrice" style="width:80px" placeholder="€ 22,50" step="any" id="eventPrice">
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
							<label class="control-label col-sm-2" for="Minimum_members">  Minimum*  </label><input type="number" value="{{$event->minimum_members}}" name="minimum_members" style="width:50px; text-align: right"  required>
						</div>
						<div class="form-group">
							<label class="control-label col-sm-2" for="maximum_members">  Maximum  </label><input type="number" value="{{$event->maximum_members}}" name="maximum_members" style="width:50px; text-align: right"  required>
						</div>
						<div class="form-group">
							<label class="control-label col-sm-2" for="description">  Description  </label><textarea name="eventDescription" id="eventDescription" value="{{$event->description}}" style="width:70%"></textarea>
						</div>
						<input type="hidden" value="{{$event->id}}" name="id">
						<button type="submit" class="btn btn-primary">Edit</button>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection