@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row justify-content-center">
		<div class="col-md-8">

			@foreach ($errors->all() as $message) 
				<div rol="alert" class="alert alert-danger">
    				{{ $message }}
    			</div>
			@endforeach
			<div class="card">
				<div class="card-header">
					Editing the location "{{ $location->name }}"
					<a  class="float-right btn btn-primary" href="{{ route('location.index') }}" >Back to overview</a>
				</div>
				<div class="card-body">
					<form method="post" action="{{ route('location.update', $location->name )}}">
						@csrf
						@method('PUT')
						<div class="form-group">
							<label for="name">Name</label>
							<input class="form-control" id="name" type="text" name="name" maxlength="40" value="{{ $location->name }}" required>
						</div>

						<input type="hidden" value="{{$location->id}}" name="id">
						
						<button type="submit" class="btn btn-primary">Edit</button>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection