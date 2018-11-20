@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row justify-content-center">
		<div class="col-md-8">

			@if(Session::has('message'))
				@if(Session::has('positive'))
					<div  class="alert alert-success">
				@else 
					<div  class="alert alert-danger">
				@endif		
					<p> {{ Session('message') }} </p>
				</div>
			@endif

				<form class="form-horizontal" action="{{ route('updateUser') }}" method="post">
					<div class="card">
						<div class="card-header">
							Edit user
							<a  class="float-right btn btn-primary" href="{{ route('userIndex') }}" >Back to overview</a>

						</div>
						<div class="card-body">
							@csrf()

							<div class="form-group ">
								<label class="control-label col-sm-2 ">First name*   </label> <input required style="width:50%"  value="{{$user->firstname}}" name="firstname">
							</div>
							<div class="form-group ">
								<label class="control-label col-sm-2 ">Last name*  </label> <input required style="width:50%"  value="{{$user->lastname}}" name="lastname">
							</div>
							<div class="form-group ">
								<label class="control-label col-sm-2 "> Student number* </label> <input type="number" required style="width:50%"  value="{{$user->student_nr}}" name="studentnr">
							</div>
							<div class="form-group ">
								<label class="control-label col-sm-2 "> Email* </label> <input type="email" required style="width:50%" value="{{$user->email}}" name="email">
							</div>
							<div class="form-group ">
								<label class="control-label col-sm-2 "> Location* </label> 
								<select required name="location">
									@foreach($locations as $location)
										<option value="{{$location->id}}" 
											@if($user->education_location_id == $location->id) selected="true" @endif >{{$location->name}}</option>
									@endforeach
								</select>
							</div>

							<div class="form-group">
								<label class="control-label col-sm-2"> Activation* </label> 
								<select required name="activated">
									<option value="activated">Activated</option>
									<option value="not activated" @if($user->activated == "not activated") selected="true" @endif>Not Activated</option>
								</select>
							</div>
							<div class="form-group">
								<label class="control-label col-sm-2"> Role* </label>
								<select required name="role">
									<option value="teacher">Teacher</option>
									<option value="organisator" @if($user->role == "organisator") selected="true" @endif>Organisator</option>
									<option value="student" @if($user->role == "student") selected="true" @endif>Student</option>
								</select>
								
								<input type="hidden" value="{{$user->id}}" name="id">
							</div>
							<input class="btn btn-primary" style="width: 15%" type="submit" value="Save">
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
	@endsection
