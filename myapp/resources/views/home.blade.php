@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row justify-content-center">
		<div class="col-md-8">
			<div class="card">
				<div class="card-header">Notifications</div>

				<div class="card-body">
					@if (session('default'))
					<div class="alert alert-default">
						{{ session('default') }}
					</div>
					@elseif (session('warning'))
					<div class="alert alert-warning">
						{{ session('warning') }}
					</div>
					@elseif (session('danger'))
					<div class="alert alert-danger">
						{{ session('danger') }}
					</div>
					@endif
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
