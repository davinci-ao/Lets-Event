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
				<div class="card-header">
					Create Event
					<a  class="float-right btn btn-primary" href="{{ route('event.index') }}" >Back to overview</a>
				</div>

				<div class="card-body">
					<form class="form-horizontal" action="{{ route('event.store') }}" method="POST">
						@csrf
						<div class="form-group row">
							<label class="control-label col-md-2" for="name">  Name*  </label>
							<input class="form-control col-md-10" type="text" name="eventName" placeholder="Masked Gala" id="name" value="{{ old('eventName') }}" required>
						</div>
						<div class="form-group row">
							<label class="control-label col-md-2" for="date">  Date*  </label>
							<input class="col-md-4 form-control" min="{{ date('Y-m-d') }}" type="date" name="eventDate" id="date" value="{{ old('eventDate') }}" required>
						
							<label class="control-label col-md-2" for="time">  Time*  </label>
							<input class="col-md-4 form-control" type="time" name="eventTime" id="time" value="{{ old('eventTime') }}" required>
						</div>

						<div class="form-group row">
							<label class="control-label col-md-2" for="location"> Location* </label>

							<select class="col-md-4 form-control" id="location" name="eventLocation">
								@foreach($locations as $location)
									<option value="{{ $location->id }} ">{{$location->name}}</option>
								@endforeach
							</select>

							<label class="control-label col-md-2" for="price">  Price </label>
							<input class="col-md-4 form-control" min="0" type="number" name="eventPrice" placeholder="€ 22,50" id="price" value="{{ old('eventPrice') }}">
						</div>

						<div class="form-group row">
							<label style="line-height: 20px;margin: 0px;" class="control-label col-md-2" for="Minimum_members">Minimal Attendees</label>
							<input class="col-md-4 form-control" min="0" id="Minimum_members" type="number" name="minimum_members" value="{{ old('minimum_members') }}">
						
							<label style="line-height: 20px;margin: 0px;" class="control-label col-md-2" for="maximum_members">Maximal Attendees</label>
							<input class="col-md-4 form-control" min="0" type="number" id="maximum_members" name="maximum_members" value="{{ old('maximum_members') }}">
						</div>

						<div class="form-group row">
							<label class="control-label col-md-2" for="description">Description</label>
							<textarea class="form-control col-md-10" name="eventDescription" id="eventDescription" value="{{ old('eventDescription') }}"></textarea>
						</div>

						<div class="form-group row">
							<label class="control-label col-md-2" style="width: 100%" for="tags">Add tags</label>
							<select class="form-control col-md-10 multi-tag" name="tags[]" multiple="multiple">
								@foreach ($categories as $category)
									<option value="{{ $category->id }}">{{ $category->name }}</option>
								@endforeach
							</select>
						</div>

						<button type="submit" class="btn btn-primary">Save</button>
					</form>
					<br>
					<h3> * = This field is required!</h3>
					<h5> If you are not a Teacher or an Organisator you wont see it before its approved !!!</h5>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection