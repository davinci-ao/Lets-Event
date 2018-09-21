@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row justify-content-center">
		<div class="col-md-8">
			<a  href="{{ route('indexCreateEvent') }}" >Create a Event</a>
			<div class="card">
				<div class="card-header">List of events</div>

				<div class="card-body">

					<ul>
						@foreach ($events as $event)
						<a  href="{{ route('viewEvent', $event->id) }}" ><li> {{ $event->name }}</li></a>
						@endforeach
					</ul>
				</div>
			</div>

		</div>
	</div>
</div>
@endsection
