@extends('layouts.master')
@section('title')
	View {{ $title }}
@endsection
@section('content')
	@component('components.breadcrumb')
		@slot('li_1')
			{{ $title }}
		@endslot
		@slot('title')
			View {{ $title }}
		@endslot
	@endcomponent

	<!-- end row -->
	<div class="row">
		<div class="col-xl-8">
			<div class="card">
				<div class="card-body">
					@foreach($assignedProductOptionValues as $optionId => $productOptionValueGroup)
						@php
							$productOptionValueGroup
						@endphp
						<h2></h2>
					@endforeach
					<div class="table-responsive">
						<table class="table table-hover table-striped">
							<tbody>
								<tr>
									<th>{{ucwords(str_replace('_',' ','name'))}}</th>
									<td align="center">{{ $model->name ?? '' }}</td>
								</tr>
								<tr>
									<th>{{ucwords(str_replace('_',' ','description'))}}</th>
									<td align="center">{!! $model->description ?? '' !!}</td>
								</tr>
								<tr>
									<th>{{ucwords(str_replace('_',' ','meta_title'))}}</th>
									<td align="center">{{ $model->meta_title ?? '' }}</td>
								</tr>
								<tr>
									<th>{{ucwords(str_replace('_',' ','meta_description'))}}</th>
									<td align="center">{{ $model->meta_description ?? '' }}</td>
								</tr>
								<tr>
									<th>{{ucwords(str_replace('_',' ','meta_keywords'))}}</th>
									<td align="center">{{ $model->meta_keywords ?? '' }}</td>
								</tr>
								<tr>
									<th>{{ucwords(str_replace('_',' ','sku'))}}</th>
									<td align="center">{{ $model->sku ?? '' }}</td>
								</tr>
								<tr>
									<th>{{ucwords(str_replace('_',' ','upc'))}}</th>
									<td align="center">{{ $model->upc ?? '' }}</td>
								</tr>
								<tr>
									<th>{{ucwords(str_replace('_',' ','price'))}}</th>
									<td align="center">{{ $model->price ?? '' }}</td>
								</tr>
								<tr>
									<th>{{ucwords(str_replace('_',' ','quantity'))}}</th>
									<td align="center">{{ $model->quantity ?? '' }}</td>
								</tr>
								<tr>
									<th>{{ucwords(str_replace('_',' ','image'))}}</th>
									<td align="center">
										<img src="{{ asset($model->image ?? 'images/placeholder.png') }}"
											 width="80">
									</td>
								</tr>
								<tr>
									<th>{{ucwords(str_replace('_',' ','multiple_image'))}}</th>
									<td align="center">
										@if(!empty($model->secondary_images))
											@foreach ($model->secondary_images as $index => $secondary_image)
												<img src="{{ asset($secondary_image ?? 'images/placeholder.png') }}" width="80" alt="Secondary Image {{ $index }}">
											@endforeach
										@endif
									</td>
								</tr>
								<tr>
									<th>{{ucwords(str_replace('_',' ','min_order_quantity'))}}</th>
									<td align="center">{{ $model->min_order_quantity ?? '' }}</td>
								</tr>
								<tr>
									<th>{{ucwords(str_replace('_',' ','subtract_stock'))}}</th>
									<td align="center">{{ $model->subtract_stock ?? '' }}</td>
								</tr>
								<tr>
									<th>{{ucwords(str_replace('_',' ','require_shipping'))}}</th>
									<td align="center">{{ $model->require_shipping ?? '' }}</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div> <!-- end col -->
	</div> <!-- end row -->

@endsection
