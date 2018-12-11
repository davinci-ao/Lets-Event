@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row justify-content-center">
		<div class="col-md-8">

			<div class="card">

				<div class="card-header">Put a password in to complete your registration</div>
				
				<div class="card-body">
					
					<p>A password has a minimal of 6 charachters and a max of 255 charachters</p>

					<form action="{{ route('setPassword') }}" method="POST">
						@csrf

						<div class="form-group row">
							<label for="password-confirm" class="col-md-4 col-form-label text-md-right">password</label>

							<div class="col-md-6">
								<input type="password" class="form-control" name="password" required>
							</div>
						</div>
				
						<div class="form-group row">
							<label for="password-confirm" class="col-md-4 col-form-label text-md-right">confirm password</label>

							<div class="col-md-6">
								<input type="password" class="form-control" name="password_confirmation" required>
							</div>
						</div>

						<input type="hidden" name="token" value="{{ $token }}">
						
						<button type="submit" class="btn btn-primary">register</button>

					</form>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection