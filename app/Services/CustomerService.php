<?php

namespace App\Services;

use App\Enums\PermissionEnum;
use App\Http\Requests\Admin\Customers\MassDestroyCustomerRequest;
use App\Http\Requests\Api\Auth\SignUpRequest;
use App\Http\Requests\Api\Auth\UpdateCustomerRequest;
use App\Models\Customer;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\JsonResponse;

class CustomerService
{
	public function __construct() {}

	final public function paginate(): JsonResponse {
		return datatables()->of(Customer::orderBy('id', 'desc')->get())
			->addColumn('selection', function ($data) {
				return '<input type="checkbox" class="delete_checkbox flat" value="' . $data['id'] . '">';
			})->addColumn('image', function ($data) {
				return '<img width="65" src="' . asset($data->profile_picture) . '">';
			})->addColumn('actions', function ($data) {
				$edit = '';
				$delete = '';
				$view  = '';
				if (Gate::allows(PermissionEnum::CUSTOMER_EDIT->value)) {
					$edit = '<a title="Edit" href="' . route('admin.customers.edit', $data->id) . '" class="btn btn-primary btn-sm"><i class="fas fa-pen"></i></a>&nbsp;';
				}
				if (Gate::allows(PermissionEnum::CUSTOMER_SHOW->value)) {
					$view = '<button title="View" type="button" name="view" id="' . $data['id'] . '" class="view btn btn-info btn-sm"><i class="fa fa-eye"></i></button>&nbsp;';
				}
				if (Gate::allows(PermissionEnum::CUSTOMER_DELETE->value)) {
					$delete = '<button title="Delete" type="button" name="delete" id="' . $data['id'] . '" class="delete btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>';
				}
				return $edit . $view . $delete;
			})->rawColumns(['selection', 'actions', 'image'])->make(true);
	}

	final public function create(SignUpRequest $signUpRequest): Customer {
		return Customer::create(handleFiles('customers', $signUpRequest->validated()));
	}

	final public function update(UpdateCustomerRequest $updateCustomerRequest, Customer $customer): Customer {
		$data = handleFilesIfPresent('customers', $updateCustomerRequest->validated(), $customer);
		$customer->update($data);
		return $customer;
	}

	final public function deleteMany(MassDestroyCustomerRequest $massDestroyCustomerRequest): void {
		$recordsToDelete = $massDestroyCustomerRequest->get("ids");

		Customer::whereIn("id", $recordsToDelete)->delete();
	}

	final public function delete(Customer $customer): void {
		$customer->delete();
	}
}
