@extends('layouts.app')

@section('content')
@foreach ($errors->all() as $message)
<div class="container">
	<div class="row justify-content-center">
		<div class="col-md-8">
			<div class="alert alert-danger">
	    		{{ $message }}
	    	</div>
    	</div>
	</div>
</div>
@endforeach
@if (Session::has('message'))
<div class="container">
	<div class="row justify-content-center">
		<div class="col-md-8">
			<div class="alert {{ Session::get('alert-class', 'alert-info') }} hideMsg">
				{{ Session::get('message') }}
			</div>
		</div>
	</div>
</div>
@endif

<div class="container">
	<div class="row justify-content-center">
		<div class="col-md-8">
			<div class="card">
				<div class="card-header" >
					Editing the event "{{ $event->name }}"
					<a class="float-right btn btn-primary"  href="{{ route('event.show', $event->id) }}" >Back to event</a>
				</div>
				<div class="card-body">
					
					<form action="{{ route('event.update', $event->id)}}" method="POST">
						@csrf
						@method('PUT')
						<div class="form-group row">
							<label class="control-label col-md-2" for="name">  Name*  </label>
							<input class="form-control col-md-10" type="text" name="eventName" placeholder="Masked Gala" id="name" value="{{ $event->name }}" required>
						</div>
						<div class="form-group row">
							<label class="control-label col-md-2" for="date">  Date*  </label>
							<input class="col-md-4 form-control" min="{{ date('Y-m-d') }}" type="date" name="eventDate" id="date" value="{{ date('Y-m-d', $event->date_time) }}" required>
						
							<label class="control-label col-md-2" for="time">  Time*  </label>
							<input value="{{ date('G:i', $event->date_time) }}" class="col-md-4 form-control" type="time" name="eventTime" id="time" value="{{ old('eventTime') }}" required>
						</div>

						<div class="form-group row">
							<label class="control-label col-md-2" for="location"> Location* </label>

							<select class="col-md-4 form-control" id="location" name="eventLocation">
								@foreach($locations as $location)
									<option value="{{ $location->id }}" @if($location->id == $event->location_id) selected @endif>{{ $location->name }}</option>
								@endforeach
							</select>

							<label class="control-label col-md-2" for="price">  Price </label>
							<input value="{{ $event->price }}" class="col-md-4 form-control" min="0" type="number" name="eventPrice" placeholder="€ 22,50" id="price">
						</div>

						<div class="form-group row">
							<label style="line-height: 20px;margin: 0px;" class="control-label col-md-2" for="Minimum_members">Minimal Attendees</label>
							<input class="col-md-4 form-control" min="0" id="Minimum_members" type="number" name="minimum_members" value="{{$event->minimum_members}}">
						
							<label style="line-height: 20px;margin: 0px;" class="control-label col-md-2" for="maximum_members">Maximal Attendees</label>
							<input class="col-md-4 form-control" min="0" type="number" id="maximum_members" name="maximum_members" 
							value="{{ $event->maximum_members }}">
						</div>

						<div class="form-group row">
							<label class="control-label col-md-2" for="description">Description</label>
							<textarea class="form-control col-md-10" name="eventDescription" id="eventDescription">{{$event->description}}</textarea>
						</div>

						<div class="form-group row">
							<label class="control-label col-md-2" for="tags">Add tags</label>
							<select class="form-control col-md-10 multi-tag" name="tags[]" multiple="multiple">
								@foreach ($categories as $category)
									<option value="{{ $category->id }}">{{ $category->name }}</option>
								@endforeach
							</select>
						</div>
						
						<button type="submit" class="btn btn-primary">Edit</button>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
<?php echo "<script type='text/javascript'>
$(document).ready(function(){
	var eventTags = [];";
	for ($i = 0; $i < count($eventTags); $i++) {
		echo "eventTags.push(" . $eventTags[$i] . ");";
	}
	echo "$('.multi-tag').val(eventTags).trigger('change');
	});
</script>"; ?>
@endsection