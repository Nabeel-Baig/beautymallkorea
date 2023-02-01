@extends('layouts.master')

@section('title')
	Create {{ $title }}
@endsection

@section('page-specific-css')
	<!-- Plugins css -->
	<link rel="stylesheet" type="text/css" href="{{ asset('assets/libs/select2/select2.min.css') }}">
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
					<form method="POST" action="{{ route("admin.brands.store") }}" class="custom-validation" enctype="multipart/form-data">
						@csrf
						<div class="mb-3">
							<label for="brand_name" class="form-label">Brand Name</label>
							<input name="name" id="brand_name" value="{{ old("name") }}" class="form-control @error('name') parsley-error @enderror" required>
							@error("name")
							<span class="text-red">{{ $message }}</span>
							@enderror
						</div>

						<div class="mb-3">
							<label for="brand_country" class="form-label">Brand Country</label>
							<select name="country_code" id="brand_country" style="width: 100%" class="form-control select2 @error("country_code") parsley-error @enderror" required>
								@foreach($countries as $country)
									<option value="{{ $country->countryCode }}" data-country-image="{{ asset($country->countryFlag) }}">{{ $country->countryName }}</option>
								@endforeach
							</select>
							@error("country_code")
							<span class="text-red">{{ $message }}</span>
							@enderror
						</div>

						<div class="mb-3">
							<label for="brand_image" class="form-label">Brand Image</label>
							<div class="input-group-btn">
								<div class="image-upload">
									<img src="{{ asset("images/placeholder.png") }}" alt="brand-main-image">
									<div class="file-btn">
										<input accept="image/*" type="file" id="brand_image" name="brand_image" required>
										<label class="btn btn-info">Upload</label>
									</div>
								</div>
							</div>
						</div>

						<div class="mb-3">
							<label for="brand_sort" class="form-label">Brand Sort Order</label>
							<input type="number" name="sort_order" id="brand_sort" value="{{ old("sort_order") }}" class="form-control @error("sort_order") parsley-error @enderror">
							@error("sort_order")
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
	<!-- select2 -->
	<script src="{{ asset('assets/libs/select2/select2.min.js') }}"></script>
@endsection

@section("script-bottom")
	<script>
		const formatBrandOptions = (state) => {
			if (!state.id) return state.text;
			const countryImageUrl = $(state.element).data("country-image");
			const countryImage = `<span><img src="${ countryImageUrl }" width="50" alt="country-flag"/>  ${ state.text }</span>`;

			return $(countryImage);
		};

		$(function() {
			$("#brand_country").select2({
				templateResult: formatBrandOptions,
			});
		});
	</script>
@endsection
