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
					<a  class="btn btn-primary" style="float: right;"  href="{{ route('event.show', $event->id) }}" >Back to event</a>
				</div>
				<div class="card-body">
					
					<form action="{{ route('event.update', $event->id)}}" method="POST">
						@csrf
						@method('PUT')
						<div class="form-group">
							<label class="control-label col-sm-2" for="name">  Name*  </label>
							<input type="text" value="{{ $event->name }} " name="eventName" style="width:70%" placeholder="Masked Gala" id="name" required>
						</div>
						<div class="form-group">
							<label class="control-label col-sm-2" for="date">  Date*  </label>
							<input type="date" value="{{ date('Y-m-d', $event->date_time) }}" name="eventDate" style="width:155px" id="date" required>
						</div>
						<div class="form-group">
							<label class="control-label col-sm-2" for="time">  Time*  </label>
							<input type="time" name="eventTime" style="width:100px" id="time" value="{{ date('G:i', $event->date_time) }}"  required>
						</div>
						<div class="form-group">
							<label class="control-label col-sm-2" for="price">  Price </label>
							<input type="number" value="{{ $event->price }}" name="eventPrice" style="width:80px" placeholder="€ 22,50" id="price">
						</div>
						<div class="form-group">
							<label class="control-label col-sm-2" for="location"> Location* </label>

							<select id="location" name="eventLocation">
								@foreach($locations as $location)
									<option value="{{ $location->id }}" @if($location->id == $event->location_id) selected @endif>{{ $location->name }}</option>
								@endforeach
							</select>
						</div>
						<div class="form-group">
							<label class="control-label col-sm-2" for="Minimum_members">  Minimum*  </label>
							<input type="number" value="{{$event->minimum_members}}" name="minimum_members" style="width:50px; text-align: right">
						</div>
						<div class="form-group">
							<label class="control-label col-sm-2" for="maximum_members">  Maximum  </label>
							<input type="number" value="{{$event->maximum_members}}" name="maximum_members" style="width:50px; text-align: right">
						</div>
						<div class="form-group">
							<label class="control-label col-sm-2" for="description">  Description  </label>
							<textarea name="eventDescription" id="eventDescription" style="width:70%">{{$event->description}}</textarea>
						</div>

						<div class="form-group">
							<label class="control-label col-sm-2" for="tags">Add tags</label>
							<select id="tags" class="multi-tag" name="tags[]" multiple="multiple" style="width:70%">
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