@php use App\Enums\PermissionEnum; @endphp

@extends('layouts.master')

@section('title')
	{{ $title ?? '' }}
@endsection

@section('page-specific-css')
	<link href="{{ asset('assets/libs/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
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
						@can(PermissionEnum::TAG_DELETE->value)
							<button type="button" class="btn btn-danger" id="delete_all">Delete Selected</button>
						@endcan

						@can(PermissionEnum::TAG_CREATE->value)
							<a class="btn btn-info" href="{{ route('admin.brands.create') }}">Add</a>
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

	@can(PermissionEnum::TAG_DELETE->value)
		<!-- Delete content -->
		<div id="confirmModal" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title mt-0">Confirmation</h5>
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<div class="modal-body">
						<h4 style="margin: 0; text-align: center">Are you sure you want to delete this ?</h4>
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
		$(function() {
			const source = `{{ route("admin.brands.paginate") }}`;

			const DataTable = $("#example1").DataTable({
				dom: "Blfrtip",
				buttons: [
					{
						extend: "copy",
						className: "btn-sm",
					},
					{
						extend: "csv",
						className: "btn-sm",
					},
					{
						extend: "excel",
						className: "btn-sm",
					},
					{
						extend: "pdfHtml5",
						className: "btn-sm",
					},
					{
						extend: "colvis",
						className: "btn-sm",
					},
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
						orderable: false,
					},
					{
						data: "id",
						name: "id",
					},
					{
						data: "name",
						name: "name",
					},
					{
						data: "countryFlag",
						name: "countryFlag",
					},
					{
						data: "countryName",
						name: "countryName",
					},
					{
						data: "actions",
						name: "actions",
						orderable: false,
					},
				],
			});

			let delete_id;
			$(document, this).on("click", ".delete", function() {
				delete_id = $(this).attr("id");
				$("#confirmModal").modal("show");
			});

			const okDeleteSelector = "#ok_delete";
			$(document).on("click", okDeleteSelector, function() {
				let url = '{{ route('admin.brands.delete', ':id') }}';
				$.ajax({
					type: "delete",
					url: url.replace(":id", delete_id),
					headers: {
						"X-CSRF-TOKEN": $("meta[name=\"csrf-token\"]").attr("content"),
					},
					beforeSend: function() {
						$(okDeleteSelector).text("Deleting...");
						$(okDeleteSelector).attr("disabled", true);
					},
					success: function(data) {
						DataTable.ajax.reload();
						$(okDeleteSelector).text("Delete");
						$(okDeleteSelector).attr("disabled", false);
						$("#confirmModal").modal("hide");
						toastr.success(data);
					},
				});
			});
			document.getElementById("select_all").addEventListener("click", event =>
				(event.target.checked === true) ? Array.from(document.querySelectorAll(".delete_checkbox")).forEach(checkbox =>
					checkbox.checked = true,
				) : Array.from(document.querySelectorAll(".delete_checkbox")).forEach(checkbox =>
					checkbox.checked = false,
				),
			);

			document.getElementById("delete_all").addEventListener("click", () => {
				let checkboxes = Array.from(document.querySelectorAll(".delete_checkbox:checked"));
				if (checkboxes.length > 0) {
					const checkboxValue = [];
					checkboxes.forEach((e) => {
						checkboxValue.push(e.getAttribute("value"));
					});
					fetch(`{{ route('admin.brands.delete.many') }}`, {
						method: "delete",
						headers: {
							"Content-Type": "application/json",
							"X-CSRF-TOKEN": document.querySelector("meta[name=\"csrf-token\"]").content,
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
