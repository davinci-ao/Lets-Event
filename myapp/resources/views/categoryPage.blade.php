@extends('layouts.app')

@section('content')
<div class="container">

	@if(session::has('succesMessage'))
	<div id="message" class="alert alert-success">
		<p >Category Created</p>
	</div>
	@elseif (session::has('failMessage'))
	<div id="message" class="alert alert-danger">
		<p >Category creation failed,  it already exists</p>
	</div>
	@elseif (session::has('emptyInputMessage'))
	<div id="message" class="alert alert-danger">
		<p >Category creation failed,  You didn't input a name for your category</p>
	</div>
	@elseif (session::has('toLongInputMessage'))
	<div id="message" class="alert alert-danger">
		<p >Category creation failed,  the name is above 40 characters</p>
	</div>
	@else
	<p id="message" style="background-color: inherit"></p>
	@endif
	<div class="row justify-content-center">
		<div class="col-md-8">
			<div class="card">
				<div class="card-header">Dashboard</div>
				<div class="card-body">
					<form action="{{action('CategoryController@createCategory')}}" method="POST">
						@csrf
						<p> Category Name  <input type="text" name="categoryName" placeholder="Card Game" max="40" id="categoryName" required><input type="submit" value="Save"></p>
					</form>
					<h1>Are categories being shown here ? who knows</h1>
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
