@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row justify-content-center">
		<div class="col-md-8">

			<div style="display: none" id="feedback" rol="alert" class="alert alert-danger">
				
    		</div>

			<div class="card">
				<div class="card-header">Import CSV file</div>

				<div class="card-body">
					CSV file to import<input id="csv_file" type="file" class="form-control" name="file">	
				</div>

				<div id="table">

				</div>
			</div>
		</div>
	</div>
</div>
<script src="{{ asset('js/import.js') }}" type="text/javascript"></script>
@endsection
