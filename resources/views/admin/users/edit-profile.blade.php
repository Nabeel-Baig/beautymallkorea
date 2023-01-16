@extends('layouts.master')
@section('title')
	Edit {{ $title }}
@endsection
@section('page-specific-css')
	<!-- Select2 css -->
	<link rel="stylesheet" type="text/css" href="{{ asset('assets/libs/select2/select2.min.css') }}">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/css/dropify.min.css"/>
@endsection
@section('content')
	@component('components.breadcrumb')
		@slot('li_1')
			{{ $title }}
		@endslot
		@slot('title')
			{{ "Edit ".$title }}
		@endslot
	@endcomponent

	<!-- end row -->
	<div class="row">
		<div class="col-xl-6">
			<div class="card">
				<div class="card-body">

					<form method="POST" action="{{ route('admin.updateProfile',[auth()->user()->id]) }}" class="custom-validation" enctype="multipart/form-data">
						@csrf
						@method('PUT')

						<div class="mb-3">
							<label class="form-label">{{ ucwords(str_replace('_',' ','name')) }}</label>
							<input type="text" class="form-control @error('name') parsley-error @enderror" name="name"
								   id="name" placeholder="{{ ucwords(str_replace('_',' ','name')) }}" value="{{ old('name', isset($user) ? auth()->user()->name : '') }}" required/>
							@error('name')
							<span class="text-red">{{ $message }}</span>
							@enderror
						</div>

						<div class="mb-3">
							<label class="form-label">{{ ucwords(str_replace('_',' ','email')) }}</label>
							<input type="email" class="form-control @error('email') parsley-error @enderror"
								   name="email" id="email" placeholder="{{ ucwords(str_replace('_',' ','email')) }}" value="{{ old('email', auth()->user()->email ?? '') }}" disabled/>
							@error('email')
							<span class="text-red">{{ $message }}</span>
							@enderror
						</div>

						<div class="mb-3">
							<label class="form-label">{{ ucwords(str_replace('_',' ','phone')) }}</label>
							<input type="number" class="form-control @error('phone') parsley-error @enderror"
								   name="phone" id="phone" placeholder="{{ ucwords(str_replace('_',' ','phone')) }}" value="{{ old('phone', auth()->user()->phone ?? '') }}" required/>
							@error('phone')
							<span class="text-red">{{ $message }}</span>
							@enderror
						</div>

						<div class="mb-3">
							<label class="form-label">{{ ucwords(str_replace('_',' ','dob')) }}</label>
							<input type="date" class="form-control"
								   name="dob" id="dob" placeholder="{{ ucwords(str_replace('_',' ','dob')) }}" value="{{ old('dob', auth()->user()->dob ?? '') }}"/>
						</div>

						<div class="mb-3">
							<label class="form-label">{{ ucwords(str_replace('_',' ','address')) }}</label>
							<textarea class="form-control" name="address" id="address" placeholder="{{ ucwords(str_replace('_',' ','address')) }}">{{ old('address', auth()->user()->address ?? '') }}</textarea>
							@error('address')
							<span class="text-red">{{ $message }}</span>
							@enderror
						</div>

						<div class="mb-3">
							<input type="file" id="avatar" class="dropify" name="avatar" value="{{ old('avatar') }}" data-height="200">
							@error('avatar')
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
	<!-- Plugins js -->
	<script src="{{ asset('assets/js/pages/form-validation.init.js') }}"></script>
	<script src="{{ asset('assets/libs/select2/select2.min.js') }}"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/js/dropify.min.js"></script>
@endsection
@section('script-bottom')
	<script>
		$(function () {
			$("#avatar").dropify({
				defaultFile: "{{ asset(auth()->user()->avatar) }}",
				messages: {
					"default": "Drop a file OR click",
				}
			});
			$(".select2").select2();
			$(".select-all").click(function () {
				let $select2 = $(this).parent().siblings(".select2");
				$select2.find("option").prop("selected", "selected");
				$select2.trigger("change");
			});
			$(".deselect-all").click(function () {
				let $select2 = $(this).parent().siblings(".select2");
				$select2.find("option").prop("selected", "");
				$select2.trigger("change");
			});
		});
	</script>
@endsection
