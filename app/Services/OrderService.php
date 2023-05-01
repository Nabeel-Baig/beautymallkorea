<?php

namespace App\Services;

use App\Enums\PermissionEnum;
use App\Models\Order;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Gate;

class OrderService
{
	final public function paginate(): JsonResponse
	{
		$orders = Order::select(['id','first_name','last_name','email','contact','order_status','total_amount','created_at'])->orderBy('id', 'desc')->get();
		return datatables()->of($orders)
			->addColumn('selection', function ($data) {
				return '<input type="checkbox" class="delete_checkbox flat" value="' . $data['id'] . '">';
			})->addColumn('actions', function ($data) {
				$edit = '';
				$delete = '';
				$view  = '';
				if (Gate::allows(PermissionEnum::ORDER_EDIT->value)) {
					$edit = '<a title="Edit" href="' . route('admin.orders.edit', $data->id) . '" class="btn btn-primary btn-sm"><i class="fas fa-pen"></i></a>&nbsp;';
				}
				if (Gate::allows(PermissionEnum::ORDER_SHOW->value)) {
					$view = '<a title="View Invoice" href="' . route('admin.orders.show', $data->id) . '" class="btn btn-primary btn-sm"><i class="fas fa-eye"></i></a>&nbsp;';
				}
				if (Gate::allows(PermissionEnum::ORDER_DELETE->value)) {
					$delete = '<button title="Delete" type="button" name="delete" id="' . $data['id'] . '" class="delete btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>';
				}
				return $edit . $view . $delete;
			})->rawColumns(['selection', 'actions'])->make(true);
	}
}
