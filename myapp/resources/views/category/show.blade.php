@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row justify-content-center">
		<div class="col-md-8">
			<div class="card">
				<div class="card-header">
					showing the events for the category {{ $category->name }}
					<a class="float-right btn btn-primary" href="{{ route('category.index') }}" >Back to overview</a>
				</div>
				<div class="card-body">
					@foreach( $category->events as $event )
						<a href="{{route('event.show', $event->id)}}">{{ $event->name }}</a> <br>
					@endforeach
				</div>
			</div>
		</div>
	</div>
</div>
@endsection