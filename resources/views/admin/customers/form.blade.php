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
			$action = route("admin.customers.store");
			$page = 'Create';
		} elseif (request()->segment(4) == 'edit') {
			$action = route("admin.customers.update", [$customer->id]);
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
							<label for="first_name" class="form-label">{{ ucwords(str_replace('_',' ','first_name')) }}</label>
							<input type="text" name="first_name" id="first_name" value="{{ old("first_name", $customer->first_name??'') }}" class="form-control" required>
							@error('first_name')
							<span class="text-red">{{ $message }}</span>
							@enderror
						</div>

						<div class="mb-3">
							<label for="last_name" class="form-label">{{ ucwords(str_replace('_',' ','last_name')) }}</label>
							<input type="text" name="last_name" id="last_name" value="{{ old("last_name", $customer->last_name??'') }}" class="form-control" required>
							@error('last_name')
							<span class="text-red">{{ $message }}</span>
							@enderror
						</div>

						<div class="mb-3">
							<label for="email" class="form-label">{{ ucwords(str_replace('_',' ','email')) }}</label>
							<input type="email" name="email" id="email" value="{{ old("email", $customer->email??'') }}" class="form-control" required>
							@error('email')
							<span class="text-red">{{ $message }}</span>
							@enderror
						</div>

						<div class="mb-3">
							<label for="password" class="form-label">{{ ucwords(str_replace('_',' ','password')) }}</label>
							<input type="password" name="password" id="password2" class="form-control" required>
							@error('password')
							<span class="text-red">{{ $message }}</span>
							@enderror
						</div>

						<div class="mb-3">
							<label for="password_confirmation" class="form-label">{{ ucwords(str_replace('_',' ','password_confirmation')) }}</label>
							<input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required data-parsley-equalto="#password2" placeholder="Re-Type Password">
						</div>

						<div class="mb-3">
							<label for="contact" class="form-label">{{ ucwords(str_replace('_',' ','contact')) }}</label>
							<input type="number" name="contact" id="contact" value="{{ old("contact", $customer->contact??'') }}" class="form-control" required>
							@error('contact')
							<span class="text-red">{{ $message }}</span>
							@enderror
						</div>

						<div class="mb-3">
							<label>{{ ucwords(str_replace('_',' ','profile_picture')) }}</label>
							<input type="file" id="profile_picture" class="dropify" name="profile_picture" data-height="200">
							@error('profile_picture')
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
			$("#profile_picture").dropify({
				defaultFile: "{{ asset($customer->profile_picture ?? 'images/placeholder.png') }}",
				messages: {
					"default": "Drop a file OR click",
				}
			});
		});
	</script>
@endsection
