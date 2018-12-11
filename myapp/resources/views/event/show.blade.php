@extends('layouts.app')

@section('content')
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
					<big> <strong>{{$event->name}}</strong></big>
					@if($event->user_id === auth()->user()->id || auth()->user()->role == 'teacher')
					<a id="eventEditButton" class="btn btn-warning" href="{{ route('event.edit', $event->id)}}"> Edit Event </a>
					<form action="{{ route('event.destroy', $event->id)}}" method="POST" style="display:inline">
						@method('DELETE')
						@csrf
						<button id="eventDeleteButton" class="btn btn-danger" onclick="return confirm('Are you sure to delete this Event?')"> Delete Event </button>
					</form>
					@endif
					<a class="float-right btn btn-primary" href="{{ route('event.index') }}" >Back to overview</a>
				</div>
				<div class="card-header">
					<h3>Description</h3>
				</div>
				<div class="card-body description">
					<div class="form-group eventDesctiption ">

						<img width="200" height="200"  @if($event->viewpicture == null || "")
						     src="{{ asset('misc/PlaceHolderImage.png') }}" 
						     @else
						     src="/{{ $event->viewpicture }}"
						     @endif
						     alt="EventPicture" >

						<label class="control-label col-sm-9" id="eventDesctiption">@if($event->description != "") {{$event->description}} @else  There is no description  @endif </label>
					</div>
				</div>
			</div>	
			<div class="card">
				<div class="card-header">
					<h3>Tags:</h3>
				</div>
				<div class="card-body">
					<div class="EventTags" class="form-group description ">
						<table class="table">
							<tbody>
								@foreach($categories as $category)
								<tr class="trViewEvent">
									<td><a href="{{route('category.show', $category->id)}}"> {{$category->name}} </a></td>
								</tr>
								@endforeach
							</tbody>
						</table>
					</div>
				</div>
			</div>
			<div class="card">


				<div class="card-body">


					<div class="form-group ">
						<label class="control-label col-sm-9 eventDataHeader">Host :</label> 
						<p class="eventData">{{$organizer->firstname . ' ' . $organizer->lastname}}</p>
					</div>
					<div class="form-group ">
						<label class="control-label col-sm-9 eventDataHeader"> Date : </label>
						<p class="eventData"> {{ date('Y-m-d', $event->date_time) }} </p>
					</div>
					<div class="form-group ">
						<label class="control-label col-sm-9 eventDataHeader"> Time : </label> 
						<p class="eventData"> {{ date('G:i', $event->date_time) }} </p>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-9 eventDataHeader"> Price : </label> 
						<p class="eventData">@if($event->price != 0) €{{$event->price}}.- @else Free @endif</p>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-9 eventDataHeader"> Location : </label>
						<p class="eventData">{{$location->name}}</p>
					</div>

					@if($event->minimum_members != null)
					<div class="form-group ">
						<label class="control-label col-sm-9 eventDataHeader"> Minimum : </label> 
						<p class="eventData">{{$event->minimum_members}}</p>
					</div>
					@endif

					@if($event->maximum_members != null)
					<div class="form-group ">
						<label class="control-label col-sm-9 eventDataHeader"> Maximum : </label> 
						<p class="eventData"> {{ $event->maximum_members }} </p>
					</div>
					@endif
				</div>
			</div>

		</div>
		<div class="card attendees">
			<div class="card-header">
				<h3>Attendees</h3>
				@if (empty($event->maximum_members))
				{{ count($guests) }}/ -
				@else
				{{ count($guests) }}/ {{ $event->maximum_members }}
				@endif

				@if ( $guests->pluck('id')->contains(Auth::user()->id) )
				<form class="float-right" method="POST" action="{{ route('event.update', [$event->id, 'attend' => 'out'])}}">
					@else 
					<form class="float-right" method="POST" action="{{ route('event.update', [$event->id, 'attend' => 'in'])}}">
						@endif

						@method('PUT')
						@csrf

						@if ( $guests->pluck('id')->contains(Auth::user()->id) )
						<button type="submit" class="btn btn-danger">Write out of the event</button>
						@else 
						@if (count($guests) == $event->maximum_members && count($guests) != 0)
						<span class="text-danger">No more free space</span>
						@else
						<button type="submit" class="btn btn-primary">Register for the event</button>
						@endif
						@endif

					</form>
			</div>
			<div class="card-body">
				<div class="form-group description ">
					@if($guests->isEmpty())
					There are no attendees for this event
					@else
					<table class="table">
						<tbody>
							@foreach($guests as $guest)
							<tr>
								<td>
									{{ $guest->firstname }} {{ $guest->lastname }}
									@if ($event->user_id === $guest->id) 
									<img title="Host" class="float-right" src="{{ asset('misc/CROWN_OG.jpg') }}" height="25" width="25"> 
									@endif
								</td>
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
@endsection
