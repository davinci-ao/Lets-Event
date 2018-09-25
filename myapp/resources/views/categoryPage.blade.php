@extends('layouts.app')

@section('content')
<div class="container">

	@if(Session::has('succesMessage'))
	<div id="message" class="alert alert-success">
<<<<<<< HEAD
		<p >Category Created</p>
=======
		<p>Category Creation is succesfull , '{{$categoryName}}' Created</p> 
>>>>>>> 0582cf575fdf7ff05d23d16bbc6f5181c4c98334
	</div>
	@elseif (Session::has('failMessage'))
	<div id="message" class="alert alert-danger">
<<<<<<< HEAD
		<p >Category creation failed,  it already exists</p>
=======
		<p>Category creation failed, '{{$categoryName}}' already exists</p>
>>>>>>> 0582cf575fdf7ff05d23d16bbc6f5181c4c98334
	</div>
	@elseif (Session::has('emptyInputMessage'))
	<div id="message" class="alert alert-danger">
		<p >Category creation failed,  You didn't input a name for your category</p>
	</div>
	@elseif (Session::has('toLongInputMessage'))
	<div id="message" class="alert alert-danger">
		<p >Category creation failed,  the name is above 40 characters</p>
	</div>
	@endif
	<div class="row justify-content-center">
		<div class="col-md-8">
			<div class="card">

				<div class="card-header">Dashboard</div>

				<div class="card-body">
<<<<<<< HEAD
					<ul>
						@foreach ($categories as $category)
						<li>
							{{ $category->name }}
							<a href="{{ url('/category/delete/' . $category->id) }}"
							 onclick="return confirm('are you sure to delete this category ?')" >x</a>
						</li>
						@endforeach
					</ul>				
				</div>

				<div class="card-footer">
      				<small class="text-muted">
						<form action="{{action('CategoryController@createCategory')}}" method="POST">
=======
					<form action="{{ route('createCategory')}}" method="POST">
>>>>>>> 0582cf575fdf7ff05d23d16bbc6f5181c4c98334
						@csrf
						<p> Category Name  <input type="text" name="categoryName" placeholder="Card Game, Party, tournament, Etc" max="40" id="categoryName" required size="35%;"><input type="submit" value="Save"></p>
					</form>
<<<<<<< HEAD
      				</small>
    			</div>
=======
					@foreach($categories as $category)
					<p>{{$category->name}} <a class="glyphicon glyphicon-pencil"  href="{{ route('editCategory', $category->id)}}">Edit</a></p>
					@endforeach
				</div>


>>>>>>> 0582cf575fdf7ff05d23d16bbc6f5181c4c98334
			</div>
		</div>
	</div>
</div>
<script>
	setTimeout(function () {
		document.getElementById("message").style.display = "none";
	}, 5000);
</script>
@endsection
