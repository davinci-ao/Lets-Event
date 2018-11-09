@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row justify-content-center">
		<div class="col-md-8">

			<div class="card">
				<div class="card-header">Showing the events held at '{{ $location->name }}'</div>
				<div class="card-body">
					@foreach( $location->events as $event )
						<a href="{{route('viewEvent', $event->id)}}">{{ $event->name }}</a> <br>
					@endforeach
				</div>
			</div>
		</div>
	</div>
</div>
@endsection