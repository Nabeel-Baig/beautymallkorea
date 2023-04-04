@php
	use App\Enums\PaymentMethod;use App\Enums\ShippingMethod;
@endphp
	<!DOCTYPE html>
<html dir="ltr" lang="en">
<head>
	<meta charset="UTF-8"/>
	<title> Invoice | {{ $setting->title }}</title>
	<link rel="shortcut icon" href="{{ asset($setting->favico) }}">
	<base href="{{ url('admin') }}"/>
	<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" media="all" rel="stylesheet"/>
	<script src="https://code.jquery.com/jquery-3.5.1.min.js"
			integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js" type="text/javascript"></script>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"
		  integrity="sha512-SfTiTlX6kk+qitfevl/7LibUOeJWlt9rbyDn92a1DqWOw9vWG2MFoays0sgObmWazO5BQPiFucnnEAjpAB+/Sw=="
		  crossorigin="anonymous" referrerpolicy="no-referrer"/>
	<link type="text/css" href="{{ asset('assets/invoice/invoice.css') }}" rel="stylesheet" media="all"/>
</head>
<body>
<div class="container">
	<div style="page-break-after: always;">
		<h1>Invoice #{{ $order->id ?? '' }}</h1>
		<table class="table table-bordered">
			<thead>
			<tr>
				<td colspan="2">Order Details</td>
			</tr>
			</thead>
			<tbody>
			<tr>
				<td style="width: 50%;">
					<address>
						{!! $setting->address ?? '' !!}
					</address>
					<b>Telephone</b> {{ $setting->phone ?? '' }}<br/>
					<b>E-Mail</b> <a href="mailto:{{ $setting->email ?? '' }}"
									 class="__cf_email__">{{ $setting->email ?? '' }}</a><br/>
					<b>Web Site:</b> <a href="{{ $setting->link ?? '' }}">{{ $setting->link ?? '' }}</a></td>
				<td style="width: 50%;"><b>Date Added</b> {{ $order->created_at->format('d-m-Y') }}<br/>
					<b>Order ID:</b> {{ $order->id ?? '' }}<br/>
					<b>Payment Method</b>
					@foreach(PaymentMethod::cases() as $paymentMethod)
						@if($paymentMethod->value === $order->payment_method->value)
							{{ PaymentMethod::formattedName($paymentMethod) }}
						@endif
					@endforeach
					<br/>
					<b>Shipping Method</b>
					@foreach(ShippingMethod::cases() as $shippingMethod)
						@if($shippingMethod->value === $order->shipping_method->value)
							{{ ShippingMethod::formattedName($shippingMethod) }}
						@endif
					@endforeach
					<br/>
				</td>
			</tr>
			</tbody>
		</table>
		<table class="table table-bordered">
			<thead>
			<tr>
				<td style="width: 50%;"><b>Payment Address</b></td>
				<td style="width: 50%;"><b>Shipping Address</b></td>
			</tr>
			</thead>
			<tbody>
			<tr>
				<td>
					<address>
						@php
							$billingAddress = json_decode(json_encode($order->billing_address),true);
						@endphp
						{{ $order->first_name . ' ' . $order->last_name }}<br/>
						{{ $billingAddress['addressLineOne'] ?? '' }}<br/>
						{{ $billingAddress['addressLineTwo'] ?? '' }}<br/>
						{{ $billingAddress['addressCity'] ?? '' }}<br/>
						{{ $billingAddress['addressState'] ?? '' }}<br/>
						{{ $billingAddress['addressCountry'] ?? '' }}
					</address>
				</td>
				<td>
					<address>
						@php
							$shippingAddress = json_decode(json_encode($order->shipping_address),true);
						@endphp
						{{ $order->shipping_first_name . ' ' . $order->shipping_last_name }}<br/>
						{{ $shippingAddress['addressLineOne'] ?? '' }}<br/>
						{{ $shippingAddress['addressLineTwo'] ?? '' }}<br/>
						{{ $shippingAddress['addressCity'] ?? '' }}<br/>
						{{ $shippingAddress['addressState'] ?? '' }}<br/>
						{{ $shippingAddress['addressCountry'] ?? '' }}
					</address>
				</td>
			</tr>
			</tbody>
		</table>
		<table class="table table-bordered">
			<thead>
			<tr>
				<td><b>Product</b></td>
				<td><b>Variant</b></td>
				<td class="text-right"><b>Quantity</b></td>
				<td class="text-right"><b>Unit Price</b></td>
				<td class="text-right"><b>Total</b></td>
			</tr>
			</thead>
			<tbody>
			@foreach($order->orderItems as $orderItem)
				@php
					$productOptionName = json_decode(json_encode($orderItem->product_option_name));
				@endphp
				<tr>
					<td>{{ $orderItem->product_name }}</td>
					<td><b>Variant Name:</b> {{ $productOptionName->optionName }}<br/>
						<b>Variant Value Name:</b> {{ $productOptionName->optionValueName }}
					</td>
					<td class="text-right">{{ $orderItem->product_quantity }}</td>
					<td class="text-right">{{ $setting->currency . ' ' . number_format($orderItem->product_price,2) }}</td>
					<td class="text-right">{{ $setting->currency . ' ' . number_format($orderItem->product_total_price,2) }}</td>
				</tr>
			@endforeach
			<tr>
				<td class="text-right" colspan="4"><b>Sub-Total</b></td>
				<td class="text-right">{{ $setting->currency . ' ' . number_format($order->actual_amount,2) }}</td>
			</tr>
			<tr>
				<td class="text-right" colspan="4"><b>
						@foreach(ShippingMethod::cases() as $shippingMethod)
							@if($shippingMethod->value === $order->shipping_method->value)
								{{ ShippingMethod::formattedName($shippingMethod) }}
							@endif
						@endforeach
					</b></td>
				<td class="text-right">{{ $setting->currency . ' ' . number_format($order->shipping_amount,2) }}</td>
			</tr>
			<tr>
				<td class="text-right" colspan="4"><b>Total</b></td>
				<td class="text-right">{{ $setting->currency . ' ' . number_format($order->total_amount,2) }}</td>
			</tr>
			</tbody>
		</table>
	</div>
</div>
<script data-cfasync="false" src="{{ asset('assets/invoice/invoice.js') }}"></script>
</body>
</html>
