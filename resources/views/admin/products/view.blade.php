@php use App\Models\Product; @endphp
@extends("layouts.master")
@section("title")
	View {{ $title }}
@endsection
@section("content")
	@php assert($model instanceof Product) @endphp

	@component("components.breadcrumb")
		@slot("li_1")
			{{ $title }}
		@endslot
		@slot("title")
			View {{ $title }}
		@endslot
	@endcomponent

	<!-- end row -->
	<div class="row">
		<div class="col-xl-8">
			<div class="card">
				<div class="card-body">
					<div class="table-responsive">
						<table class="table table-hover table-striped">
							<tbody>
								<tr>
									<th>Name</th>
									<td style="text-align: center">{{ $model->name ?? "" }}</td>
								</tr>
								<tr>
									<th>Description</th>
									<td style="text-align: center">{!! $model->description ?? "" !!}</td>
								</tr>
								<tr>
									<th>Meta Title</th>
									<td style="text-align: center">{{ $model->meta->getMetaTitle() ?? "" }}</td>
								</tr>
								<tr>
									<th>Meta Description</th>
									<td style="text-align: center">{{ $model->meta->getMetaDescription() ?? "" }}</td>
								</tr>
								<tr>
									<th>Meta Keywords</th>
									<td style="text-align: center">{{ $model->meta->getMetaKeywords() ?? "" }}</td>
								</tr>
								<tr>
									<th>SKU</th>
									<td style="text-align: center">{{ $model->sku ?? "" }}</td>
								</tr>
								<tr>
									<th>UPC</th>
									<td style="text-align: center">{{ $model->upc ?? "" }}</td>
								</tr>
								<tr>
									<th>Price</th>
									<td style="text-align: center">{{ $model->price ?? "" }}</td>
								</tr>
								<tr>
									<th>Discount Price</th>
									<td style="text-align: center">{{ $model->discount_price ?? "" }}</td>
								</tr>
								<tr>
									<th>Quantity</th>
									<td style="text-align: center">{{ $model->quantity ?? "" }}</td>
								</tr>
								<tr>
									<th>Dimension</th>
									<td style="text-align: center">{{ $model->dimension->formattedDimension() ?? "" }}</td>
								</tr>
								<tr>
									<th>Dimension Class</th>
									<td style="text-align: center">{{ $model->dimension_class::formattedName($model->dimension_class) ?? "" }}</td>
								</tr>
								<tr>
									<th>Weight</th>
									<td style="text-align: center">{{ $model->weight ?? "" }}</td>
								</tr>
								<tr>
									<th>Weight Class</th>
									<td style="text-align: center">{{ $model->weight_class::formattedName($model->weight_class) ?? "" }}</td>
								</tr>
								<tr>
									<th>Image</th>
									<td style="text-align: center">
										<img src="{{ asset($model->image ?? "images/placeholder.png") }}" width="80" alt="Product Main Image">
									</td>
								</tr>
								<tr>
									<th>Secondary Images</th>
									<td style="text-align: center">
										@if(!empty($model->secondary_images))
											@foreach ($model->secondary_images as $index => $secondary_image)
												<img src="{{ asset($secondary_image ?? "images/placeholder.png") }}" width="80" alt="Secondary Image {{ $index }}">
											@endforeach
										@endif
									</td>
								</tr>
								<tr>
									<th>Minimum Order-able Quantity</th>
									<td style="text-align: center">{{ $model->min_order_quantity ?? "" }}</td>
								</tr>
								<tr>
									<th>Subtract From Stock</th>
									<td style="text-align: center">{{ $model->subtract_stock::formattedName($model->subtract_stock) ?? "" }}</td>
								</tr>
								<tr>
									<th>Shipping Required</th>
									<td style="text-align: center">{{ $model->require_shipping::formattedName($model->require_shipping) ?? "" }}</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div> <!-- end col -->
	</div> <!-- end row -->

@endsection
