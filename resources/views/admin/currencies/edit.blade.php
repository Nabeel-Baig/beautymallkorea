@extends('layouts.master')

@section('title')
	Edit {{ $title }}
@endsection

@section('page-specific-css')
	<!-- Plugins css -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/css/dropify.min.css"/>
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
					<form method="POST" action="{{ route('admin.currencies.update', ["currency" => $model->id]) }}" class="custom-validation" enctype="multipart/form-data">
						@csrf
						@method('PATCH')
						<div class="mb-3">
							<label for="currency_name" class="form-label">Currency Name</label>
							<input name="name" id="currency_name" value="{{ old("name") ?? $model->name }}" minlength="3" maxlength="50" class="form-control @error('name') parsley-error @enderror" required>
							@error('name')
							<span class="text-red">{{ $message }}</span>
							@enderror
						</div>

						<div class="mb-3">
							<label for="currency_symbol" class="form-label">Currency Symbol</label>
							<input name="symbol" id="currency_symbol" value="{{ old("symbol") ?? $model->symbol }}" maxlength="3" class="form-control @error('symbol') parsley-error @enderror" required>
							@error('symbol')
							<span class="text-red">{{ $message }}</span>
							@enderror
						</div>

						<div class="mb-3">
							<label for="currency_short_name" class="form-label">Currency Short Name</label>
							<input name="short_name" id="currency_short_name" value="{{ old("short_name") ?? $model->short_name }}" maxlength="3" class="form-control @error('short_name') parsley-error @enderror" required>
							@error('short_name')
							<span class="text-red">{{ $message }}</span>
							@enderror
						</div>

						<div class="mb-3">
							<div>
								<button type="submit" class="btn btn-primary waves-effect waves-light mr-1">Submit</button>
							</div>
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
	<!--tinymce js-->
	<script src="{{ asset('assets/libs/tinymce/tinymce.min.js') }}"></script>
	<!-- init js -->
	<script src="{{ asset('assets/js/pages/form-editor.init.js') }}"></script>
@endsection
