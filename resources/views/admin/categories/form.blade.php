@extends('layouts.master')
@section('title')
	Create {{ $title }}
@endsection
@section('page-specific-css')
	<!-- Plugins css -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/css/dropify.min.css"/>
@endsection
@section('content')
	@php
		if (request()->segment(3) == 'create') {
			$action = route("admin.categories.store");
			$page = 'Create';
		} elseif (request()->segment(4) == 'edit') {
			$action = route("admin.categories.update", [$category->id]);
			$page = 'Edit';
		}
	@endphp
	@component('components.breadcrumb')
		@slot('li_1')
			{{ $title }}
		@endslot
		@slot('title')
			{{ $page." ".$title }}
		@endslot
	@endcomponent

	<!-- end row -->
	<div class="row">
		<div class="col-xl-6">
			<div class="card">
				<div class="card-body">

					<form method="POST" action="{{ $action }}" class="custom-validation" enctype="multipart/form-data">
						@csrf
						@if(request()->segment(4) == 'edit')
							@method('PUT')
						@endif
						<div class="mb-3">
							<label class="form-label">Select {{ ucwords(str_replace('_',' ','type')) }}</label>
							<select name="type" id="type" class="form-control @error('type') parsley-error @enderror" required>
								<option value="">Select {{ ucwords(str_replace('_',' ','type')) }}</option>
								<option value="category">Category</option>
								<option value="brand">Brand</option>
							</select>
							@error('type')
							<span class="text-red">{{ $message }}</span>
							@enderror
						</div>

						<div class="mb-3">
							<label class="form-label">Select {{ ucwords(str_replace('_',' ','parent_category')) }}</label>
							<select name="category_id" id="category_id" class="form-control @error('category_id') parsley-error @enderror" required>
								<option value="">Select {{ ucwords(str_replace('_',' ','parent_category')) }}</option>
								@forelse($categories as $id => $categories)
									<option value="{{ $id }}" {{ !empty($category->id) ? (($id === $category->id) ? "selected" : "") : '' }}>{{ $categories }}</option>
								@empty
								@endforelse
							</select>
							@error('category_id')
							<span class="text-red">{{ $message }}</span>
							@enderror
						</div>

						<div class="mb-3">
							<label>{{ ucwords(str_replace('_',' ','name')) }}</label>
							<input type="text" class="form-control @error('name') parsley-error @enderror"
								   value="{{ $category->name ?? '' }}" name="name" id="name"
								   placeholder="{{ ucwords(str_replace('_',' ','name')) }}" required/>
							@error('name')
							<span class="text-red">{{ $message }}</span>
							@enderror
						</div>
						<input type="hidden" id="slug" name="slug"
							   value="{{ !empty($record->slug)?$record->slug:'' }}" data-validation="required">

						<div class="mb-3">
							<label>{{ ucwords(str_replace('_',' ','description')) }}</label>
							<textarea class="form-control @error('description') parsley-error @enderror"
									  name="description" id="elm1"
									  placeholder="{{ ucwords(str_replace('_',' ','description')) }}" required/>{{ $category->description ?? '' }}</textarea>
							@error('description')
							<span class="text-red">{{ $message }}</span>
							@enderror
						</div>

						<div class="mb-3">
							<label>{{ ucwords(str_replace('_',' ','meta_tag_title')) }}</label>
							<input type="text" class="form-control @error('meta_tag_title') parsley-error @enderror"
								   value="{{ $category->meta_tag_title ?? '' }}" name="meta_tag_title" id="meta_tag_title"
								   placeholder="{{ ucwords(str_replace('_',' ','meta_tag_title')) }}"/>
						</div>

						<div class="mb-3">
							<label>{{ ucwords(str_replace('_',' ','meta_tag_description')) }}</label>
							<input type="text" class="form-control @error('meta_tag_description') parsley-error @enderror"
								   value="{{ $category->meta_tag_description ?? '' }}" name="meta_tag_description" id="meta_tag_description"
								   placeholder="{{ ucwords(str_replace('_',' ','meta_tag_description')) }}"/>
						</div>

						<div class="mb-3">
							<label>{{ ucwords(str_replace('_',' ','meta_tag_keywords')) }}</label>
							<input type="text" class="form-control @error('meta_tag_keywords') parsley-error @enderror"
								   value="{{ $category->meta_tag_keywords ?? '' }}" name="meta_tag_keywords" id="meta_tag_keywords"
								   placeholder="{{ ucwords(str_replace('_',' ','meta_tag_keywords')) }}"/>
						</div>

						<div class="mb-3">
							<label>{{ ucwords(str_replace('_',' ','sort_order')) }}</label>
							<input type="number" class="form-control @error('sort_order') parsley-error @enderror"
								   value="{{ $category->sort_order ?? '' }}" name="sort_order" id="sort_order"
								   placeholder="{{ ucwords(str_replace('_',' ','sort_order')) }}" required/>
							@error('sort_order')
							<span class="text-red">{{ $message }}</span>
							@enderror
						</div>

						<div class="mb-3">
							<label>{{ ucwords(str_replace('_',' ','image')) }}</label>
							<input type="file" id="image" class="dropify" name="image" data-height="200">
							@error('image')
							<span class="text-red">{{ $message }}</span>
							@enderror
						</div>

						<div class="mb-3">
							<div>
								<button type="submit" class="btn btn-primary waves-effect waves-light mr-1">Submit
								</button>
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
	<script src="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/js/dropify.min.js"></script>
	<!--tinymce js-->
	<script src="{{ asset('assets/libs/tinymce/tinymce.min.js') }}"></script>
	<!-- init js -->
	<script src="{{ asset('assets/js/pages/form-editor.init.js') }}"></script>
@endsection
@section('script-bottom')
	<script>
		$(function () {
			$("#image").dropify({
				defaultFile: "{{ asset($category->image ?? '') }}",
				messages: {
					"default": "Drop a file OR click",
				}
			});
		});
	</script>
@endsection
