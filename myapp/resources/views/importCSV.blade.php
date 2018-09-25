@extends('layouts.app')

@section('content')
@if (session('status') != 'success' && !empty(session('status')))
<div class="container">
	<div class="row justify-content-center">
		<div class="col-md-8">
			<div class="alert alert-danger">
				{{ session('status') }}
			</div>
		</div>
	</div>
</div>
@elseif (session('status') == 'success')
<div class="container">
	<div class="row justify-content-center">
		<div class="col-md-8">
			<div class="alert alert-success">
				<strong>SUCCESS!</strong> CSV file added to database
			</div>
		</div>
	</div>
</div>
@endif
<div class="container">
	<div class="row justify-content-center">
		<div class="col-md-8">
			<div class="card">
				<div class="card-header">Import CSV file</div>

				<div class="card-body">
					<form method="POST" action="{{ route('import_parse') }}" enctype="multipart/form-data">
						{{ csrf_field() }}
						<div class="form-group{{ $errors->has('csv_file') ? ' has-error' : '' }}">
							<label for="csv_file" class="col-md-4 control-label">CSV file to import</label>
							<div class="col-md-6">
                                <input id="csv_file" type="file" class="form-control" name="file" required>

                                @if ($errors->has('csv_file'))
                                    <span class="help-block">
                                    <strong>{{ $errors->first('csv_file') }}</strong>
                                </span>
                                @endif
                            </div>
						</div>

                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Parse CSV
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
