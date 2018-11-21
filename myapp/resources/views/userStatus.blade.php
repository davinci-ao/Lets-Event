@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row justify-content-center">
		<div class="col-md-8">
			@if(Session::has('message'))
				@if(Session::has('positive'))
					<div class="alert alert-success">
				@else 
					<div class="alert alert-danger">
				@endif		
						<p> {{ Session('message') }} </p>
					</div>
			@endif

				<form class="form-horizontal" action="{{ route('saveUserStatus') }}" method="post">
					<div class="card">
						<div class="card-header" >Edit user status for {{$user->firstname}} {{$user->lastname}}
							<a class="float-right btn btn-primary" href="{{ route('userIndex') }}" >Back to users</a>
						</div>
						<div class="card-body">
							{{csrf_field()}}

							<input type="hidden" name="id" value="{{$user->id}}">
							<div class="form-group ">
								<label class="control-label col-sm-2 ">Status   </label>
								<select name="status"> 
									<option value="empty"  @if($user->status == "empty") selected="true" @endif>Empty</option>
									<option value="warning" @if($user->status == "warning") selected="true" @endif>Warning</option>
									<option value="ban" @if($user->status == "ban") selected="true" @endif>Ban</option>
								</select>
							</div>
							<input class="btn btn-primary" style="width: 15%" type="submit" value="Change" onclick="return confirm('Are you sure you want to change the status?');">
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
	@endsection
