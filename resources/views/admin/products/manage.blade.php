@php use App\Enums\SubtractStock; @endphp
@php use App\Enums\RequireShipping; @endphp
	<!--suppress HtmlFormInputWithoutLabel -->

@extends('layouts.master')

@section('title')
	Edit {{ $title }}
@endsection

@section('page-specific-css')
	<!-- Plugins css -->
	<link rel="stylesheet" type="text/css" href="{{ asset('assets/libs/select2/select2.min.css') }}">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/css/dropify.min.css"/>
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
					<form method="POST" action="{{ route("admin.products.manage.update", ["product" => $model->id ?? null]) }}" class="custom-validation" enctype="multipart/form-data">
						@csrf
						@method('PATCH')

						<ul class="nav nav-tabs" role="tablist">
							<li class="nav-item">
								<a class="nav-link active" data-bs-toggle="tab" href="#general" role="tab">
									<span class="d-block d-sm-none">
										<i class="fas fa-home"></i>
									</span>
									<span class="d-none d-sm-block">General</span>
								</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" data-bs-toggle="tab" href="#data" role="tab">
									<span class="d-block d-sm-none">
										<i class="far fa-user"></i>
									</span>
									<span class="d-none d-sm-block">Data</span>
								</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" data-bs-toggle="tab" href="#links" role="tab">
									<span class="d-block d-sm-none">
										<i class="far fa-envelope"></i>
									</span>
									<span class="d-none d-sm-block">Links</span>
								</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" data-bs-toggle="tab" href="#options" role="tab">
									<span class="d-block d-sm-none">
										<i class="fas fa-cog"></i>
									</span>
									<span class="d-none d-sm-block">Options</span>
								</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" data-bs-toggle="tab" href="#image" role="tab">
									<span class="d-block d-sm-none">
										<i class="fas fa-cog"></i>
									</span>
									<span class="d-none d-sm-block">Image</span>
								</a>
							</li>
						</ul>

						<!-- Tab panes -->
						<div class="tab-content p-3 text-muted">
							<div class="tab-pane active" id="general" role="tabpanel">
								<div class="mb-3">
									<label for="product_name" class="form-label">Product Name</label>
									<input type="text" name="product[name]" id="product_name" value="{{ $model->name ?? old("product.name") }}" minlength="3" maxlength="50" class="form-control @error('product.name') parsley-error @enderror" required>
									@error('product.name')
									<span class="text-red">{{ $message }}</span>
									@enderror
								</div>

								<div class="mb-3">
									<label for="product_description" class="form-label">Description</label>
									<textarea name="product[description]" id="product_description" minlength="3" class="form-control @error('product.description') parsley-error @enderror" required>{{ $model->description ?? old("product.description") }}</textarea>
									@error('product.description')
									<span class="text-red">{{ $message }}</span>
									@enderror
								</div>

								<div class="mb-3">
									<label for="product_meta_title" class="form-label">Meta Tag Title</label>
									<input type="text" name="product[meta_title]" id="product_meta_title" value="{{ $model->meta_title ?? old("product.meta_title") }}" minlength="3" maxlength="50" class="form-control @error('product.meta_title') parsley-error @enderror">
									@error("product.meta_title")
									<span class="text-red">{{ $message }}</span>
									@enderror
								</div>

								<div class="mb-3">
									<label for="product_meta_description" class="form-label">Meta Tag Description</label>
									<input type="text" name="product[meta_description]" id="product_meta_description" value="{{ $model->meta_description ?? old("product.meta_description") }}" minlength="3" maxlength="50" class="form-control @error('product.meta_description') parsley-error @enderror">
									@error("product.meta_description")
									<span class="text-red">{{ $message }}</span>
									@enderror
								</div>

								<div class="mb-3">
									<label for="product_meta_keywords" class="form-label">Meta Tag Keywords</label>
									<input type="text" name="product[meta_keywords]" id="product_meta_keywords" value="{{ $model->meta_keywords ?? old("product.meta_keywords") }}" minlength="3" maxlength="50" class="form-control @error('product.meta_keywords') parsley-error @enderror">
									@error("product.meta_keywords")
									<span class="text-red">{{ $message }}</span>
									@enderror
								</div>

								<div class="mb-3">
									<label for="product_tags" class="form-label">Product Tags</label>
									<select name="tags[]" id="product_tags" style="width: 100%" class="form-control select2 @error('tags') parsley-error @enderror" multiple>
										@foreach($tags as $tag)
											<option value="{{ $tag->id }}" @if(in_array($tag->id, $assignedTags, true)) selected @endif>{{ $tag->name }}</option>
										@endforeach
									</select>
									@error("tags")
									<span class="text-red">{{ $message }}</span>
									@enderror
								</div>
							</div>

							<div class="tab-pane" id="data" role="tabpanel">
								<div class="mb-3">
									<label for="product_sku" class="form-label">SKU</label>
									<input type="text" name="product[sku]" id="product_sku" value="{{ $model->sku ?? old("product.sku") }}" minlength="3" maxlength="50" class="form-control @error('product.sku') parsley-error @enderror" required>
									@error('product.sku')
									<span class="text-red">{{ $message }}</span>
									@enderror
								</div>

								<div class="mb-3">
									<label for="product_upc" class="form-label">UPC</label>
									<input type="text" name="product[upc]" id="product_upc" value="{{ $model->upc ?? old("product.upc") }}" minlength="3" maxlength="50" class="form-control @error('product.upc') parsley-error @enderror" required>
									@error('product.upc')
									<span class="text-red">{{ $message }}</span>
									@enderror
								</div>

								<div class="mb-3">
									<label for="product_price" class="form-label">Price</label>
									<input type="number" name="product[price]" id="product_price" value="{{ $model->price ?? old("product.price") }}" min="0" step="0.01" class="form-control @error('product.price') parsley-error @enderror" required>
									@error('product.price')
									<span class="text-red">{{ $message }}</span>
									@enderror
								</div>

								<div class="mb-3">
									<label for="product_quantity" class="form-label">Quantity</label>
									<input type="number" name="product[quantity]" id="product_quantity" value="{{ $model->quantity ?? old("product.quantity") }}" min="1" step="1" class="form-control @error('product.quantity') parsley-error @enderror" required>
									@error('product.quantity')
									<span class="text-red">{{ $message }}</span>
									@enderror
								</div>

								<div class="mb-3">
									<label for="product_min_order_quantity" class="form-label">Minimum Orderable Quantity</label>
									<input type="number" name="product[min_order_quantity]" id="product_min_order_quantity" value="{{ $model->min_order_quantity ?? old("product.min_order_quantity") }}" min="1" step="1" class="form-control @error('product.min_order_quantity') parsley-error @enderror">
									@error('product.min_order_quantity')
									<span class="text-red">{{ $message }}</span>
									@enderror
								</div>

								<div class="mb-3">
									<label for="product_subtract_stock" class="form-label">Subtract Stock</label>
									<select name="product[subtract_stock]" id="product_subtract_stock" class="form-control @error('product.subtract_stock') parsley-error @enderror">
										<option value="{{ SubtractStock::YES }}" @if($model?->subtract_stock === SubtractStock::YES) selected @endif>Yes</option>
										<option value="{{ SubtractStock::NO }}" @if($model?->subtract_stock === SubtractStock::NO) selected @endif>No</option>
									</select>
									@error('product.subtract_stock')
									<span class="text-red">{{ $message }}</span>
									@enderror
								</div>

								<div class="mb-3">
									<label for="product_require_shipping" class="form-label">Require Shipping</label>
									<select name="product[require_shipping]" id="product_require_shipping" class="form-control @error('product.require_shipping') parsley-error @enderror">
										<option value="{{ RequireShipping::YES }}" @if($model?->require_shipping === RequireShipping::YES) selected @endif>Yes</option>
										<option value="{{ RequireShipping::NO }}" @if($model?->require_shipping === RequireShipping::NO) selected @endif>No</option>
									</select>
									@error('product.require_shipping')
									<span class="text-red">{{ $message }}</span>
									@enderror
								</div>
							</div>

							<div class="tab-pane" id="links" role="tabpanel">
								<div class="mb-3">
									<label for="product_categories" class="form-label">Categories</label>
									<select name="categories[]" id="product_categories" style="width: 100%" class="form-control select2 @error('categories') parsley-error @enderror" multiple>
										@foreach($categories as $category)
											<option value="{{ $category->id }}" @if(in_array($category->id, $assignedCategories, true)) selected @endif>{{ $category->name }}</option>
										@endforeach
									</select>
									@error("categories")
									<span class="text-red">{{ $message }}</span>
									@enderror
								</div>

								<div class="mb-3">
									<label for="product_related_products" class="form-label">Related Products</label>
									<select name="related_products[]" id="product_related_products" style="width: 100%" class="form-control select2 @error('related_products') parsley-error @enderror" multiple>
										@foreach($relatedProducts as $relatedProduct)
											<option value="{{ $relatedProduct->id }}" @if(in_array($relatedProduct->id, $assignedRelatedProducts, true)) selected @endif>{{ $relatedProduct->name }}</option>
										@endforeach
									</select>
									@error("related_products")
									<span class="text-red">{{ $message }}</span>
									@enderror
								</div>
							</div>

							<div class="tab-pane" id="options" role="tabpanel">
								<!-- -->
							</div>

							<div class="tab-pane" id="image" role="tabpanel">
								<div class="mb-3">
									<label for="product_image" class="form-label">Image</label>
									<input type="file" name="product[image]" id="product_image" class="inner form-control">
									<input type="hidden" name="product[old_image]" value="{{ $model?->old_image ?? old("product.old_image") }}">
								</div>
							</div>
						</div>

						<div class="mb-3" id="submit-button-div">
							<button type="submit" class="btn btn-primary waves-effect waves-light mr-1">Save</button>
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
		$(function () {
			$(".select2").select2();
		});
	</script>
@endsection
