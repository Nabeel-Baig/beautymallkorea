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
			{{ $title }}
		@endslot
		@slot('title')
			{{ "Create ".$title }}
		@endslot
	@endcomponent

	<!-- end row -->
	<div class="row">
		<div class="col-xl-6">
			<div class="card">
				<div class="card-body">

					<form method="POST" action="{{ route('admin.'.request()->segment(2).'.store') }}" class="custom-validation"
						  enctype="multipart/form-data">
						@csrf
						<div class="mb-3">
							<label class="form-label">{{ ucwords(str_replace('_',' ','select_category')) }}</label>
							<select name="category_id" id="category_id" class="form-control @error('category_id') parsley-error @enderror" required>
								<option value="">{{ ucwords(str_replace('_',' ','select_category')) }}</option>
								@forelse($categories as $id => $categories)
									<option value="{{ $id }}">{{ $categories }}</option>
								@empty
								@endforelse
							</select>
							@error('category_id')
							<span class="text-red">{{ $message }}</span>
							@enderror
						</div>

						<div class="mb-3">
							<label class="form-label">{{ ucwords(str_replace('_',' ','name')) }}</label>
							<input type="text" class="form-control @error('name') parsley-error @enderror" name="name"
								   id="name" placeholder="{{ ucwords(str_replace('_',' ','name')) }}" value="{{ old('name') }}" required/>
							@error('name')
							<span class="text-red">{{ $message }}</span>
							@enderror
						</div>

						<div class="mb-3">
							<label class="form-label">{{ ucwords(str_replace('_',' ','description')) }}</label>
							<textarea class="form-control" name="description" id="description" placeholder="{{ ucwords(str_replace('_',' ','description')) }}">{{ old('description') }}</textarea>
							@error('description')
							<span class="text-red">{{ $message }}</span>
							@enderror
						</div>

						<div class="mb-3">
							<label class="form-label">{{ ucwords(str_replace('_',' ','amount')) }}</label>
							<input type="number" class="form-control @error('amount') parsley-error @enderror" name="amount"
								   id="name" placeholder="{{ ucwords(str_replace('_',' ','amount')) }}" value="{{ old('amount') }}" required/>
							@error('amount')
							<span class="text-red">{{ $message }}</span>
							@enderror
						</div>

						<div class="mb-3">
							<input type="file" id="image" class="dropify" name="image" value="{{ old('image') }}" data-height="200">
							@error('image')
							<span class="text-red">{{ $message }}</span>
							@enderror
						</div>

						<div class="d-flex flex-wrap gap-2">
							<button type="submit" class="btn btn-primary waves-effect waves-light">
								Submit
							</button>
						</div>
					</form>

				</div>
			</div>
		</div> <!-- end col -->
	</div> <!-- end row -->

@endsection
@section('script')
	<script src="{{ asset('assets/libs/parsleyjs/parsleyjs.min.js') }}"></script>
	<script src="{{ asset('assets/js/pages/form-validation.init.js') }}"></script>
	<!-- Plugins js -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/js/dropify.min.js"></script>
@endsection
@section('script-bottom')
	<script>
		$(function () {
			$(".dropify").dropify({
				messages: {
					"default": "Drop a file OR click",
				}
			});
		});
	</script>
@endsection
