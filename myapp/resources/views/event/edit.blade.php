@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row justify-content-center">
		<div class="col-md-8">
			<div class="card">
				<div class="card-header" >
					Editing the event "{{ $event->name }}"
					<a class="float-right btn btn-primary"  href="{{ route('event.show', $event->id) }}" >Back to event</a>
				</div>
				<div class="card-body">
					
					<form action="{{ route('event.update', $event->id)}}" enctype="multipart/form-data" method="POST">
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
							<input value="{{ date('h:i', $event->date_time) }}" class="col-md-4 form-control" type="time" name="eventTime" id="time" required>
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
							<textarea maxlength="180" max="180" class="form-control col-md-10" name="eventDescription" id="eventDescription">{{$event->description}}</textarea>
						</div>
						
						<div class="form-group row">
							<label class="control-label col-md-2" for="shortdesc">short description </label>
							<textarea maxlength="50" max="50" placeholder="(max 50 characters)" class="form-control col-md-10" name="shortdesc" id="eventDescription">{{$event->shortdescription}}</textarea>
						</div>

						<div class="form-group row">
							<label class="control-label col-md-2" for="tags">Add tags</label>
							<select class="form-control col-md-10 multi-tag" name="tags[]" multiple="multiple">
								@foreach ($categories as $category)
									<option value="{{ $category->id }}">{{ $category->name }}</option>
								@endforeach
							</select>
						</div>
						
						<p style="color: grey">the previews are how it will be shown on their the page(has to be a jpg)</p>
						<div class="custom-file" id="inputGroupFile01div" style="padding-bottom: 55px">
							<input type="file" onchange="readURL1(this)" class="custom-file-input eventThumbnailImport" id="inputGroupFile01" name="eventThumbnail">
							<label class="custom-file-label" for="inputGroupFile01"  >Event Thumbnail Max Dimensions 3840*2160</label>		
							<img id="inputGroupFile01PR" src="#" alt="" width="320" height="200" />
						</div>	

						<div class="custom-file"  id="inputGroupFile02div" style="padding-bottom: 55px">
							<input  type="file" onchange="readURL2(this)" class="custom-file-input eventPictureImport" id="inputGroupFile02" name="eventPicture">
							<label class="custom-file-label" for="inputGroupFile02">Event Picture Max Dimensions 2160*2160 </label>
							<img id="inputGroupFile02PR" src="#" alt="" width="200" height="200" />
						</div>	
						
						<button type="submit" class="btn btn-primary">Save</button>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	
	function readURL1(input) {
		if (input.files && input.files[0]) {
			var reader = new FileReader();

			reader.onload = function (e) {
				$('#inputGroupFile01PR').attr('src', e.target.result);
				$('#inputGroupFile01div').css({'padding-bottom' : '250px'});
				
			};

			reader.readAsDataURL(input.files[0]);
		}
	}
	function readURL2(input) {
		if (input.files && input.files[0]) {
			var reader = new FileReader();

			reader.onload = function (e) {
				$('#inputGroupFile02PR').attr('src', e.target.result);
				$('#inputGroupFile02div').css({'padding-bottom' : '250px'});
				
			};

			reader.readAsDataURL(input.files[0]);
		}
	}

</script>

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