@php use App\Enums\PermissionEnum; @endphp

@extends('layouts.master')

@section('title')
	@lang('translation.Data_Tables')
@endsection

@section('page-specific-css')
	<link href="{{ asset('assets/libs/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css"/>
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

	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-body">
					<div class="float-right">
						@can(PermissionEnum::ORDER_DELETE->value)
							<button type="button" class="btn btn-danger" id="delete_all">Delete Selected</button>
						@endcan

						@can(PermissionEnum::ORDER_CREATE->value)
							<a class="btn btn-info" href="{{ route('admin.orders.create') }}">Add</a>
						@endcan
					</div>
					<table id="example1" class="table table-striped table-bordered dt-responsive nowrap">
						<thead>
							<tr>
								<th width="10">
									<label for="select_all">All</label>
									<input type="checkbox" id="select_all">
								</th>

								@foreach($headers as $header)
									<th>{{ $header }}</th>
								@endforeach

								<th>Action</th>
							</tr>
						</thead>
						<tbody></tbody>
					</table>
				</div>
			</div>
		</div> <!-- end col -->
	</div> <!-- end row -->

	@can(PermissionEnum::ORDER_SHOW->value)
		<!-- sample modal content -->
		<div id="viewModal" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel"
			 aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title mt-0" id="myModalLabel">View {{ $title ?? '' }}</h5>
						<button type="button" class="btn-close" data-bs-dismiss="modal"
								aria-label="Close"></button>
					</div>
					<div class="modal-body">
						<div class="table-responsive">
							<table class="table table-hover table-striped">
								<tbody>
								<tr>
									<th>{{ucwords(str_replace('_',' ','name'))}}</th>
									<td id="name" align="center"></td>
								</tr>
								<tr>
									<th>{{ucwords(str_replace('_',' ','code'))}}</th>
									<td id="code" align="center"></td>
								</tr>
								<tr>
									<th>{{ucwords(str_replace('_',' ','type'))}}</th>
									<td id="type" align="center"></td>
								</tr>
								<tr>
									<th>{{ucwords(str_replace('_',' ','discount'))}}</th>
									<td id="discount" align="center"></td>
								</tr>
								<tr>
									<th>{{ucwords(str_replace('_',' ','date_start'))}}</th>
									<td id="date_start" align="center"></td>
								</tr>
								<tr>
									<th>{{ucwords(str_replace('_',' ','date_end'))}}</th>
									<td id="date_end" align="center"></td>
								</tr>
								<tr>
									<th>{{ucwords(str_replace('_',' ','categories'))}}</th>
									<td id="categories" align="center"></td>
								</tr>
								<tr>
									<th>{{ucwords(str_replace('_',' ','products'))}}</th>
									<td id="products" align="center"></td>
								</tr>
								</tbody>
							</table>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Close</button>
					</div>
				</div><!-- /.modal-content -->
			</div><!-- /.modal-dialog -->
		</div><!-- /.modal -->
	@endcan

	@can(PermissionEnum::ORDER_DELETE->value)
		<!-- Delete content -->
		<div id="confirmModal" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title mt-0">Confirmation</h5>
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<div class="modal-body">
						<h4 align="center" style="margin: 0;">Are you sure you want to delete this ?</h4>
					</div>
					<div class="modal-footer">
						<button type="button" id="ok_delete" name="ok_delete" class="btn btn-danger">Delete</button>
						<button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Close</button>
					</div>
				</div><!-- /.modal-content -->
			</div><!-- /.modal-dialog -->
		</div><!-- /.modal -->
	@endcan
@endsection

@section('script')
	<!-- Required datatable js -->
	<script src="{{ asset('assets/libs/datatables/datatables.min.js') }}"></script>
	<script src="{{ asset('assets/libs/jszip/jszip.min.js') }}"></script>
	<script src="{{ asset('assets/libs/pdfmake/pdfmake.min.js') }}"></script>
	<!-- Datatable init js -->
	<script src="{{ asset('assets/js/pages/datatables.init.js') }}"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
@endsection

