@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row justify-content-center">
		<div class="col-md-8">
			<div class="card">
				<div class="card-header">Dashboard</div>
					
				<div class="card-body">
					<a href="{{ url('/category/createPage/create') }}" >Create Categories</a>
					<h1>Are categories are being shown here ? who knows</h1>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
