@extends('layouts.master')
@section('title')
	{{ $title ?? '' }}
@endsection
@section('page-specific-css')
	<!-- DataTables -->
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
						@can('category_delete')
							<button type="button" class="btn btn-danger" id="delete_all">Delete Selected</button>
						@endcan
						@can('category_create')
							<a class="btn btn-info" href="{{ route('admin.' . request()->segment(2) . '.create') }}">Add</a>
						@endcan
					</div>
					<table id="example1" class="table table-striped table-bordered dt-responsive nowrap">
						<thead>
						<tr>
							<th width="10">
								<input type="checkbox" id="select_all">All
							</th>
							<th>
								{{ ucwords(str_replace('_',' ','id')) }}
							</th>
							<th>
								{{ ucwords(str_replace('_',' ','category_name')) }}
							</th>
							<th>
								{{ ucwords(str_replace('_',' ','sub_categories')) }}
							</th>
							<th>
								{{ ucwords(str_replace('_',' ','sort_order')) }}
							</th>
							<th>
								Action
							</th>
						</tr>
						</thead>
						<tbody></tbody>
					</table>
				</div>
			</div>
		</div> <!-- end col -->
	</div> <!-- end row -->

	@can('category_show')
		<!-- sample modal content -->
		<div id="viewModal" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel"
			 aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title mt-0" id="myModalLabel">View {{ucwords(str_replace('_',' ',request()->segment(2)))}}</h5>
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
									<th>{{ucwords(str_replace('_',' ','description'))}}</th>
									<td id="description" align="center"></td>
								</tr>
								<tr>
									<th>{{ucwords(str_replace('_',' ','meta_tag_title'))}}</th>
									<td id="meta_tag_title" align="center"></td>
								</tr>
								<tr>
									<th>{{ucwords(str_replace('_',' ','meta_tag_description'))}}</th>
									<td id="meta_tag_description" align="center"></td>
								</tr>
								<tr>
									<th>{{ucwords(str_replace('_',' ','meta_tag_keywords'))}}</th>
									<td id="meta_tag_keywords" align="center"></td>
								</tr>
								<tr>
									<th>{{ucwords(str_replace('_',' ','sort_order'))}}</th>
									<td id="sort_order" align="center"></td>
								</tr>
								<tr>
									<th>{{ucwords(str_replace('_',' ','image'))}}</th>
									<td id="image" align="center"></td>
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

	@can('category_delete')
		<!-- Delete content -->
		<div id="confirmModal" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel"
			 aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title mt-0">Confirmation</h5>
						<button type="button" class="btn-close" data-bs-dismiss="modal"
								aria-label="Close"></button>
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
			let source = `{{ !empty(request()->get('id')) ? route('admin.'.request()->segment(2).'.index',['id' => request()->get('id')]) : route('admin.'.request()->segment(2).'.index') }}`;
			let DataTable = $("#example1").DataTable({
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
						data: "checkbox",
						name: "checkbox",
						orderable: false
					},
					{
						data: "id",
						name: "id"
					},
					{
						data: "name",
						name: "name"
					},
					{
						data: "sub_categories",
						name: "sub_categories",
						orderable: false
					},
					{
						data: "sort_order",
						name: "sort_order"
					},
					{
						data: "action",
						name: "action",
						orderable: false
					}
				]
			});
			// View Records
			$(document, this).on("click", ".view", function () {
				let id = $(this).attr("id");
				let url = '{{route('admin.'.request()->segment(2).'.show',':id')}}';
				$.ajax({
					url: url.replace(":id", id),
					dataType: "json",
					success: function (data) {
						let image = (data.image === null) ?`<img alt="No Image" src="{{asset('images/placeholder.png')}}" width="100" />` : `<img alt="Category Image" src="{{asset('')}}${ data.image }" width="100" />`;
						document.getElementById("name").innerText = data.name;
						document.getElementById("description").innerHTML = data.description;
						document.getElementById("meta_tag_title").innerText = data.meta_tag_title;
						document.getElementById("meta_tag_description").innerText = data.meta_tag_description;
						document.getElementById("meta_tag_keywords").innerText = data.meta_tag_keywords;
						document.getElementById("sort_order").innerText = data.sort_order;
						document.getElementById("image").innerHTML = image;
						$("#viewModal").modal("show");
					}
				});
			});
			var delete_id;
			$(document, this).on("click", ".delete", function () {
				delete_id = $(this).attr("id");
				$("#confirmModal").modal("show");
			});
			$(document).on("click", "#ok_delete", function () {
				let url = '{{ route('admin.'.request()->segment(2).'.destroy',':id') }}';
				$.ajax({
					type: "delete",
					url: url.replace(":id", delete_id),
					headers: {
						"X-CSRF-TOKEN": $("meta[name=\"csrf-token\"]").attr("content")
					},
					beforeSend: function () {
						$("#ok_delete").text("Deleting...");
						$("#ok_delete").attr("disabled", true);
					},
					success: function (data) {
						DataTable.ajax.reload();
						$("#ok_delete").text("Delete");
						$("#ok_delete").attr("disabled", false);
						$("#confirmModal").modal("hide");
						toastr.success(data);
					}
				});
			});
			document.getElementById("select_all").addEventListener("click", event =>
				(event.target.checked === true) ? Array.from(document.querySelectorAll(".delete_checkbox")).forEach(checkbox =>
					checkbox.checked = true
				) : Array.from(document.querySelectorAll(".delete_checkbox")).forEach(checkbox =>
					checkbox.checked = false
				)
			);

			document.getElementById("delete_all").addEventListener("click", () => {
				let checkboxes = Array.from(document.querySelectorAll(".delete_checkbox:checked"));
				if (checkboxes.length > 0) {
					var checkboxValue = [];
					checkboxes.forEach((e) => {
						checkboxValue.push(e.getAttribute("value"));
					});
					let ajax = async () => {
						await fetch(`{{route('admin.'.request()->segment(2).'.massDestroy')}}`, {
							method: "delete",
							headers: {
								"Content-Type": "application/json",
								"X-CSRF-TOKEN": document.querySelector("meta[name=\"csrf-token\"]").content
							},
							body: JSON.stringify({ ids: checkboxValue }),
						})
							.then(r => r.json())
							.then((r) => {
								toastr.success(r);
								DataTable.ajax.reload();
							});
					};
					ajax();
				} else {
					toastr.error("Select at least one record");
				}
			});
		});
	</script>
@endsection
