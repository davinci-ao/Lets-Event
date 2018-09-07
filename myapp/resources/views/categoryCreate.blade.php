@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row justify-content-center">
		<div class="col-md-8">
			<div class="card">
				<div class="card-header">Dashboard</div>

				<div class="card-body">
					<form action="{{action('CategoryController@createCategory')}}" method="POST">
						@csrf
						<p> Category Name  <input type="text" name="categoryName" placeholder="Card Game" id="categoryName" required><input type="submit" value="Save"></p>
					</form>
					<a href="{{ url('/category/index/all') }}" >Back to categories overview</a>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
