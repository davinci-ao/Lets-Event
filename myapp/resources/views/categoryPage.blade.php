@extends('layouts.app')

@section('content')
<div class="container">

	@if(Session::has('succesMessage'))
	<div id="message" class="alert alert-success">
		<p>Category Creation is succesfull , '{{$categoryName}}' Created</p> 
	</div>
	@elseif (Session::has('failMessage'))
	<div id="message" class="alert alert-danger">
		<p>Category creation failed, '{{$categoryName}}' already exists</p>
	</div>
	@elseif (Session::has('emptyInputMessage'))
	<div id="message" class="alert alert-danger">
		<p>Category creation failed,  You didn't input a name for your category</p>
	</div>
	@elseif (Session::has('toLongInputMessage'))
	<div id="message" class="alert alert-danger">
		<p>Category creation failed,  the name is above 40 characters</p>
	</div>
	@endif
	<div class="row justify-content-center">
		<div class="col-md-8">
			<div class="card">
				<div class="card-header">Dashboard</div>
				<div class="card-body">
					<form action="{{ route('createCategory')}}" method="POST">
						@csrf
						<p> Category Name  <input type="text" name="categoryName" placeholder="Card Game, Party, tournament, Etc" max="40" id="categoryName" required size="35%;"><input type="submit" value="Save"></p>
					</form>
					@foreach($categories as $category)
					<p>{{$category->name}} <a class="glyphicon glyphicon-pencil"  href="{{ route('editCategory', $category->id)}}">Edit</a></p>
					@endforeach
				</div>


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
