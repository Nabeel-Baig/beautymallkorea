<!--suppress HtmlFormInputWithoutLabel -->

@extends('layouts.master')

@section('title')
	Edit {{ $title }}
@endsection

@section('page-specific-css')
	<!-- Plugins css -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/css/dropify.min.css" />
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
					<form method="POST" action="{{ route("admin.options.update", ["option" => $model->id]) }}" class="custom-validation" enctype="multipart/form-data">
						@csrf
						@method('PATCH')

						<div class="mb-3">
							<label for="option_name" class="form-label">Variant Name</label>
							<input type="text" name="name" id="option_name" value="{{ old("name") ?? $model->name }}" minlength="3" maxlength="50" class="form-control @error('name') parsley-error @enderror" required>
							@error('name')
							<span class="text-red">{{ $message }}</span>
							@enderror
						</div>

						@foreach($model->optionValues as $index => $optionValue)
							<div class="row mt-2" id="option-value-row-{{ $index }}">
								<input type="hidden" name="option_values[{{ $index }}][id]" value="{{ $optionValue->id }}">

								<div class="col-5">
									<input type="text" class="inner form-control" value="{{ old("name") ?? $optionValue->name }}" placeholder="Variant Value Name" name="option_values[{{ $index }}][name]" minlength="3" maxlength="50" required>
								</div>

								<div class="col-5">
									<div class="input-group-btn">
										<div class="image-upload">
											<img id="option-value-image-{{ $index }}" src="{{ asset('images/placeholder.png') }}" alt="option-image">
											<div class="file-btn">
												<input type="file" id="option_image_{{ $index }}" onchange="previewImage(event, {{ $index }})" name="option_values[{{ $index }}][image]">
												<label class="btn btn-info">Upload</label>
											</div>
										</div>
									</div>

									<input type="hidden" value="{{ $optionValue->image }}" name="option_values[{{ $index }}][old_image]">
								</div>

								<div class="col-2">
									<div class="d-grid">
										<button title="Delete" type="button" class="btn btn-danger inner" onclick="deleteOptionValueRow(${ optionValueId })">
											<i class="fa fa-trash"></i>
											Remove Variant Value
										</button>
									</div>
								</div>
							</div>
						@endforeach

						<div class="mt-3 mb-3" id="add-option-value-row-div">
							<button type="button" class="btn btn-success waves-effect waves-light mr-1" onclick="addOptionValueRow()">Add Variant Value</button>
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
		let optionValueRowLatestId = {{ $model->optionValues->count() }};
		const emptySlots = [];

		const optionValueRowGenerator = (optionValueId) => {
			const placeholderImage = '{{ asset('images/placeholder.png') }}';

			return `
				<div class="row mt-2" id="option-value-row-${ optionValueId }">
					<div class="col-5">
						<input type="text" class="inner form-control" placeholder="Variant Value Name" name="option_values[${ optionValueId }][name]" minlength="3" maxlength="50" required>
					</div>
					<div class="col-5">
						<div class="input-group-btn">
							<div class="image-upload">
								<img id="option-value-image-${ optionValueId }" src="${ placeholderImage }" alt="option-image">
								<div class="file-btn">
									<input type="file" id="option_image_${ optionValueId }" onchange="previewImage(event, ${ optionValueId })" name="option_values[${ optionValueId }][image]">
									<label class="btn btn-info">Upload</label>
								</div>
							</div>
						</div>
					</div>
					<div class="col-2">
						<div class="d-grid">
							<button title="Delete" type="button" class="btn btn-danger inner" onclick="deleteOptionValueRow(${ optionValueId })">
								<i class="fa fa-trash"></i>
								Remove Variant Value
							</button>
						</div>
					</div>
				</div>
			`;
		};

		const previewImage = (event, optionValueId) => {
			const previewImageContainer = document.getElementById(`option-value-image-${ optionValueId }`);
			previewImageContainer.src = URL.createObjectURL(event.target.files[0]);
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
