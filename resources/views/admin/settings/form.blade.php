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
			{{ "Edit ".$title }}
		@endslot
	@endcomponent

	<!-- end row -->
	<div class="row" xmlns="http://www.w3.org/1999/html">
		<div class="col-xl-6">
			<div class="card">
				<div class="card-body">

					<form method="POST" action="{{ route('admin.settings.update', [$setting->id]) }}" class="custom-validation" enctype="multipart/form-data">
						@csrf
						@method('PUT')
						<div class="form-group">
							<label>{{ ucwords(str_replace('_',' ','name')) }}</label>
							<input type="text" class="form-control @error('name') parsley-error @enderror"
								   value="{{ $setting->name ?? '' }}" name="name" id="name"
								   placeholder="{{ ucwords(str_replace('_',' ','name')) }}" required/>
							@error('name')
							<span class="text-red">{{ $message }}</span>
							@enderror
						</div>
						<div class="form-group">
							<label>{{ ucwords(str_replace('_',' ','title')) }}</label>
							<input type="text" class="form-control @error('title') parsley-error @enderror"
								   value="{{ $setting->title ?? '' }}" name="title" id="title"
								   placeholder="{{ ucwords(str_replace('_',' ','title')) }}" required/>
							@error('title')
							<span class="text-red">{{ $message }}</span>
							@enderror
						</div>
						<div class="form-group">
							<label>{{ ucwords(str_replace('_',' ','email')) }}</label>
							<input type="email" class="form-control @error('email') parsley-error @enderror"
								   value="{{ $setting->email ?? '' }}" name="email" id="email"
								   placeholder="{{ ucwords(str_replace('_',' ','email')) }}" required/>
							@error('email')
							<span class="text-red">{{ $message }}</span>
							@enderror
						</div>
						<div class="form-group">
							<label>{{ ucwords(str_replace('_',' ','phone')) }}</label>
							<input type="text" class="form-control @error('phone') parsley-error @enderror"
								   value="{{ $setting->phone ?? '' }}" name="phone" id="phone"
								   placeholder="{{ ucwords(str_replace('_',' ','phone')) }}" required/>
							@error('phone')
							<span class="text-red">{{ $message }}</span>
							@enderror
						</div>
						<div class="form-group">
							<label>{{ ucwords(str_replace('_',' ','address')) }}</label>
							<textarea class="form-control @error('address') parsley-error @enderror" name="address" id="address"
									  placeholder="{{ ucwords(str_replace('_',' ','address')) }}" required>{{ $setting->address ?? '' }}</textarea>
							@error('address')
							<span class="text-red">{{ $message }}</span>
							@enderror
						</div>
						<div class="form-group">
							<label>{{ ucwords(str_replace('_',' ','link')) }}</label>
							<input type="url" class="form-control"
								   value="{{ $setting->link ?? '' }}" name="link" id="link"
								   placeholder="{{ ucwords(str_replace('_',' ','link')) }}"/>
						</div>

						<div class="form-group">
							<label>{{ ucwords(str_replace('_',' ','logo')) }}</label>
							<input type="file" id="logo" class="dropify" name="logo" data-height="200">
							@error('logo')
							<span class="text-red">{{ $message }}</span>
							@enderror
						</div>

						<div class="form-group">
							<label>{{ ucwords(str_replace('_',' ','favico')) }}</label>
							<input type="file" id="favico" class="dropify" name="favico" data-height="200">
							@error('favico')
							<span class="text-red">{{ $message }}</span>
							@enderror
						</div>

						<div class="form-group">
							<label>{{ ucwords(str_replace('_',' ','footer_logo')) }}</label>
							<input type="file" id="footer_logo" class="dropify" name="footer_logo" data-height="200">
							@error('footer_logo')
							<span class="text-red">{{ $message }}</span>
							@enderror
						</div>
						<div class="form-group">
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
@endsection
@section('script-bottom')
	<script>
		$(function () {
			$("#logo").dropify({
				defaultFile: "{{ asset($setting->logo) }}",
				messages: {
					"default": "Drop a file OR click",
				}
			});

			$("#favico").dropify({
				defaultFile: "{{ asset($setting->favico) }}",
				messages: {
					"default": "Drop a file OR click",
				}
			});

			$("#footer_logo").dropify({
				defaultFile: "{{ asset($setting->footer_logo) }}",
				messages: {
					"default": "Drop a file OR click",
				}
			});
		});
	</script>
@endsection
