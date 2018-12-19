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
									<div class="container">
										<div class="row justify-content-center">
											<div class="col-md-7">
												<div class="card-body eventIndexName center">
													<a  href="{{ route('event.show', $event->id)}}" > {{ $event->name }}</a> 
													<p>{{ $event->shortdescription }}</p>
												</div>
												<div class="eventIndexInfo">

												<table class="table tableBottom">
													<tbody>
														<tr class="trViewEvent">
															<td class="tdStyle">{{date("Y-m-d ",$event->date_time)}}</td>
														</tr>
														@foreach ($event->categories()->where('event_id', $event->id)->get() as $category)
														<tr class="trViewEvent">
															<td class="tdStyle"><a href="{{route('category.show', $category->id)}}">{{$category->name}}</a></td>
														</tr>
														@endforeach
													</tbody>
												</table>
													
												</div>
											</div>
											<div class="col-md-5">
												<div class="card-body eventIndexPicture center">
													<a  href="{{ route('event.show', $event->id)}}" >
														<img
														<?php 
														$info = getimagesize($event->indexpicture);
														$width = 280;
														$ratio = $info[1] / $info[0];
														$newHeight = (int)($ratio * 280);
														if ($newHeight < 200) {
															echo 'height="'.$newHeight.'"';
														} else {
															echo 'height=200';
														}
														
														echo 'width="'.$width.'"';
														?>
														@if($event->indexpicture == null)
														src="{{ asset('misc/ThumbnailPlaceholder.png') }}" 
														@else
														src="/{{ $event->indexpicture }}"
														@endif
														alt="EventPicture" >
													</a>
												</div>
											</div>
										</div>
									</div>	
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