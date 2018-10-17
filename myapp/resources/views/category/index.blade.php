@extends('layouts.app')

@section('content')
<div class="container">

	@foreach ($errors->all() as $message) 
		<div class="alert alert-danger" rol="alert">
    		{{ $message }}
    	</div>
	@endforeach

	@if(Session::has('message'))
		<div class="alert alert-success" rol="alert">
			{{ Session('message') }}
		</div>
	@endif

		<div class="row justify-content-center">
			<div class="col-md-8">
				<div class="card">

					<div class="card-header">Dashboard</div>

					<div class="card-body">

						<form action="{{ route('category.store')}}" method="POST">
							@csrf

							<div class="form-group">
    							<label for="name">Category</label>
    							<input type="text" class="form-control" name="name" id="name" placeholder="Gamen, Schaken, Bordspel" maxlength="40" required="true" value="{{ old('name') }}">
  							</div>

							<button type="submit" class="btn btn-primary mb-2">Save</button>
						</form>
					</div>

					<div class="mx-auto justify-content-center">{{ $categories->links() }}</div>

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
								<td>{{$category->name}}</td>
								<td><a class="btn btn-info" href="{{ route('category.edit', $category->id)}}">Edit</a></td>
								<td>
									<form action="{{ route('category.destroy',  $category->id) }}" method="POST">
										@method('DELETE')
										@csrf

										<button type="submit" class="btn btn-danger">Delete</button>
									</form>
								</td>
							</tr>
							@endforeach
						</tbody>
					</table>

					<div class="mx-auto justify-content-center">{{ $categories->links() }}</div>

				</div>
			</div>
		</div>
	</div>
</div>
@endsection