@section('script-bottom')
	<script>
		$(function () {
			const source = `{{ route("admin.orders.paginate") }}`;

			const DataTable = $("#example1").DataTable({
				dom: "Blfrtip",
				buttons: [
					{
						extend: "copy",
						className: "btn-sm"
					},
					{
						extend: "csv",
						className: "btn-sm"
					},
					{
						extend: "excel",
						className: "btn-sm"
					},
					{
						extend: "pdfHtml5",
						className: "btn-sm"
					},
					{
						extend: "colvis",
						className: "btn-sm"
					}
				],
				responsive: true,
				processing: true,
				serverSide: true,
				pageLength: 10,
				ajax: {
					url: source,
				},
				columns: [
					{
						data: "selection",
						name: "selection",
						orderable: false
					},
					{
						data: "id",
						name: "id"
					},
					{
						data: "first_name",
						name: "first_name"
					},
					{
						data: "last_name",
						name: "last_name"
					},
					{
						data: "email",
						name: "email"
					},
					{
						data: "contact",
						name: "contact"
					},
					{
						data: "order_status",
						name: "order_status"
					},
					{
						data: "total_amount",
						name: "total_amount"
					},
					{
						data: "created_at",
						name: "created_at"
					},
					{
						data: "actions",
						name: "actions",
						orderable: false
					}
				]
			});

			@can(PermissionEnum::ORDER_SHOW->value)
			// View Records
			$(document, this).on("click", ".view", function () {
				let id = $(this).attr("id");
				let url = '{{route('admin.orders.show',':id')}}';
				$.ajax({
					url: url.replace(":id", id),
					dataType: "json",
					success: function (data) {
						let categories = "";
						let products = "";
						data.categories.forEach(item => categories += `<span class="badge bg-primary">${ item.name }</span>`);
						data.products.forEach(item => products += `<span class="badge bg-primary">${ item.name }</span>`);
						document.getElementById("name").innerText = data.name;
						document.getElementById("code").innerText = data.code;
						document.getElementById("type").innerText = data.type;
						document.getElementById("discount").innerText = data.discount;
						document.getElementById("date_start").innerText = data.date_start;
						document.getElementById("date_end").innerText = data.date_end;
						document.getElementById("categories").innerHTML = categories;
						document.getElementById("products").innerHTML = products;
						$("#viewModal").modal("show");
					}
				});
			});
			@endcan

			let delete_id;
			$(document, this).on("click", ".delete", function () {
				delete_id = $(this).attr("id");
				$("#confirmModal").modal("show");
			});

			const okDeleteSelector = "#ok_delete";
			$(document).on("click", okDeleteSelector, function () {
				const url = '{{ route('admin.orders.destroy', ':id') }}';
				$.ajax({
					type: "delete",
					url: url.replace(":id", delete_id),
					headers: {
						"X-CSRF-TOKEN": $("meta[name=\"csrf-token\"]").attr("content")
					},
					beforeSend: function () {
						$(okDeleteSelector).text("Deleting...");
						$(okDeleteSelector).attr("disabled", true);
					},
					success: function (data) {
						DataTable.ajax.reload();
						$(okDeleteSelector).text("Delete");
						$(okDeleteSelector).attr("disabled", false);
						$("#confirmModal").modal("hide");
						toastr.success(data);
					},
				});
			});

			document.getElementById("select_all").addEventListener("click", (event) => {
				const checkboxes = Array.from(document.querySelectorAll(".delete_checkbox"));
				checkboxes.forEach((checkbox) => {
					checkbox.checked = !!event.target.checked;
				});
			});

			document.getElementById("delete_all").addEventListener("click", () => {
				const checkboxes = Array.from(document.querySelectorAll(".delete_checkbox:checked"));

				if (checkboxes.length > 0) {
					const checkboxValue = checkboxes.reduce((checkboxValue, checkbox) => {
						checkboxValue.push(checkbox.getAttribute("value"));

						return checkboxValue;
					}, []);

					fetch(`{{ route('admin.orders.massDestroy') }}`, {
						method: "delete",
						headers: {
							"Content-Type": "application/json",
							"X-CSRF-TOKEN": document.querySelector("meta[name=\"csrf-token\"]").content
						},
						body: JSON.stringify({ ids: checkboxValue }),
					}).then(r => r.json()).then((r) => {
						toastr.success(r);
						DataTable.ajax.reload();
					});
				} else {
					toastr.error("Select at least one record");
				}
			});
		});
	</script>
@endsection
