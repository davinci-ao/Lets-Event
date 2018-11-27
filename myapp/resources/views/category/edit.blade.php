@extends('layouts.app')

@section('content')
<div class="container">

	@foreach ($errors->all() as $message) 
		<div class="alert alert-danger hideMsg">
    		{{ $message }}
    	</div>
	@endforeach

	<div class="row justify-content-center">
		<div class="col-md-8">

			<div class="card">
				<div class="card-header">
					Editing the category "{{ $category->name }}" 
					<a class="btn btn-primary float-right" href="{{ route('category.index') }}" >Back to category overview</a>
				</div>
				<div class="card-body">
					<form method="post" action="{{ route('category.update', $category->name )}}">
						@csrf
						@method('PUT')
						<div class="form-group">
							<label for="name">Name</label>
							<input class="form-control" id="name" type="text" name="name" maxlength="40" value="{{ $category->name }}" required>
						</div>

						<input type="hidden" value="{{$category->id}}" name="id">
						
						<button type="submit" class="btn btn-primary">Edit</button>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection