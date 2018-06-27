@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row justify-content-center">
		<div class="col-md-8">
			<div class="card">
				<div class="card-header">{{ __('Register') }}</div>

				<div class="card-body">
					<form method="POST" action="{{ route('register') }}">
						@csrf

						<div class="form-group row">
							<label for="student_nummer" class="col-md-4 col-form-label text-md-right">{{ __('student_nummer') }}</label>

							<div class="col-md-6">
								<input id="student_nummer" type="text" class="form-control{{ $errors->has('student_nummer') ? ' is-invalid' : '' }}" name="student_number" value="{{ old('student_nummer') }}" required>

								@if ($errors->has('student_number'))
								<span class="invalid-feedback">
									<strong>{{ $errors->first('student_number') }}</strong>
								</span>
								@endif
							</div>
						</div>

						<div class="form-group row">
							<label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

							<div class="col-md-6">
								<input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>

								@if ($errors->has('email'))
								<span class="invalid-feedback">
									<strong>{{ $errors->first('email') }}</strong>
								</span>
								@endif
							</div>
						</div>

						<div class="form-group row">
							<label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

							<div class="col-md-6">
								<input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

								@if ($errors->has('password'))
								<span class="invalid-feedback">
									<strong>{{ $errors->first('password') }}</strong>
								</span>
								@endif
							</div>
						</div>

						<div class="form-group row">
							<label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

							<div class="col-md-6">
								<input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
							</div>
						</div>



						<button type="submit" class="btn btn-primary">
							{{ __('Register') }}
						</button>
				</div>
			</div>
			</form>
		</div>
	</div>
</div>
</div>
</div>
@endsection
