@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row justify-content-center">
		<div class="col-md-8">

			@foreach ($errors->all() as $message) 
				<div id="message" class="alert alert-danger">
    				{{ $message }}
    			</div>
			@endforeach
			<div class="card">
				<div class="card-header">Editing the category "{{ $category->name }}"</div>
				<div class="card-body">
					<form action="{{ route('editCategoryAction')}}" method="POST">
						@csrf
						<div class="form-group">
							<label for="name">Name</label>
							<input class="form-control" id="name" type="text" name="categoryName" maxlength="40" value="{{ $category->name }}" required>
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