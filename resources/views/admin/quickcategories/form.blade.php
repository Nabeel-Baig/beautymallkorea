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
			$action = route("admin.quickcategories.store");
			$page = 'Create';
		} elseif (request()->segment(4) == 'edit') {
			$action = route("admin.quickcategories.update", [$quickcategory->id]);
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
							<label for="name" class="form-label">{{ ucwords(str_replace('_',' ','name')) }}</label>
							<input type="text" name="name" id="name" value="{{ old("name", $quickcategory->name??'') }}"
								   minlength="3" maxlength="50" class="form-control">
							@error('name')
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
							<label for="link" class="form-label">{{ ucwords(str_replace('_',' ','link')) }}</label>
							<input type="url" name="link" id="link" value="{{ old("link", $quickcategory->link ?? '') }}"
								   minlength="3" maxlength="50" class="form-control">
							@error('link')
							<span class="text-red">{{ $message }}</span>
							@enderror
						</div>

						<div class="mb-3">
							<label for="sort_order" class="form-label">{{ ucwords(str_replace('_',' ','sort_order')) }}</label>
							<input type="number" name="sort_order" id="sort_order" value="{{ old("sort_order", $quickcategory->sort_order ?? '') }}" class="form-control">
							@error('sort_order')
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
	<!-- init js -->
	<script src="{{ asset('assets/js/pages/form-editor.init.js') }}"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/js/dropify.min.js"></script>
@endsection
@section('script-bottom')
	<script>
		$(function () {
			$("#image").dropify({
				defaultFile: "{{ asset($quickcategory->image ?? 'images/placeholder.png') }}",
				messages: {
					"default": "Drop a file OR click",
				}
			});
		});
	</script>
@endsection
