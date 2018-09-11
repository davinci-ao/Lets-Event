@extends('layouts.app')

@section('content')
<div class="container">
	@if(session::has('succesmessage'))
	<p id='message'>Category Created</p>
	@elseif (session::has('failmessage'))
	<p id='message'>Category creation failed,  it already exists</p>
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
	}, 3000);
</script>
@endsection
