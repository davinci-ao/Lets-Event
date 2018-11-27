@extends('layouts.app')

@section('content')
<div class="container">

	@if(Session::has('message'))
		<div class="alert {{ Session::get('alert-class', 'alert-success') }} hideMsg">
			<p> {{ Session('message') }} </p>
		</div>
	@endif

	@foreach ($errors->all() as $message)
		<div class="alert alert-danger hideMsg">
			{{ $message }}
		</div>
	@endforeach
			
	<div class="row justify-content-center">
		<div class="col-md-8">

			<div class="card">
				<div class="card-header">
					List of events

					<a class="float-right btn btn-primary"  href="{{ route('event.create') }}" >Create a Event</a>
					@if($user->role == 'teacher')  <a class="float-right btn btn-info"  href="{{ route('eventApprove') }}" >Approve events</a> @endif

				</div>
				<div class="card-body">
					<table class="table">
						<tbody>

							@foreach ($events as $event)
								<tr class="row">
									<td><a  href="{{ route('event.show', $event->id)}}" > {{ $event->name }}</a></td>
								</tr>
							@endforeach

						</tbody>
					</table>
				</div>
			</div>

		</div>
	</div>
</div>
@endsection
