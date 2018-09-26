@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row justify-content-center">
		<div class="col-md-8">

			@if(Session::has('message'))
				@if(Session::has('positive'))
					<div id="message" class="alert alert-success">
				@else 
					<div id="message" class="alert alert-danger">
				@endif		
					<p> {{ Session('message') }} </p>
				</div>
			@endif

			<a  href="{{ route('eventIndex') }}" >Back to overview</a>
			<div class="card">
				<div class="card-header" ><h1 class='headEventName'>{{$event->name}}</h1></div>
				<div class="card-body">
					<div class="form-group ">
						<label class="control-label col-sm-9 eventDataHeader">Host :</label> <p class="eventData">{{$organizer->firstname . ' ' . $organizer->lastname}}</p>
					</div>
					<div class="form-group ">
						<label class="control-label col-sm-9 eventDataHeader"> Date : </label><p class="eventData">{{$event->datum}}</p>
					</div>
					<div class="form-group ">
						<label class="control-label col-sm-9 eventDataHeader"> Time : </label> <p class="eventData">{{$event->time}} </p>
					</div>
					<div class="form-group ">
						<label class="control-label col-sm-9 eventDataHeader"> Price : </label> <p class="eventData">@if($event->price != 0) €{{$event->price}} @else Free @endif</p>
					</div>
					<div class="form-group ">
						<label class="control-label col-sm-9 eventDataHeader"> Location : </label><p class="eventData" >{{$location->name}}</p>
					</div>

				</div>
			</div>
			<div class="card">
				<div class="card-header" ><h3>Description</h3></div>
				<div class="card-body">
					<div class="form-group description ">

						<label class="control-label col-sm-9" id="eventDesctiption">@if($event->description != "") {{$event->description}} @else  There is no description  @endif </label>

					</div>
				</div>
			</div>
			<div class="card">
				<div class="card-header"><h3>Attendees</h3>
						@if ( $guests->contains('id', Auth::user()->id) )
							<form class="float-right" method="POST" action="{{ route('WriteOutEvent')}}">
						@else 
							<form class="float-right" method="POST" action="{{ route('RegisterEventAction')}}">
						@endif
						@csrf
						<input type="hidden" value="{{ $event->id }}" name="id">
						@if ( $guests->contains('id', Auth::user()->id) )
							<button type="submit" class="btn btn-danger">Write out of the event</button>
						@else 
							<button type="submit" class="btn btn-primary">Register for the event</button>
						@endif
					</form>
				<div class="card-body">
					<div class="form-group description">
						@if($guests->isEmpty())
							There are no attendees for this event
						@else
							<table class="table">
								<tbody>
									<tr>
										<th>Name</th>
									</tr>
									@foreach($guests as $guest)
									<tr>
										<td>{{ $guest->firstname }} {{ $guest->lastname }}</td>
									</tr>
									@endforeach
								</tbody>
							</table>
						@endif
					</div>
				</div>
			</div>

		</div>
	</div>
</div>
@endsection
