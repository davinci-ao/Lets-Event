@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row justify-content-center">
		<div class="col-md-8">

			@if(Session::has('message'))
			@if(Session::has('positive'))
			<div class="alert alert-success">
				<p> {{ Session('message') }} </p>
			</div>
			@else 
			<div  class="alert alert-danger">
				<p> {{ Session('message') }} </p>
			</div>
			@endif		
			@endif

			@if(Session::has('failMessage'))
			<div id="message" class="alert alert-danger">
				<p>That event does not exist</p> 
			</div>
			@endif

			<a  href="{{ route('indexCreateEvent') }}" >Create a Event</a>
			<div class="card">
				<div class="card-header">List of events</div>

				<div class="card-body">

					<ul>
						@foreach ($events as $event)
						<a  href="{{ route('viewEvent', $event->id)}}" > <li>{{ $event->name }}</a>
						@endforeach
					</ul>
				</div>
			</div>

		</div>
	</div>
</div>
@endsection
