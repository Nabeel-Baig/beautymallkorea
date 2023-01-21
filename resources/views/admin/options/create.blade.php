<!--suppress HtmlFormInputWithoutLabel -->

@extends('layouts.master')

@section('title')
	Create {{ $title }}
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
		<div class="col-xl-12">
			<div class="card">
				<div class="card-body">
					<form method="POST" action="{{ route("admin.options.store") }}" class="custom-validation" enctype="multipart/form-data">
						@csrf
						<div class="mb-3">
							<label for="option_name" class="form-label">Option Name</label>
							<input name="name" id="option_name" value="{{ old("name") }}" minlength="3" maxlength="50" class="form-control @error('name') parsley-error @enderror" required>
							@error('name')
							<span class="text-red">{{ $message }}</span>
							@enderror
						</div>

						<div class="mt-3 mb-3" id="add-option-value-row-div">
							<button type="button" class="btn btn-success waves-effect waves-light mr-1" onclick="addOptionValueRow()">Add Option Value</button>
						</div>

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
	<!--tinymce js-->
	<script src="{{ asset('assets/libs/tinymce/tinymce.min.js') }}"></script>
	<!-- init js -->
	<script src="{{ asset('assets/js/pages/form-editor.init.js') }}"></script>
@endsection

@section("script-bottom")
	<script>
		let optionValueRowLatestId = 0;
		const emptySlots = [];

		const optionValueRowGenerator = (optionValueId) => {
			return `
				<div class="row mt-2" id="option-value-row-${ optionValueId }">
					<div class="col-xl-6">
						<input type="text" class="inner form-control" placeholder="Option Value Name" name="option_values[${ optionValueId }][name]" minlength="3" maxlength="50" required>
					</div>
					<div class="col-xl-5">
						<input type="file" accept="image/*" class="inner form-control" placeholder="Option Value Image" name="option_values[${ optionValueId }][image]">
					</div>
					<div class="col-xl-1">
						<div class="d-grid">
							<button title="Delete" type="button" class="btn btn-danger inner" onclick="deleteOptionValueRow(${ optionValueId })">
								<i class="fa fa-trash"></i>
							</button>
						</div>
					</div>
				</div>
			`;
		};

		const addOptionValueRow = () => {
			const optionValueRowIdToAdd = emptySlots.pop() ?? optionValueRowLatestId++;
			const optionValueRowHtml = optionValueRowGenerator(optionValueRowIdToAdd);

			const submitButtonDiv = document.getElementById("add-option-value-row-div");
			submitButtonDiv.insertAdjacentHTML("beforebegin", optionValueRowHtml);
		};

		const deleteOptionValueRow = (optionValueRowId) => {
			const optionValueRow = document.getElementById(`option-value-row-${ optionValueRowId }`);
			if (!optionValueRow) return;

			emptySlots.push(optionValueRowId);
			optionValueRow.remove();
		};
	</script>
@endsection
