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

					<form method="POST" action="{{ route('admin.users.update',[$user->id]) }}" class="custom-validation" enctype="multipart/form-data">
						@csrf
						@method('PUT')
						<div class="mb-3">
							<label class="required" for="role">Select Roles</label>
							<div style="padding-bottom: 4px">
								<span class="btn btn-info btn-xs select-all" style="border-radius: 0">Select All</span>
								<span class="btn btn-danger btn-xs deselect-all"
									  style="border-radius: 0">Deselect All</span>
							</div>
							<select class="form-control select2 {{ $errors->has('roles') ? 'parsley-error' : '' }}"
									name="roles[]" id="roles" multiple required>
								@foreach($roles as $id => $roles)
									<option value="{{ $id }}" {{ (in_array($id, old('role', [])) || isset($user) && $user->roles->contains($id)) ? 'selected' : '' }}>{{ $roles }}</option>
								@endforeach
							</select>
							@if($errors->has('roles'))
								<span class="text-danger">{{ $errors->first('roles') }}</span>
							@endif
						</div>

						<div class="mb-3">
							<label class="form-label">{{ ucwords(str_replace('_',' ','name')) }}</label>
							<input type="text" class="form-control @error('name') parsley-error @enderror" name="name"
								   id="name" placeholder="{{ ucwords(str_replace('_',' ','name')) }}" value="{{ old('name', isset($user) ? $user->name : '') }}" required/>
							@error('name')
							<span class="text-red">{{ $message }}</span>
							@enderror
						</div>

						<div class="mb-3">
							<label class="form-label">{{ ucwords(str_replace('_',' ','email')) }}</label>
							<input type="email" class="form-control @error('email') parsley-error @enderror"
								   name="email" id="email" placeholder="{{ ucwords(str_replace('_',' ','email')) }}" value="{{ old('email', $user->email ?? '') }}" disabled/>
							@error('email')
							<span class="text-red">{{ $message }}</span>
							@enderror
						</div>

						<div class="mb-3">
							<label class="form-label">{{ ucwords(str_replace('_',' ','phone')) }}</label>
							<input type="number" class="form-control @error('phone') parsley-error @enderror"
								   name="phone" id="phone" placeholder="{{ ucwords(str_replace('_',' ','phone')) }}" value="{{ old('phone', $user->phone ?? '') }}" required/>
							@error('phone')
							<span class="text-red">{{ $message }}</span>
							@enderror
						</div>

						<div class="mb-3">
							<label class="form-label">{{ ucwords(str_replace('_',' ','dob')) }}</label>
							<input type="date" class="form-control"
								   name="dob" id="dob" placeholder="{{ ucwords(str_replace('_',' ','dob')) }}" value="{{ old('dob', $user->dob ?? '') }}"/>
						</div>

						<div class="mb-3">
							<label class="d-block mb-3">Gender :</label>

							<div class="form-check form-check-inline">
								<input class="form-check-input" type="radio" name="gender" id="inlineRadio1" value="Male" {{ ($user->gender === 'Male') ? 'checked' : '' }} required>
								<label class="form-check-label" for="inlineRadio1">Male</label>
							</div>
							<div class="form-check form-check-inline">
								<input class="form-check-input" type="radio" name="gender" id="inlineRadio2" value="Female" {{ ($user->gender === 'Female') ? 'checked' : '' }} required>
								<label class="form-check-label" for="inlineRadio2">Female</label>
							</div>
						</div>

						<div class="mb-3">
							<label class="form-label">{{ ucwords(str_replace('_',' ','address')) }}</label>
							<textarea class="form-control" name="address" id="address" placeholder="{{ ucwords(str_replace('_',' ','address')) }}">{{ old('address', $user->address ?? '') }}</textarea>
						</div>

						<div class="mb-3">
							<label class="form-label">{{ ucwords(str_replace('_',' ','password')) }}</label>
							<input type="password" id="pass2" name="password" class="form-control" required placeholder="{{ ucwords(str_replace('_',' ','password')) }}"/>
							@error('password')
							<span class="text-red">{{ $message }}</span>
							@enderror
						</div>
						<div class="mb-3">
							<label class="form-label">Re-Type Password</label>
							<input type="password" class="form-control" name="password_confirmation" required data-parsley-equalto="#pass2" placeholder="Re-Type Password"/>
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
				defaultFile: "{{ asset($user->avatar) }}",
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
