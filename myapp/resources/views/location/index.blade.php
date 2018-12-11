@extends('layouts.app')

@section('content')
<div class="container">
		<div class="row justify-content-center">
			<div class="col-md-8">
				<div class="card">

					<div class="card-header">Locations</div>

					<div class="card-body">

						<form action="{{ route('location.store')}}" method="POST">
							@csrf

							<div class="form-group">
    							<label for="name">Location</label>
    							<input type="text" class="form-control" name="name" id="name" placeholder="azzuro, zoetermeer, rotterdam" maxlength="40" required="true" value="{{ old('name') }}">
  							</div>

							<button type="submit" class="btn btn-primary mb-2">Save</button>
						</form>
					</div>

					<div class="mx-auto justify-content-center">{{ $locations->links() }}</div>

					<div class="table-responsive-sm">
						<table class="table">
							<thead>
								<tr>
									<th> Name </th>
									<th colspan="2"> Options </th>
								</tr>
							</thead>
							<tbody>
								@foreach($locations as $location)
								<tr>
									<td><a href="{{route('location.show', $location->id)}}">{{ $location->name }}</a></td>
									<td><a class="btn btn-info" href="{{ route('location.edit', $location->id)}}">Edit</a></td>
									<td>
										<form action="{{ route('location.destroy',  $location->id) }}" method="POST">
											@method('DELETE')
											@csrf

											@if ($location->events->isNotEmpty() )
												<button type="button" class="btn btn-danger" disabled="true" data-toggle="tooltip" data-placement="top" title="{{$location->events->pluck('name')}}">Delete</button>
											@else
												<button type="submit" class="btn btn-danger">Delete</button>
											@endif
										</form>
									</td>
								</tr>
								@endforeach
							</tbody>
						</table>

					</div>

					<div class="mx-auto justify-content-center">{{ $locations->links() }}</div>

				</div>
			</div>
		</div>
	</div>
</div>
@endsection
