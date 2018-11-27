@extends('layouts.app')

@section('content')
<div class="container">

	@if(Session::has('message'))
		@if(Session::has('positive'))
			<div class="alert alert-success hideMsg">
				<p> {{ Session('message') }} </p>
			</div>
		@else 
			<div class="alert alert-danger hideMsg">
				<p> {{ Session('message') }} </p>
			</div>
		@endif		
	@endif

	@if(Session::has('failMessage'))
		<div id="message" class="alert alert-danger hideMsg"> 
			<p>That event does not exist</p> 
		</div>
	@endif

	<div class="row justify-content-center">
		<div class="col-md-8">

			<div class="card">
				<div class="card-header">
					List of events that need to be approved
					<a class="float-right btn btn-primary"  href="{{ route('event.index') }}" >back to overview</a>
				</div>

				<div class="card-body">
					@if(count($events) > 0)
						<table class="table">
							<thead>
								<tr>
									<th>Name</th>
									<th colspan="2">Options</th>
								</tr>
							</thead>
							<tbody>
								@foreach ($events as $event)
									<tr>
										<td><a href="{{ route('event.show', $event->id)}}" > {{ $event->name }}</a></td>
										<td>
											<form class="d-inline" method="POST" action="{{ route('event.update', [$event->id, 'approve' => 'accept']) }}">
												@csrf
												@method('PUT')
												<button type="submit" class="btn btn-success">Accept</button>
											</form>

											<form class="d-inline" method="POST" action="{{ route('event.destroy', $event->id) }}">
												@csrf
												@method('DELETE')
												<button type="submit" class="btn btn-danger">Decline</button>
											</form>
										<td>
									</tr>
								@endforeach
							</tbody>
						</table>
					@else
						<h3>There are no more events that need approval :D</h3>
					@endif
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
