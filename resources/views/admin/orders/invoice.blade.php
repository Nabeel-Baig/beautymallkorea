@php
	use App\Enums\PaymentMethod;
	use App\Enums\ShippingMethod;
	use App\Models\Order;
	assert($order instanceof Order);
@endphp
	<!DOCTYPE html>
<html dir="ltr" lang="en">
	<head>
		<meta charset="UTF-8" />
		<title> Invoice | {{ $setting->title }}</title>
		<link rel="shortcut icon" href="{{ asset($setting->favico) }}">
		<base href="{{ url("admin") }}" />
		<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" media="all" rel="stylesheet" />
		<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js" type="text/javascript"></script>
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" integrity="sha512-SfTiTlX6kk+qitfevl/7LibUOeJWlt9rbyDn92a1DqWOw9vWG2MFoays0sgObmWazO5BQPiFucnnEAjpAB+/Sw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
		<link type="text/css" href="{{ asset("assets/invoice/invoice.css") }}" rel="stylesheet" media="all" />
	</head>
	<body>
		<div class="container">
			<div style="page-break-after: always;">
				<h1>Invoice #{{ $order->id ?? "" }}</h1>
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
									{!! $setting->address ?? "" !!}
								</address>
								<b>Telephone</b> {{ $setting->phone ?? "" }}
								<br />
								<b>E-Mail</b>
								<a href="mailto:{{ $setting->email ?? "" }}"
								   class="__cf_email__">{{ $setting->email ?? "" }}</a>
								<br />
								<b>Web Site:</b>
								<a href="{{ $setting->link ?? "" }}">{{ $setting->link ?? "" }}</a>
							</td>
							<td style="width: 50%;">
								<b>Date Added</b> {{ $order->created_at->format("d-m-Y") }}
								<br />
								<b>Order ID:</b> {{ $order->id ?? "" }}
								<br />
								<b>Payment Method</b>
								{{ PaymentMethod::formattedName($order->payment_method) }}
								<br />
								<b>Shipping Method</b>
								{{ ShippingMethod::formattedName($order->shipping_method) }}
								<br />
							</td>
						</tr>
					</tbody>
				</table>
				<table class="table table-bordered">
					<thead>
						<tr>
							<td style="width: 50%;">
								<b>Payment Address</b>
							</td>
							<td style="width: 50%;">
								<b>Shipping Address</b>
							</td>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>
								<address>
									{{ $order->customer_full_name }}
									<br />
									{{ $order->billing_address->getAddressLineOne() }}
									<br />
									{{ $order->billing_address->getAddressLineTwo() }}
									<br />
									{{ $order->billing_address->getAddressCity() }}
									<br />
									{{ $order->billing_address->getAddressState() }}
									<br />
									{{ $order->billing_address->getAddressCountry() }}
								</address>
							</td>
							<td>
								<address>
									{{ $order->customer_shipping_full_name }}
									<br />
									{{ $order->shipping_address->getAddressLineOne() }}
									<br />
									{{ $order->shipping_address->getAddressLineTwo() }}
									<br />
									{{ $order->shipping_address->getAddressCity() }}
									<br />
									{{ $order->shipping_address->getAddressState() }}
									<br />
									{{ $order->shipping_address->getAddressCountry() }}
								</address>
							</td>
						</tr>
					</tbody>
				</table>
				<table class="table table-bordered">
					<thead>
						<tr>
							<td>
								<b>Product</b>
							</td>
							<td>
								<b>Variant</b>
							</td>
							<td class="text-right">
								<b>Quantity</b>
							</td>
							<td class="text-right">
								<b>Unit Price</b>
							</td>
							<td class="text-right">
								<b>Total</b>
							</td>
						</tr>
					</thead>
					<tbody>
						@foreach($order->orderItems as $orderItem)
							<tr>
								<td>{{ $orderItem->product_name }}</td>
								<td>
									@if($orderItem->product_option_name->isEmpty())
										-
									@else
										<b>Variant Name:</b> {{ $orderItem->product_option_name->getOptionName() }}
										<br />
										<b>Variant Value Name:</b> {{ $orderItem->product_option_name->getOptionValueName() }}
									@endif
								</td>
								<td class="text-right">{{ $orderItem->product_quantity }}</td>
								<td class="text-right">{{ priceWithCurrency($setting->currency, $orderItem->product_price) }}</td>
								<td class="text-right">{{ priceWithCurrency($setting->currency, $orderItem->product_total_price) }}</td>
							</tr>
						@endforeach
						<tr>
							<td class="text-right" colspan="4">
								<b>Sub-Total</b>
							</td>
							<td class="text-right">{{ priceWithCurrency($setting->currency, $order->actual_amount) }}</td>
						</tr>
						<tr>
							<td class="text-right" colspan="4">
								<b>{{ ShippingMethod::formattedName($order->shipping_method) }}</b>
							</td>
							<td class="text-right">{{ priceWithCurrency($setting->currency, $order->shipping_amount) }}</td>
						</tr>
						<tr>
							<td class="text-right" colspan="4">
								<b>Total</b>
							</td>
							<td class="text-right">{{ priceWithCurrency($setting->currency, $order->total_amount) }}</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
		<script data-cfasync="false" src="{{ asset("assets/invoice/invoice.js") }}"></script>
	</body>
</html>
