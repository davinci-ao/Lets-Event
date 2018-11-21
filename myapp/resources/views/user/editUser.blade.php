@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row justify-content-center">
		<div class="col-md-8">

			@if(Session::has('message'))
				<div class="alert alert-success">
					{{ Session('message') }}
				</div>
			@endif

			@foreach ($errors->all() as $message) 
				<div rol="alert" class="alert alert-danger">
    				{{ $message }}
    			</div>
			@endforeach

				<div class="card">
					<div class="card-header">
						Edit user
						<a class="float-right btn btn-primary" href="{{ route('userIndex') }}" >Back to overview</a>
					</div>
					<div class="card-body">

						<form class="form-horizontal" action="{{ route('updateUser') }}" method="post">
							@csrf()


							<div class="form-group row">
								<label class="control-label col-md-2">First name*</label> 
								<input class="form-control col-md-4" required value="{{$user->firstname}}" name="firstname">
							
								<label class="control-label col-md-2">Last name*</label> 
								<input class="col-md-4 form-control" required value="{{$user->lastname}}" name="lastname">
							</div>


							<div class="form-group row">
								<label style="line-height: 20px; margin: 0px" class="control-label col-md-2" for="studentNumber"> Student number* </label> 
								<input class="form-control col-md-4" type="number" required value="{{$user->student_nr}}" name="student_number">
							
								<label class="control-label col-md-2" for="email"> Email* </label> 
								<input class="form-control col-md-4" id="email" type="email" required value="{{$user->email}}" name="email">
							</div>

							<div class="form-group row">
								<label class="control-label col-md-2"> Location* </label> 
								<select class="col-md-4 form-control" required name="location">
									@foreach($locations as $location)
										<option value="{{$location->id}}" 
											@if($user->education_location_id == $location->id) selected="true" @endif >{{$location->name}}</option>
									@endforeach
								</select>
						
								<label class="control-label col-md-2"> Activation* </label> 
								<select class="form-control col-md-4" required name="activated">
									<option value="activated">Activated</option>
									<option value="not activated" @if($user->activated == "not activated") selected="true" @endif>Not Activated</option>
								</select>
							</div>
							
							<div class="form-group row">
								
								<label class="control-label col-md-2"> Role* </label>
								<select class="form-control col-md-4" required name="role">
									<option value="teacher">Teacher</option>
									<option value="organisator" @if($user->role == "organisator") selected="true" @endif>Organisator</option>
									<option value="student" @if($user->role == "student") selected="true" @endif>Student</option>
								</select>

								@if($user->role != "teacher" && $user->id !== auth()->user()->id ) 
									<label class="control-label col-md-2">Status</label>
									<select class="col-md-4 form-control" name="status"> 
										<option value="empty"  @if($user->status == "empty") selected="true" @endif>Normal</option>
										<option value="warning" @if($user->status == "warning") selected="true" @endif>Warning</option>
										<option value="ban" @if($user->status == "ban") selected="true" @endif>Ban</option>
									</select>
								@endif
								
								<input type="hidden" value="{{$user->id}}" name="id">
							</div>

							<button class="btn btn-primary">Save</button>

						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
