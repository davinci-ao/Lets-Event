@extends('layouts.app')

@section('content')
@if (session('status'))
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="alert alert-danger">
                {{ session('status') }}
            </div>
        </div>
    </div>
</div>
@endif
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <form class="form-horizontal" method="POST" action="{{ route('import_process') }}">
                {{ csrf_field() }}

                <table class="table">
                    @foreach ($csv_data as $row)
                        <tr>
                        @foreach ($row as $key => $value)
                            <td>{{ $value }}</td>
                        @endforeach
                        </tr>
                    @endforeach
                    <tr>
                        @foreach ($csv_data[0] as $key => $value)
                            <td>
                                <select name="fields[{{ $key }}]">
                                    @foreach ($db_fields as $db_field)
                                        <option value="{{ $loop->index }}">{{ $db_field }}</option>
                                    @endforeach
                                </select>
                            </td>
                        @endforeach
                    </tr>
                </table>

                <button type="submit" class="btn btn-primary">
                    Import Data
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
