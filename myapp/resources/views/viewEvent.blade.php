@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row justify-content-center">
		<div class="col-md-8">
			<a  href="{{ route('eventIndex') }}" >Back to overview</a>
			<div class="card">
				<div class="card-header" ><h1 class='headEventName'>{!!$event->name!!}</h1></div>
				<div class="card-body">
					<div class="form-group ">
						<label class="control-label col-sm-9 eventDataHeader">Host :</label> <p class="eventData">{!!$user->firstname . ' ' . $user->lastname!!}</p>
					</div>
					<div class="form-group ">
						<label class="control-label col-sm-9 eventDataHeader"> Date : </label><p class="eventData">{!!$event->datum!!}</p>
					</div>
					<div class="form-group ">
						<label class="control-label col-sm-9 eventDataHeader"> Time : </label> <p class="eventData">{!!$event->time!!} </p>
					</div>
					<div class="form-group ">
						 @if($event->price != 0)
						 <label class="control-label col-sm-9 eventDataHeader"> Price : </label> <label class="eventData ">€{!!$event->price!!}</label>
						@else
						<label class="control-label col-sm-9 eventDataHeader"> Price : </label> <p class="eventData">Free</p>
						@endif
					</div>
					<div class="form-group ">
						<label class="control-label col-sm-9 eventDataHeader"> Location : </label><p class="eventData" >{!!$location->name!!}</p>
					</div>

				</div>
			</div>
			<div class="card">
				<div class="card-header" ><h3>Description</h3></div>
				<div class="card-body">
					<div class="form-group description ">
						@if($event->description != "")
						<label class="control-label col-sm-9" id="eventDesctiption">{!!$event->description!!}</label>
						@else
						<label class="control-label col-sm-9" id="eventDesctiption">No description available</label>
						@endif
					</div>
				</div>
			</div>
			<div class="card">
				<div class="card-header" ><h3>Attendees</h3></div>
				<div class="card-body">
					<div class="form-group description ">
						<p>Attendees would be shown here if there were  any</p>
					</div>
				</div>
			</div>

		</div>
	</div>
</div>
@endsection
