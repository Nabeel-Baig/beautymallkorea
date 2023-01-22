@php
	use App\Enums\ProductOptionPriceAdjustment;use App\Enums\RequireShipping;use App\Enums\SubtractStock;use App\Services\OptionValueService;
@endphp
	<!--suppress HtmlFormInputWithoutLabel, SpellCheckingInspection -->

@extends('layouts.master')

@section('title')
	Edit {{ $title }}
@endsection

@section('page-specific-css')
	<!-- Plugins css -->
	<link rel="stylesheet" type="text/css" href="{{ asset('assets/libs/select2/select2.min.css') }}">
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
					<form method="POST" id="product-manage" action="{{ route("admin.products.manage.update", ["product" => $model->id ?? null]) }}" class="custom-validation" enctype="multipart/form-data">
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
									<input type="number" name="product[min_order_quantity]" id="product_min_order_quantity" value="{{ $model->min_order_quantity ?? old("product.min_order_quantity") ?? 1 }}" min="1" step="1" class="form-control @error('product.min_order_quantity') parsley-error @enderror">
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
											<button type="button" class="btn btn-success waves-effect waves-light mr-1 w-100" onclick="productOptionsManagement.addProductOption()">Add Product Option</button>
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
														<label class="form-label">Option Name</label>
														<input data-option-name="{{ $optionId }}" type="text" class="form-control" disabled>
													</div>
													<div class="col-2 d-flex align-items-end">
														<div class="w-100">
															<button title="Delete" type="button" class="w-100 btn btn-danger inner" onclick="productOptionsManagement.removeProductOption({{ $optionId }})">Remove Product Option</button>
														</div>
													</div>
												</div>

												<div id="product-option-{{ $optionId }}-option-value">
													@foreach($productOptionValueGroup as $productOptionValue)
														<div id="product-option-value-{{ $productOptionValueIndexCounter }}" class="row mb-3">
															<div class="col-3">
																@php $possibleOptionValuesForThisOption = app(OptionValueService::class)->getOptionValuesForDropdown($productOptionValue->option->id) @endphp
																<label class="form-label">Option Value Name</label>
																<select name="options[{{ $productOptionValueIndexCounter }}][option_value_id]" class="form-control">
																	@foreach($possibleOptionValuesForThisOption as $possibleOptionValue)
																		<option value="{{ $possibleOptionValue->id }}" @if($possibleOptionValue->id === $productOptionValue->id) selected @endif>{{ $possibleOptionValue->name }}</option>
																	@endforeach
																</select>
															</div>
															<div class="col-2">
																<label class="form-label">Option Value Quantity</label>
																<input type="number" name="options[{{ $productOptionValueIndexCounter }}][quantity]" value="{{ $productOptionValue->pivot->quantity }}" min="1" step="0.01" class="form-control" required>
															</div>
															<div class="col-2">
																<label class="form-label">Option Value Subtract Stock</label>
																<select name="options[{{ $productOptionValueIndexCounter }}][subtract_stock]" class="form-control">
																	<option value="{{ SubtractStock::NO->value }}" @if ($productOptionValue->pivot->subtract_stock === SubtractStock::NO->value) selected @endif>{{ SubtractStock::NO->name }}</option>
																	<option value="{{ SubtractStock::YES->value }}" @if ($productOptionValue->pivot->subtract_stock === SubtractStock::YES->value) selected @endif>{{ SubtractStock::YES->name }}</option>
																</select>
															</div>
															<div class="col-2">
																<label class="form-label">Option Value Price Adjustment</label>
																<select name="options[{{ $productOptionValueIndexCounter }}][price_adjustment]" class="form-control">
																	<option value="{{ ProductOptionPriceAdjustment::POSITIVE->value }}" @if ($productOptionValue->pivot->price_adjustment === ProductOptionPriceAdjustment::POSITIVE->value) selected @endif>{{ ProductOptionPriceAdjustment::POSITIVE->name }}</option>
																	<option value="{{ ProductOptionPriceAdjustment::NEGATIVE->value }}" @if ($productOptionValue->pivot->price_adjustment === ProductOptionPriceAdjustment::NEGATIVE->value) selected @endif>{{ ProductOptionPriceAdjustment::NEGATIVE->name }}</option>
																</select>
															</div>
															<div class="col-2">
																<label class="form-label">Option Value Price</label>
																<input type="number" name="options[{{ $productOptionValueIndexCounter }}][price_difference]" value="{{ $productOptionValue->pivot->price_difference }}" min="1" step="1" class="form-control" required>
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
													<button type="button" class="btn btn-primary waves-effect waves-light mr-1" onclick="productOptionsManagement.addProductOptionValue({{ $optionId }})">Add Product Option Value</button>
												</div>
											</div>
										</div>
									@endforeach
								</div>
							</div>

							<div class="tab-pane" id="image" role="tabpanel">
								<div class="mb-3" id="product_image">
									<label for="product_image" class="form-label">Image</label>
									<input type="file" name="product[image]" class="form-control" data-height="200">
									<input type="hidden" name="product[old_image]" value="{{ $model?->image ?? old("product.old_image") }}">
									<img src="{{ $model?->image ?? asset('images/placeholder.png') }}" class="w-25 mt-1" alt="product-image">
								</div>

								<div class="mb-3" id="product_multi_image">
									<label for="product_multi_image" class="form-label">Multiple Image</label>
									<input type="file" name="product[multi_image][]" class="form-control" data-height="200"/>
									<div class="row my-3">
										@foreach($model?->multi_images ?? [] as $eachMultiImage)

										@endforeach
									</div>
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
		class ProductOptionManagement {
			#productOptions = JSON.parse('@json($productOptions, JSON_THROW_ON_ERROR)');
			#productOptionsAlreadyPresentIds = JSON.parse('@json($assignedProductOptionValues === [] ? [] : $assignedProductOptionValues->keys()->toArray(), JSON_THROW_ON_ERROR)');
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
									<label class="form-label">Option Name</label>
									<input data-option-name="${ optionToAdd.id }" value="${ optionToAdd.name }" type="text" class="form-control" disabled>
								</div>
								<div class="col-2 d-flex align-items-end">
									<div class="w-100">
										<button title="Delete" type="button" class="w-100 btn btn-danger inner" onclick="productOptionsManagement.removeProductOption(${ optionToAdd.id })">Remove Product Option</button>
									</div>
								</div>
							</div>

							<div id="product-option-${ optionToAdd.id }-option-value"></div>

							<div id="product-option-add-${ optionToAdd.id }">
								<button type="button" class="btn btn-primary waves-effect waves-light mr-1" onclick="productOptionsManagement.addProductOptionValue(${ optionToAdd.id })">Add Product Option Value</button>
							</div>
						</div>
					</div>
				`;
			}

			#generateProductOptionValueRowHtml(optionId, productOptionValueIndexCounter, optionValues) {
				const {
					name: noSubtractStockName,
					value: noSubtractStockValue
				} = {
					name: "{{ SubtractStock::NO->name }}",
					value: "{{ SubtractStock::NO->value }}"
				};
				const {
					name: yesSubtractStockName,
					value: yesSubtractStockValue
				} = {
					name: "{{ SubtractStock::YES->name }}",
					value: "{{ SubtractStock::YES->value }}"
				};

				const {
					name: positiveProductOptionPriceAdjustmentName,
					value: positiveProductOptionPriceAdjustmentValue
				} = {
					name: "{{ ProductOptionPriceAdjustment::POSITIVE->name }}",
					value: "{{ ProductOptionPriceAdjustment::POSITIVE->value }}"
				};
				const {
					name: negativeProductOptionPriceAdjustmentName,
					value: negativeProductOptionPriceAdjustmentValue
				} = {
					name: "{{ ProductOptionPriceAdjustment::NEGATIVE->name }}",
					value: "{{ ProductOptionPriceAdjustment::NEGATIVE->value }}"
				};

				const dropdownOptionsHtml = optionValues.reduce((generatedDropdownOptionsHtml, optionValue) => {
					generatedDropdownOptionsHtml = `${ generatedDropdownOptionsHtml }<option value="${ optionValue.id }">${ optionValue.name }</option>`;

					return generatedDropdownOptionsHtml;
				}, "");

				return `
					<div id="product-option-value-${ productOptionValueIndexCounter }" class="row mb-3">
						<div class="col-3">
							<label class="form-label">Option Value Name</label>
							<select name="options[${ productOptionValueIndexCounter }][option_value_id]" class="form-control">
								${ dropdownOptionsHtml }
							</select>
						</div>
						<div class="col-2">
							<label class="form-label">Option Value Quantity</label>
							<input type="number" name="options[${ productOptionValueIndexCounter }][quantity]" min="1" step="0.01" class="form-control" required>
						</div>
						<div class="col-2">
							<label class="form-label">Option Value Subtract Stock</label>
							<select name="options[${ productOptionValueIndexCounter }][subtract_stock]" class="form-control">
								<option value="${ noSubtractStockValue }">${ noSubtractStockName }</option>
								<option value="${ yesSubtractStockValue }">${ yesSubtractStockName }</option>
							</select>
						</div>
						<div class="col-2">
							<label class="form-label">Option Value Price Adjustment</label>
							<select name="options[${ productOptionValueIndexCounter }][price_adjustment]" class="form-control">
								<option value="${ positiveProductOptionPriceAdjustmentValue }">${ positiveProductOptionPriceAdjustmentName }</option>
								<option value="${ negativeProductOptionPriceAdjustmentValue }">${ negativeProductOptionPriceAdjustmentName }</option>
							</select>
						</div>
						<div class="col-2">
							<label class="form-label">Option Value Price</label>
							<input type="number" name="options[${ productOptionValueIndexCounter }][price_difference]" min="1" step="1" class="form-control" required>
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

		$(function () {
			$(".select2").select2();
		});
	</script>
@endsection
