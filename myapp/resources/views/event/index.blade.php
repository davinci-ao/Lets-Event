@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row justify-content-center">
		<div class="col-md-8">
			<div class="card">
				<div class="card-header">
					List of events

					<a class="btn btn-primary indexButton"  href="{{ route('event.create') }}" >Create a Event</a>
					@if($user->role == 'teacher')  <a class=" btn btn-info indexButton"  href="{{ route('eventApprove') }}" >Approve events</a> @endif

				</div> 
				<div class="card-body">
					<table class="table">
						<tbody id="Indexoverview">

							@foreach ($events as $event)
							<tr class="row" id="trEventIndex">
								<td class="tdEventIndex">
									<div class="card-body eventIndexPicture center">
										<a  href="{{ route('event.show', $event->id)}}" >
											<img width="320" height="200"
											@if($event->indexpicture == null)
											src="{{ asset('misc/ThumbnailPlaceholder.png') }}" 
											@else
											src="/{{ $event->indexpicture }}"
											@endif
											alt="EventPicture" ></a>
									</div>
									<div class="card-body eventIndexName center">
										<a  href="{{ route('event.show', $event->id)}}" > {{ $event->name }}</a> 
										<p>{{ $event->shortdescription }}</p>
										<p>{{date("Y-m-d ",$event->date_time)}}</p>
									</div>
									</a> 
								</td>
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
