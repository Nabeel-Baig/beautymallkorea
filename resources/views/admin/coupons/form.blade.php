@php
	use App\Enums\CouponType;
	if (request()->segment(3) == 'create') {
		$action = route("admin.coupons.store");
		$page = 'Create';
	} elseif (request()->segment(4) == 'edit') {
		$action = route("admin.coupons.update", [$coupon->id]);
		$page = 'Edit';
	}
@endphp
@extends('layouts.master')
@section('title')
	Create {{ $title }}
@endsection
@section('page-specific-css')
	<!-- Plugins css -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/css/dropify.min.css"/>
	<link rel="stylesheet" type="text/css" href="{{ asset("assets/libs/select2/select2.min.css") }}">
@endsection
@section('content')
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
							<input type="text" name="name" id="name" value="{{ old("name", $coupon->name??'') }}"
								   class="form-control @error("name") parsley-error @enderror" required>
							@error('name')
							<span class="text-red">{{ $message }}</span>
							@enderror
						</div>

						<div class="mb-3">
							<label for="code" class="form-label">{{ ucwords(str_replace('_',' ','code')) }}</label>
							<input type="text" name="code" id="code" value="{{ old("code", $coupon->code??'') }}"
								   class="form-control @error("code") parsley-error @enderror" required>
							@error('code')
							<span class="text-red">{{ $message }}</span>
							@enderror
						</div>

						<div class="mb-3">
							<label for="type" class="form-label">Require Shipping</label>
							<select name="product[require_shipping]" id="type"
									class="form-control @error("type") parsley-error @enderror" required>
								<option value="">Select Coupon Type</option>
								@foreach(CouponType::cases() as $couponTypes)
									<option value="{{ $couponTypes->value }}"
											>{{ CouponType::formattedName($couponTypes) }}</option>
								@endforeach
							</select>
							@error("type")
							<span class="text-red">{{ $message }}</span>
							@enderror
						</div>

						<div class="mb-3">
							<label for="discount" class="form-label">{{ ucwords(str_replace('_',' ','discount')) }}</label>
							<input type="number" name="discount" id="discount" value="{{ old("discount", $coupon->discount??'') }}"
								   class="form-control @error("discount") parsley-error @enderror" required>
							@error('discount')
							<span class="text-red">{{ $message }}</span>
							@enderror
						</div>

						<div class="mb-3">
							<label for="date_start" class="form-label">{{ ucwords(str_replace('_',' ','date_start')) }}</label>
							<input type="date" name="date_start" id="date_start" value="{{ old("date_start", $coupon->date_start??'') }}"
								   class="form-control @error("date_start") parsley-error @enderror" required>
							@error('date_start')
							<span class="text-red">{{ $message }}</span>
							@enderror
						</div>

						<div class="mb-3">
							<label for="date_end" class="form-label">{{ ucwords(str_replace('_',' ','date_end')) }}</label>
							<input type="date" name="date_end" id="date_end" value="{{ old("date_end", $coupon->date_end??'') }}"
								   class="form-control @error("date_end") parsley-error @enderror" required>
							@error('date_end')
							<span class="text-red">{{ $message }}</span>
							@enderror
						</div>

						<div class="mb-3">
							<label for="product_id" class="form-label">Products
								<span title="Choose specific products the coupon will apply to. Select no products to apply coupon to entire cart."><i class="fas fa-info"></i></span>
							</label>
							<select name="product_id[]" id="coupons_products" style="width: 100%" class="form-control select2" multiple>
								@foreach($products as $product)
									<option value="{{ $product->id }}">{{ $product->name }}</option>
								@endforeach
							</select>
						</div>

						<div class="mb-3">
							<label for="category_id" class="form-label">Categories
								<span title="Choose all products under selected category. Select no categories to apply coupon to entire cart."><i class="fas fa-info"></i></span>
							</label>
							<select name="category_id[]" id="coupons_categories" style="width: 100%" class="form-control select2" multiple>
								@foreach($categories as $category)
									<option value="{{ $category->id }}">{{ $category->name }}</option>
								@endforeach
							</select>
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
	<!-- select2 -->
	<script src="{{ asset("assets/libs/select2/select2.min.js") }}"></script>
@endsection
@section('script-bottom')
	<script>
        $(function () {
			$("#coupons_products, #coupons_categories").select2({
				closeOnSelect: false,
			});
		});
	</script>
@endsection
