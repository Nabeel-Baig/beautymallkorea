<!--suppress HtmlFormInputWithoutLabel, SpellCheckingInspection -->
@php
	use App\Enums\DimensionClass;
	use App\Enums\ProductOptionUnitAdjustment;
	use App\Enums\ProductPromotion;
	use App\Enums\ProductShipping;
	use App\Enums\ProductStockBehaviour;
	use App\Enums\WeightClass;
	use App\Models\Product;
	use App\Services\OptionValueService;

	if ($model !== null) {
		assert($model instanceof Product);
	}
@endphp

@extends("layouts.master")

@section("title")
	Edit {{ $title }}
@endsection

@section("page-specific-css")
	<!-- Plugins css -->
	<link rel="stylesheet" type="text/css" href="{{ asset("assets/libs/select2/select2.min.css") }}">
	<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
@endsection

@section("content")

	@component("components.breadcrumb")
		@slot("li_1")
			Dashboard
		@endslot
		@slot("title")
			{{ $title ?? "" }}
		@endslot
	@endcomponent

	<!-- end row -->
	<div class="row">
		<div class="col-xl-12">
			<div class="card">
				<div class="card-body">
					<form method="POST" id="product-manage" action="{{ route("admin.products.manage.update", ["product" => $model->id ?? null]) }}" class="custom-validation" enctype="multipart/form-data">
						@csrf
						@method("PATCH")

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
									<span class="d-none d-sm-block">Variants</span>
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
									<input type="text" name="product[name]" id="product_name" value="{{ $model?->name ?? old("product.name") }}" minlength="3" maxlength="50" class="form-control @error("product.name") parsley-error @enderror" required>
									@error("product.name")
									<span class="text-red">{{ $message }}</span>
									@enderror
								</div>

								<div class="mb-3">
									<label for="product_description" class="form-label">Product Description</label>
									<textarea name="product[description]" minlength="3" class="form-control editor @error("product.description") parsley-error @enderror" required>{{ $model?->description ?? old("product.description") }}</textarea>
									@error("product.description")
									<span class="text-red">{{ $message }}</span>
									@enderror
								</div>

								<div class="mb-3">
									<label for="product_meta_title" class="form-label">Meta Tag Title</label>
									<input type="text" name="product[meta][meta_title]" id="product_meta_title" value="{{ $model?->meta->getMetaTitle() ?? old("product.meta.meta_title") }}" minlength="3" maxlength="50" class="form-control @error("product.meta.meta_title") parsley-error @enderror">
									@error("product.meta.meta_title")
									<span class="text-red">{{ $message }}</span>
									@enderror
								</div>

								<div class="mb-3">
									<label for="product_meta_description" class="form-label">Meta Tag Description</label>
									<input type="text" name="product[meta][meta_description]" id="product_meta_description" value="{{ $model?->meta->getMetaDescription() ?? old("product.meta.meta_description") }}" minlength="3" maxlength="50" class="form-control @error("product.meta.meta_description") parsley-error @enderror">
									@error("product.meta.meta_description")
									<span class="text-red">{{ $message }}</span>
									@enderror
								</div>

								<div class="mb-3">
									<label for="product_meta_keywords" class="form-label">Meta Tag Keywords</label>
									<input type="text" name="product[meta][meta_keywords]" id="product_meta_keywords" value="{{ $model?->meta->getMetaKeywords() ?? old("product.meta.meta_keywords") }}" minlength="3" maxlength="50" class="form-control @error("product.meta.meta_keywords") parsley-error @enderror">
									@error("product.meta.meta_keywords")
									<span class="text-red">{{ $message }}</span>
									@enderror
								</div>

								<div class="mb-3">
									<label for="product_tags" class="form-label">Product Tags</label>
									<select name="tags[]" id="product_tags" style="width: 100%" class="form-control select2 @error("tags") parsley-error @enderror" multiple>
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
									<input type="text" name="product[sku]" id="product_sku" value="{{ $model?->sku ?? old("product.sku") }}" minlength="3" maxlength="50" class="form-control @error("product.sku") parsley-error @enderror" required>
									@error("product.sku")
									<span class="text-red">{{ $message }}</span>
									@enderror
								</div>

								<div class="mb-3">
									<label for="product_upc" class="form-label">UPC</label>
									<input type="text" name="product[upc]" id="product_upc" value="{{ $model?->upc ?? old("product.upc") }}" minlength="3" maxlength="50" class="form-control @error("product.upc") parsley-error @enderror" required>
									@error("product.upc")
									<span class="text-red">{{ $message }}</span>
									@enderror
								</div>

								<div class="mb-3">
									<label for="product_price" class="form-label">Price</label>
									<input type="number" name="product[price]" id="product_price" value="{{ $model?->price ?? old("product.price") }}" min="0" step="0.01" class="form-control @error("product.price") parsley-error @enderror" required>
									@error("product.price")
									<span class="text-red">{{ $message }}</span>
									@enderror
								</div>

								<div class="mb-3">
									<label for="product_discount_price" class="form-label">Discount Price</label>
									<input type="number" name="product[discount_price]" id="product_discount_price" value="{{ $model?->discount_price ?? old("product.discount_price") }}" min="0" step="0.01" class="form-control @error("product.discount_price") parsley-error @enderror">
									@error("product.discount_price")
									<span class="text-red">{{ $message }}</span>
									@enderror
								</div>

								<div class="mb-3">
									<label for="product_quantity" class="form-label">Quantity</label>
									<input type="number" name="product[quantity]" id="product_quantity" value="{{ $model?->quantity ?? old("product.quantity") }}" min="1" step="1" class="form-control @error("product.quantity") parsley-error @enderror" required>
									@error("product.quantity")
									<span class="text-red">{{ $message }}</span>
									@enderror
								</div>

								<div class="mb-3">
									<label for="product_length" class="form-label">Length</label>
									<input type="number" name="product[dimension][dimension_length]" id="product_length" value="{{ $model?->dimension->getDimensionLength() ?? old("product.dimension.dimension_length") ?? 0.00 }}" min="0" step="0.01" class="form-control @error("product.dimension.dimension_length") parsley-error @enderror" required>
									@error("product.dimension.dimension_length")
									<span class="text-red">{{ $message }}</span>
									@enderror
								</div>

								<div class="mb-3">
									<label for="product_width" class="form-label">Width</label>
									<input type="number" name="product[dimension][dimension_width]" id="product_width" value="{{ $model?->dimension->getDimensionWidth() ?? old("product.dimension.dimension_width") ?? 0.00 }}" min="0" step="0.01" class="form-control @error("product.dimension.dimension_width") parsley-error @enderror" required>
									@error("product.dimension.dimension_width")
									<span class="text-red">{{ $message }}</span>
									@enderror
								</div>

								<div class="mb-3">
									<label for="product_height" class="form-label">Height</label>
									<input type="number" name="product[dimension][dimension_height]" id="product_height" value="{{ $model?->dimension->getDimensionHeight() ?? old("product.dimension.dimension_height") ?? 0.00 }}" min="0" step="0.01" class="form-control @error("product.dimension.dimension_height") parsley-error @enderror" required>
									@error("product.dimension.dimension_height")
									<span class="text-red">{{ $message }}</span>
									@enderror
								</div>

								<div class="mb-3">
									<label for="product_dimension_class" class="form-label">Dimension Class</label>
									<select name="product[dimension_class]" id="product_dimension_class" class="form-control @error("product.dimension_class") parsley-error @enderror">
										@foreach(DimensionClass::cases() as $productDimensionClass)
											<option value="{{ $productDimensionClass->value }}" @if($model?->dimension_class->value === $productDimensionClass->value) selected @endif>{{ DimensionClass::formattedName($productDimensionClass) }}</option>
										@endforeach
									</select>
									@error("product.dimension_class")
									<span class="text-red">{{ $message }}</span>
									@enderror
								</div>

								<div class="mb-3">
									<label for="product_weight" class="form-label">Weight</label>
									<input type="number" name="product[weight]" id="product_weight" value="{{ $model?->weight ?? old("product.weight") ?? 0.00 }}" min="0" step="0.01" class="form-control @error("product.weight") parsley-error @enderror" required>
									@error("product.weight")
									<span class="text-red">{{ $message }}</span>
									@enderror
								</div>

								<div class="mb-3">
									<label for="product_weight_class" class="form-label">Weight Class</label>
									<select name="product[weight_class]" id="product_weight_class" class="form-control @error("product.weight_class") parsley-error @enderror">
										@foreach(WeightClass::cases() as $productWeightClass)
											<option value="{{ $productWeightClass->value }}" @if($model?->weight_class->value === $productWeightClass->value) selected @endif>{{ WeightClass::formattedName($productWeightClass) }}</option>
										@endforeach
									</select>
									@error("product.weight_class")
									<span class="text-red">{{ $message }}</span>
									@enderror
								</div>

								<div class="mb-3">
									<label for="product_min_order_quantity" class="form-label">Minimum Order-able Quantity</label>
									<input type="number" name="product[min_order_quantity]" id="product_min_order_quantity" value="{{ $model?->min_order_quantity ?? old("product.min_order_quantity") ?? 1 }}" min="1" step="1" class="form-control @error("product.min_order_quantity") parsley-error @enderror">
									@error("product.min_order_quantity")
									<span class="text-red">{{ $message }}</span>
									@enderror
								</div>

								<div class="mb-3">
									<label for="product_subtract_stock" class="form-label">Subtract Stock</label>
									<select name="product[subtract_stock]" id="product_subtract_stock" class="form-control @error("product.subtract_stock") parsley-error @enderror">
										@foreach(ProductStockBehaviour::cases() as $productStockBehaviour)
											<option value="{{ $productStockBehaviour->value }}" @if($model?->subtract_stock->value === $productStockBehaviour->value) selected @endif>{{ ProductStockBehaviour::formattedName($productStockBehaviour) }}</option>
										@endforeach
									</select>
									@error("product.subtract_stock")
									<span class="text-red">{{ $message }}</span>
									@enderror
								</div>

								<div class="mb-3">
									<label for="product_require_shipping" class="form-label">Require Shipping</label>
									<select name="product[require_shipping]" id="product_require_shipping" class="form-control @error("product.require_shipping") parsley-error @enderror">
										@foreach(ProductShipping::cases() as $productShipping)
											<option value="{{ $productShipping->value }}" @if($model?->require_shipping->value === $productShipping->value) selected @endif>{{ ProductShipping::formattedName($productShipping) }}</option>
										@endforeach
									</select>
									@error("product.require_shipping")
									<span class="text-red">{{ $message }}</span>
									@enderror
								</div>

								<div class="mb-3">
									<label for="product_promotion_status" class="form-label">Promotion Status</label>
									<select name="product[promotion_status]" id="product_promotion_status" class="form-control @error("product.promotion_status") parsley-error @enderror">
										@foreach(ProductPromotion::cases() as $productPromotion)
											<option value="{{ $productPromotion->value }}" @if($model?->promotion_status->value === $productPromotion->value) selected @endif>{{ ProductPromotion::formattedName($productPromotion) }}</option>
										@endforeach
									</select>
									@error("product.promotion_status")
									<span class="text-red">{{ $message }}</span>
									@enderror
								</div>
							</div>

							<div class="tab-pane" id="links" role="tabpanel">
								<div class="mb-3">
									<label for="product_brand" class="form-label">Brand</label>
									<select name="product[brand_id]" id="product_brand" style="width: 100%" class="form-control select2 @error("product.brand_id") parsley-error @enderror" required>
										@php $brandIds = array_map(static function (array $brand) { return $brand["id"]; }, $brands->toArray()) @endphp
										@foreach($brands as $brand)
											<option value="{{ $brand->id }}" data-country-image="{{ asset($brand->country->getCountryFlag()) }}" @if ($model?->brand_id === $brand->id) selected @endif>{{ $brand->country->getCountryName() }} - {{ $brand->name }}</option>
										@endforeach
									</select>
									@error("product.brand_id")
									<span class="text-red">{{ $message }}</span>
									@enderror
								</div>

								<div class="mb-3">
									<label for="product_categories" class="form-label">Categories</label>
									<select name="categories[]" id="product_categories" style="width: 100%" class="form-control select2 @error("categories") parsley-error @enderror" multiple>
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
									<select name="related_products[]" id="product_related_products" style="width: 100%" class="form-control select2 @error("related_products") parsley-error @enderror" multiple>
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
								<div class="mb-3">
									<div class="row">
										<div class="col-10">
											<select id="product-option-to-add" class="form-control">
												@foreach($productOptions as $option)
													<option value="{{ $option->id }}">{{ $option->name }}</option>
												@endforeach
											</select>
										</div>
										<div class="col-2">
											<button type="button" class="btn btn-success waves-effect waves-light mr-1 w-100" onclick="productOptionsManagement.addProductOption()">Add Product Variant</button>
										</div>
									</div>
								</div>

								<div id="product-available-option">
									@php $productOptionValueIndexCounter = 0 @endphp
									@foreach($assignedProductOptionValues as $optionId => $productOptionValueGroup)
										<div id="product-available-option-{{ $optionId }}" class="card border border-light border-3">
											<div class="card-body">
												<div class="row mb-3">
													<div class="col-10">
														<label class="form-label">Variant Name</label>
														<input data-option-name="{{ $optionId }}" type="text" class="form-control" disabled>
													</div>
													<div class="col-2 d-flex align-items-end">
														<div class="w-100">
															<button title="Delete" type="button" class="w-100 btn btn-danger inner" onclick="productOptionsManagement.removeProductOption({{ $optionId }})">Remove Product Variant</button>
														</div>
													</div>
												</div>

												<div id="product-option-{{ $optionId }}-option-value">
													@foreach($productOptionValueGroup as $productOptionValue)
														<div id="product-option-value-{{ $productOptionValueIndexCounter }}" class="row mb-3">
															<div class="col-3">
																@php $possibleOptionValuesForThisOption = app(OptionValueService::class)->getOptionValuesForDropdown($productOptionValue->option->id) @endphp
																<label class="form-label">Variant Value Name</label>
																<select name="options[{{ $productOptionValueIndexCounter }}][option_value_id]" class="form-control">
																	@foreach($possibleOptionValuesForThisOption as $possibleOptionValue)
																		<option value="{{ $possibleOptionValue->id }}" @if($possibleOptionValue->id === $productOptionValue->id) selected @endif>{{ $possibleOptionValue->name }}</option>
																	@endforeach
																</select>
															</div>
															<div class="col-2">
																<label class="form-label">Variant Value Quantity</label>
																<input type="number" name="options[{{ $productOptionValueIndexCounter }}][quantity]" value="{{ $productOptionValue->pivot->quantity }}" min="1" step="1" class="form-control" required>
															</div>
															<div class="col-2">
																<label class="form-label">Variant Value Subtract Stock</label>
																<select name="options[{{ $productOptionValueIndexCounter }}][subtract_stock]" class="form-control">
																	@foreach(ProductStockBehaviour::cases() as $productStockBehaviour)
																		<option value="{{ $productStockBehaviour->value }}" @if ($productOptionValue->pivot->subtract_stock === $productStockBehaviour->value) selected @endif>{{ ProductStockBehaviour::formattedName($productStockBehaviour) }}</option>
																	@endforeach
																</select>
															</div>
															<div class="col-2">
																<label class="form-label">Variant Value Price Adjustment</label>
																<select name="options[{{ $productOptionValueIndexCounter }}][price_adjustment]" class="form-control">
																	@foreach(ProductOptionUnitAdjustment::cases() as $productOptionUnitAdjustment)
																		<option value="{{ $productOptionUnitAdjustment->value }}" @if ($productOptionValue->pivot->price_adjustment === $productOptionUnitAdjustment->value) selected @endif>{{ ProductOptionUnitAdjustment::formattedName($productOptionUnitAdjustment) }}</option>
																	@endforeach
																</select>
															</div>
															<div class="col-2">
																<label class="form-label">Variant Value Price</label>
																<input type="number" name="options[{{ $productOptionValueIndexCounter }}][price_difference]" value="{{ $productOptionValue->pivot->price_difference }}" min="1" step="0.01" class="form-control" required>
															</div>
															<div class="col-1 d-flex align-items-end">
																<div class="w-100">
																	<button title="Delete" type="button" class="w-100 btn btn-danger inner" onclick="productOptionsManagement.removeProductOptionValue({{ $productOptionValueIndexCounter }})">
																		<i class="fa fa-trash"></i>
																	</button>
																</div>
															</div>
														</div>
														@php $productOptionValueIndexCounter++ @endphp
													@endforeach
												</div>

												<div id="product-option-add-{{ $optionId }}">
													<button type="button" class="btn btn-primary waves-effect waves-light mr-1" onclick="productOptionsManagement.addProductOptionValue({{ $optionId }})">Add Product Variant Value</button>
												</div>
											</div>
										</div>
									@endforeach
								</div>
							</div>

							<div class="tab-pane" id="image" role="tabpanel">

								<div class="mb-3">
									<label for="product_image" class="form-label">Product Image</label>
									<div class="input-group-btn">
										<div class="image-upload">
											<img src="{{ asset($model?->image ?? "images/placeholder.png") }}" alt="product-main-image">
											<div class="file-btn">
												<input type="file" id="product_image" name="product[image]">
												<input type="hidden" name="product[old_image]" value="{{ $model?->image ?? old("product.old_image") }}">
												<label class="btn btn-info">Upload</label>
											</div>
										</div>
									</div>
								</div>

								<div class="mb-3">
									<label for="secondary_images" class="form-label">Product Multiple Images</label>
									<div class="input-group-btn">
										@if($model?->secondary_images !== null)
											@foreach ($model->secondary_images as $index => $secondaryImage)
												<div class="multi-image-upload">
													<i class="fa fa-times" aria-hidden="true"></i>
													<img src="{{ asset($secondaryImage ?? "images/placeholder.png") }}" alt="Secondary Image {{ $index + 1 }}">
													<div class="file-btn">
														<input type="hidden" id="old_secondary_images" name="product[old_secondary_images][]" value="{{ $secondaryImage ?? old("product.old_secondary_images") }}">
													</div>
												</div>
											@endforeach
										@endif
										<div class="multi-image-upload">
											<img src="{{ asset("images/placeholder.png") }}" alt="placeholder-secondary-image">
											<div class="file-btn">
												<input type="file" id="secondary_images" name="product[secondary_images][]">
												<label class="btn btn-info">Upload</label>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>

						<div class="mb-3" id="submit-button-div">
							<button type="submit" class="btn btn-primary waves-effect waves-light mr-1">Save
							</button>
						</div>
					</form>
				</div>
			</div>
		</div> <!-- end col -->
	</div> <!-- end row -->
