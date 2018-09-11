@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row justify-content-center">
		<div class="col-md-8">
			<div class="card">
				<div class="card-header">List of events</div>

				<div class="card-body">

                    <ul>
	                    @foreach ($events as $event)
	                        <li> {{ $event->name }}</li>
                        @endforeach
                    </ul>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
