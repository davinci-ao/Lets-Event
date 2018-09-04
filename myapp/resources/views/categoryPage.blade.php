@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row justify-content-center">
		@if(session::has('message'))
		<p class='message'>Category Created</p>
		@endif
		<div class="col-md-8">
			<div class="card">
				<div class="card-header">Dashboard</div>
				<a href="{{ url('/home') }}" >Home</a>	
				<div class="card-body">
					<form action="{{action('CategoryController@createCategory')}}" method="POST">
						@csrf
						<p> Category Name  <input type="text" name="categoryName" placeholder="Card Game" id="categoryName" required><input type="submit" value="Save"></p>
					</form>
					<h1>Are categories being shown here ? who knows</h1>
				</div>


			</div>
		</div>
	</div>
</div>
@endsection
