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

			<a class="btn btn-primary"  href="{{ route('eventIndex') }}" >back to overview</a>
			<div class="card">
				<div class="card-header"><h3>List of events that need to be approved</h3></div>

				<div class="card-body">
					@if(count($events) > 0)
					@foreach ($events as $event)
					<table class="table">
						<thead>
							<tr>
								<th>Name</th>
								<th colspan="2">Options</th>
							</tr>
						</thead>
						<tbody>

							<tr>
								<td><a  href="{{ route('viewEvent', $event->id)}}" > {{ $event->name }} </a> </td>
								<td>
									<a href="{{ route('eventApproval', $event->id) }}" class="btn btn-success" style="color: white">Accept</a> 
									<a href="{{ route('eventDecline', $event->id) }}" class="btn btn-danger" style="color: white">Decline</a>
								<td>
							</tr>
							@endforeach
							@else

						<h3>There are no more events that need approval :D</h3>

						@endif
						</tbody>
					</table>
				</div>
			</div>

		</div>
	</div>
</div>
@endsection
