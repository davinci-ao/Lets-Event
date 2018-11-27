@extends('layouts.app')

@section('content')
<div class="container">

	@if(Session::has('message'))
		@if(Session::has('positive'))
			<div class="alert alert-success hideMsg">
		@else 
			<div class="alert alert-danger hideMsg">
		@endif		
		    {{ Session('message') }}
		</div>
	@endif

	<div class="row justify-content-center">
		<div class="col-md-8">
			<div class="card">
				<div class="card-header">{{ __('Register') }}</div>
					<div class="card-body">
						<form method="POST" action="{{ route('register') }}">
							@csrf

							<div class="form-group row">
								<label for="student_nummer" class="col-md-4 col-form-label text-md-right">{{ __('student nummer') }}</label>

								<div class="col-md-6">
									<input id="student_nummer" type="text" class="form-control{{ $errors->has('student_nummer') ? ' is-invalid' : '' }}" name="student_number" value="{{ old('student_nummer') }}" required>

									@if ($errors->has('student_number'))
									<span class="invalid-feedback">
										<strong>{{ $errors->first('student_number') }}</strong>
									</span>
									@endif
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
