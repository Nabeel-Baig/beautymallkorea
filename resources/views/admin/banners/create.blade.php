<!--suppress HtmlFormInputWithoutLabel -->

@extends('layouts.master')

@section('title')
	Create {{ $title }}
@endsection

@section('content')

	@component('components.breadcrumb')
		@slot('li_1')
			Dashboard
		@endslot
		@slot('title')
			{{ $title ?? '' }}
		@endslot
	@endcomponent

	<!-- end row -->
	<div class="row">
		<div class="col-xl-6">
			<div class="card">
				<div class="card-body">
					<form method="POST" action="{{ route("admin.banners.store") }}" class="custom-validation" enctype="multipart/form-data">
						@csrf

						<div class="mb-3" id="submit-button-div">
							<button type="submit" class="btn btn-primary waves-effect waves-light mr-1">Submit</button>
						</div>
					</form>
				</div>
			</div>
		</div> <!-- end col -->
	</div> <!-- end row -->
@endsection

@section('script')
	<script src="{{ asset('assets/libs/parsleyjs/parsleyjs.min.js') }}"></script>
	<!-- Plugins js -->
	<script src="{{ asset('assets/js/pages/form-validation.init.js') }}"></script>
	<!-- init js -->
	<script src="{{ asset('assets/js/pages/form-editor.init.js') }}"></script>
@endsection

