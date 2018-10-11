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
					<table class="table">
						<thead>
							<tr>
								<th> Name </th>
								<th colspan="2"> Options </th>
							</tr>
						</thead>
						<tbody>
							@foreach($categories as $category)
							<tr>
								<td><p>{{$category->name}}</td>
								<td><a class="btn btn-info" href="{{ route('editCategory', $category->id)}}">Edit</a></td>
								<td><a class="btn btn-danger" href="{{ url('/category/delete/' . $category->id) }}"onclick="return confirm('are you sure to delete this category ?')" >Delete</a></p></td>
							</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
