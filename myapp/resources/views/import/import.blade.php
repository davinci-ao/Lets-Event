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
					<div class="custom-file">
						<input id="csv_file" type="file" class="custom-file-input" id="inputGroupFile01">
						<label class="custom-file-label" for="inputGroupFile01">CSV file to import</label>
					</div>	
				</div>

				<div id="table" class="table-responsive-sm">

				</div>
			</div>
		</div>
	</div>
</div>
<script src="{{ asset('js/import.js') }}" type="text/javascript"></script>
@endsection
