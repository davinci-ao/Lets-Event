@extends('layouts.app')

@section('content')
<div class="container">


	
	
	@if (Session::has('succes_deleted'))
		<div id="message" class="alert alert-success">
			<p > {{ session()->get('succes_deleted') }}</p>
		</div>
	@elseif (Session::has('error_deleted'))
		<div id="message" class="alert alert-danger">
			<p > {{ session()->get('error_deleted') }}</p>
		</div>
	@endif
	
	@if(Session::has('message'))
		@if(Session::has('positive'))
			<div id="message" class="alert alert-success">
		@else 
			<div id="message" class="alert alert-danger">
		@endif		
				<p> {{ Session('message') }} </p>
			</div>

	@endif
	
	<div class="row justify-content-center">
		<div class="col-md-8">
			<div class="card">

				<div class="card-header">Dashboard</div>

				<div class="card-body">

					<form action="{{ route('createCategory')}}" method="POST">
						@csrf
						<p> Category Name  <input type="text" name="categoryName" placeholder="Card Game, Party, tournament, Etc" max="40" maxlength="40" id="categoryName" required size="35%;"><input type="submit" value="Save"></p>
					</form>
				</div>
				@foreach($categories as $category)
				<p>{{$category->name}} <a class="glyphicon glyphicon-pencil"  href="{{ route('editCategory', $category->id)}}">Edit</a>   <a href="{{ url('/category/delete/' . $category->id) }}"onclick="return confirm('are you sure to delete this category ?')" >Delete</a></p>
				@endforeach
				
				</div>

				

			</div>
		</div>
	</div>
</div>
@endsection
