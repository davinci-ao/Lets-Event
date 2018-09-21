@extends('layouts.app')

@section('content')
<div class="container">

	@if(session::has('succesMessage'))
	<div id="message" class="alert alert-success">
		<p>Category Created</p>
	</div>
	@elseif (session::has('failMessage'))
	<div id="message" class="alert alert-danger">
		<p>Category creation failed,  it already exists</p>
	</div>
	@elseif (session::has('emptyInputMessage'))
	<div id="message" class="alert alert-danger">
		<p>Category creation failed,  You didn't input a name for your category</p>
	</div>
	@elseif (session::has('toLongInputMessage'))
	<div id="message" class="alert alert-danger">
		<p>Category creation failed,  the name is above 40 characters</p>
	</div>
	@else
	<p id="message" style="background-color: inherit"></p>
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
				<a href="{{ url('/home') }}" >Home</a>	
				<div class="card-body">
					<a href="{{ url('/category/createPage/create') }}" >Create Categories</a>
					<h1>Are categories being shown here ? who knows</h1>
				</div>
				
				
			</div>
		</div>
	</div>
</div>
@endsection
