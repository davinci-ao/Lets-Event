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
			<a class="btn btn-primary" href="{{ route('event.index') }}" >Back to overview</a>
			<div class="card">
				<div class="card-header">Create Event</div>

				<div class="card-body">
					<form class="form-horizontal" action="{{ route('event.store') }}" method="POST">
						@csrf
						<div class="form-group">
							<label class="control-label col-sm-2" for="name">  Name*  </label><input type="text" name="eventName" style="width:70%" placeholder="Masked Gala" id="eventName" value="{{ old('eventName') }}" required>
						</div>
						<div class="form-group">
							<label class="control-label col-sm-2" for="date">  Date*  </label><input type="date" name="eventDate" style="width:155px" id="eventDate" value="{{ old('eventDate') }}" required>
						</div>
						<div class="form-group">
							<label class="control-label col-sm-2" for="time">  Time*  </label><input type="time" name="eventTime" style="width:100px" id="eventTime" value="{{ old('eventTime') }}" required>
						</div>
						<div class="form-group">
							<label class="control-label col-sm-2" for="price">  Price </label><input min="0" type="number" name="eventPrice" style="width:80px" placeholder="€ 22,50" step="any" id="eventPrice" value="{{ old('eventPrice') }}">
						</div>
						<div class="form-group">
						<label class="control-label col-sm-2" style="width:110px" for="price"> Location* </label>

						<select name="eventLocation">
							@foreach($locations as $location)
							<option value="{{ $location->id }} ">{{$location->name}}</option>
							@endforeach
						</select>
						</div>
						<div class="form-group">
							<label class="control-label col-sm-2" for="Minimum_members">  Minimum  </label><input min="0" type="number" name="minimum_members" value="{{ old('minimum_members') }}" style="width:50px; text-align: right">
						</div>
						<div class="form-group">
							<label class="control-label col-sm-2" for="maximum_members">  Maximum  </label><input min="0" type="number" name="maximum_members" value="{{ old('maximum_members') }}" style="width:50px; text-align: right">

						</div>
						<div class="form-group">
							<label class="control-label col-sm-2" for="description">  Description  </label><textarea name="eventDescription" id="eventDescription" value="{{ old('eventDescription') }}" style="width:70%"></textarea>
						</div>

						<div class="form-group">
							<label class="control-label col-sm-2" for="tags">Add tags</label>
							<select class="multi-tag" name="tags[]" multiple="multiple" style="width:70%">
								@foreach ($categories as $category)
								<option value="{{ $category->id }}">{{ $category->name }}</option>
								@endforeach
							</select>
						</div>
						<input class="btn btn-primary" type="submit" value="Save">

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