@endsection

@section("script")
	<script src="{{ asset("assets/libs/parsleyjs/parsleyjs.min.js") }}"></script>
	<!-- Plugins js -->
	<script src="{{ asset("assets/js/pages/form-validation.init.js") }}"></script>
	<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
	<!-- select2 -->
	<script src="{{ asset("assets/libs/select2/select2.min.js") }}"></script>
@endsection

@section("script-bottom")
	<script>
		class ProductOptionManagement {
			#productOptions = JSON.parse(`@json($productOptions, JSON_THROW_ON_ERROR)`);
			#productOptionsAlreadyPresentIds = JSON.parse(`@json($assignedProductOptionValues === [] ? [] : $assignedProductOptionValues->keys()->toArray(), JSON_THROW_ON_ERROR)`);
			#productOptionValueIndex = {{ $model?->optionValues->count() ?? 0 }};
			#productOptionValueAvailableIndex = [];

			constructor() {
				this.#fillOptionNamesInDisabledInputs();
			}

			#generateProductOptionDropdownHtml(optionToAdd) {
				return `
					<div id="product-available-option-${ optionToAdd.id }" class="card border border-light border-3">
						<div class="card-body">
							<div class="row mb-3">
								<div class="col-10">
									<label class="form-label">Variant Name</label>
									<input data-option-name="${ optionToAdd.id }" value="${ optionToAdd.name }" type="text" class="form-control" disabled>
								</div>
								<div class="col-2 d-flex align-items-end">
									<div class="w-100">
										<button title="Delete" type="button" class="w-100 btn btn-danger inner" onclick="productOptionsManagement.removeProductOption(${ optionToAdd.id })">Remove Product Variant</button>
									</div>
								</div>
							</div>

							<div id="product-option-${ optionToAdd.id }-option-value"></div>

							<div id="product-option-add-${ optionToAdd.id }">
								<button type="button" class="btn btn-primary waves-effect waves-light mr-1" onclick="productOptionsManagement.addProductOptionValue(${ optionToAdd.id })">Add Product Variant Value</button>
							</div>
						</div>
					</div>
				`;
			}

			#generateProductOptionValueRowHtml(optionId, productOptionValueIndexCounter, optionValues) {
				const productOptionStockBehaviour = JSON.parse(`{!! ProductStockBehaviour::formattedJsonArray() !!}`);
				const productOptionUnitAdjustment = JSON.parse(`{!! ProductOptionUnitAdjustment::formattedJsonArray() !!}`);

				const dropdownOptionsHtml = optionValues.reduce((generatedDropdownOptionsHtml, optionValue) => {
					return `${ generatedDropdownOptionsHtml }<option value="${ optionValue.id }">${ optionValue.name }</option>`;
				}, "");

				const stockBehaviourHtml = productOptionStockBehaviour.reduce((generatedStockBehaviourHtml, stockBehaviour) => {
					return `${ generatedStockBehaviourHtml }<option value="${ stockBehaviour.value }">${ stockBehaviour.name }</option>`;
				}, "");

				const unitAdjustmentHtml = productOptionUnitAdjustment.reduce((generatedUnitAdjustmentHtml, unitAdjustment) => {
					return `${ generatedUnitAdjustmentHtml }<option value="${ unitAdjustment.value }">${ unitAdjustment.name }</option>`;
				}, "");

				return `
					<div id="product-option-value-${ productOptionValueIndexCounter }" class="row mb-3">
						<div class="col-3">
							<label class="form-label">Variant Value Name</label>
							<select name="options[${ productOptionValueIndexCounter }][option_value_id]" class="form-control">
								${ dropdownOptionsHtml }
							</select>
						</div>
						<div class="col-2">
							<label class="form-label">Variant Value Quantity</label>
							<input type="number" name="options[${ productOptionValueIndexCounter }][quantity]" min="1" step="1" class="form-control" required>
						</div>
						<div class="col-2">
							<label class="form-label">Variant Value Subtract Stock</label>
							<select name="options[${ productOptionValueIndexCounter }][subtract_stock]" class="form-control">
								${ stockBehaviourHtml }
							</select>
						</div>
						<div class="col-2">
							<label class="form-label">Variant Value Price Adjustment</label>
							<select name="options[${ productOptionValueIndexCounter }][price_adjustment]" class="form-control">
								${ unitAdjustmentHtml }
							</select>
						</div>
						<div class="col-2">
							<label class="form-label">Variant Value Price</label>
							<input type="number" name="options[${ productOptionValueIndexCounter }][price_difference]" min="1" step="0.01" class="form-control" required>
						</div>
						<div class="col-1 d-flex align-items-end">
							<div class="w-100">
								<button title="Delete" type="button" class="w-100 btn btn-danger inner" onclick="productOptionsManagement.removeProductOptionValue(${ productOptionValueIndexCounter })">
									<i class="fa fa-trash"></i>
								</button>
							</div>
						</div>
					</div>
				`;
			}

			#fillOptionNamesInDisabledInputs() {
				Array.from(document.querySelectorAll("[data-option-name]")).forEach((optionNameDisabledInput) => {
					const optionId = optionNameDisabledInput.getAttribute("data-option-name");
					const option = this.#productOptions.find((option) => option.id === +optionId);
					optionNameDisabledInput.value = option.name;
				});
			}

			addProductOption() {
				const productOptionToAdd = document.getElementById("product-option-to-add");
				const productOptionToAddId = +productOptionToAdd.value;
				const productOptionToAddIdIndex = this.#productOptionsAlreadyPresentIds.indexOf(productOptionToAddId);

				if (productOptionToAddIdIndex !== -1) return;

				const optionToAdd = this.#productOptions.find((option) => option.id === productOptionToAddId);
				document.getElementById("product-available-option").insertAdjacentHTML("beforeend", this.#generateProductOptionDropdownHtml(optionToAdd));
				this.#productOptionsAlreadyPresentIds.push(productOptionToAddId);
			}

			removeProductOption(optionIdToRemove) {
				const productOptionToAddIdIndex = this.#productOptionsAlreadyPresentIds.indexOf(optionIdToRemove);
				if (productOptionToAddIdIndex === -1) return;

				document.getElementById(`product-available-option-${ optionIdToRemove }`).remove();
				this.#productOptionsAlreadyPresentIds.splice(productOptionToAddIdIndex, 1);
			}

			async addProductOptionValue(optionId) {
				const possibleOptionValuesPlaceholderRoute = "{{ route("admin.option-values.index.dropdown", ["optionId" => ":optionId"]) }}";
				const optionValuesRoute = possibleOptionValuesPlaceholderRoute.replace(":optionId", optionId);
				const rawResponse = await fetch(optionValuesRoute);

				if (!rawResponse.ok) return;
				const response = await rawResponse.json();

				const availableIndex = this.#productOptionValueAvailableIndex.pop();
				const indexToUse = availableIndex ?? this.#productOptionValueIndex++;
				const generatedHtml = this.#generateProductOptionValueRowHtml(optionId, indexToUse, response.optionValues);

				const generatedHtmlContainer = document.getElementById(`product-option-${ optionId }-option-value`);
				generatedHtmlContainer.insertAdjacentHTML("beforeend", generatedHtml);
			}

			removeProductOptionValue(indexCounter) {
				const productOptionValueRow = document.getElementById(`product-option-value-${ indexCounter }`);
				if (!productOptionValueRow) return;

				productOptionValueRow.remove();
				this.#productOptionValueAvailableIndex.push(indexCounter);
			}
		}

		const productOptionsManagement = new ProductOptionManagement();

		const formatBrandOptions = (state) => {
			if (!state.id) return state.text;
			const countryImageUrl = $(state.element).data("country-image");
			const countryImage = `<span><img src="${ countryImageUrl }" width="50" alt="country-flag"/>  ${ state.text }</span>`;

			return $(countryImage);
		};

		$(function() {
			$("#product_tags, #product_categories, #product_related_products").select2({
				closeOnSelect: false,
			});

			$("#product_brand").select2({
				templateResult: formatBrandOptions,
			});

			// Text Editor
			$(".editor").summernote({
				placeholder: "Product Description",
				height: 300,
			});
		});
	</script>
@endsection
