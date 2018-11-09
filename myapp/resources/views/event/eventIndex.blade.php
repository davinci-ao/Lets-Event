@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row justify-content-center">
		<div class="col-md-8">
			@if(Session::has('message'))
				<div class="alert {{ Session::get('alert-class', 'alert-success') }} hideMsg">
					<p> {{ Session('message') }} </p>
				</div>
			@endif

			<a class="btn btn-primary"  href="{{ route('event.create') }}" >Create a Event</a> @if($user->role == 'teacher')  <a class="btn btn-info"  href="{{ route('eventApprove') }}" >Approve events</a> @endif
			<div class="card">
				<div class="card-header">List of events</div>
				<div class="card-body">
					<table class="table">
						<tbody>

							@foreach ($events as $event)
							<tr class="row"><td><a  href="{{ route('event.show', $event->id)}}" > {{ $event->name }}</a></td></tr>
							@endforeach

						</tbody>
					</table>
				</div>
			</div>

		</div>
	</div>
</div>
@endsection
