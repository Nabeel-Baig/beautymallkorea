<?php

namespace App\Http\Controllers\Admin;

use App\Enums\PermissionEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Customers\MassDestroyCustomerRequest;
use App\Http\Requests\Api\Auth\SignUpRequest;
use App\Http\Requests\Api\Auth\UpdateCustomerRequest;
use App\Models\Customer;
use App\Services\CustomerService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class CustomersController extends Controller
{
	public function __construct(private readonly CustomerService $customerService) {
		$this->title = 'Customers';
	}

	final public function index(): View
	{
		abort_if(Gate::denies(PermissionEnum::CUSTOMER_ACCESS->value),Response::HTTP_FORBIDDEN,'403 Forbidden');
		$content['title'] = $this->title;
		$content['headers'] = ["ID", "First Name", "Last Name", "Profile Picture", "Email", "Contact"];
		return view("admin.customers.index")->with($content);
	}

	final public function paginate(): JsonResponse {
		abort_if(Gate::denies(PermissionEnum::CUSTOMER_ACCESS->value),Response::HTTP_FORBIDDEN,'403 Forbidden');
		return $this->customerService->paginate();
	}

	final public function create(): View
	{
		abort_if(Gate::denies(PermissionEnum::CUSTOMER_CREATE->value),Response::HTTP_FORBIDDEN,'403 Forbidden');
		$content['title'] = $this->title;
		return view('admin.customers.form')->with($content);
	}

	final public function store(SignUpRequest $signUpRequest): RedirectResponse
	{
		abort_if(Gate::denies(PermissionEnum::CUSTOMER_CREATE->value),Response::HTTP_FORBIDDEN,'403 Forbidden');
		$this->customerService->create($signUpRequest);
		return redirect()->route('admin.customers.index')->withToastSuccess('Customer Created Successfully!');
	}

	final public function show(Customer $customer): JsonResponse {
		return \response()->json($customer);
	}

	public function edit(Customer $customer): View
	{
		abort_if(Gate::denies(PermissionEnum::CUSTOMER_EDIT->value),Response::HTTP_FORBIDDEN,'403 Forbidden');
		$title = $this->title;
		return view('admin.customers.form',compact('title','customer'));
	}

	public function update(UpdateCustomerRequest $updateCustomerRequest, Customer $customer)
	{
		abort_if(Gate::denies(PermissionEnum::CUSTOMER_EDIT->value),Response::HTTP_FORBIDDEN,'403 Forbidden');
		$this->customerService->update($updateCustomerRequest, $customer);
		return redirect()->route('admin.customers.index')->withUpdatedSuccessToastr("Customer");
	}

	public function destroy(Customer $customer): JsonResponse
	{
		abort_if(Gate::denies(PermissionEnum::CUSTOMER_DELETE->value),Response::HTTP_FORBIDDEN,'403 Forbidden');
		$this->customerService->delete($customer);
		return \response()->json('Customer Deleted Successfully!');

	}

	final public function massDestroy(MassDestroyCustomerRequest $massDestroyCustomerRequest): JsonResponse {
		abort_if(Gate::denies(PermissionEnum::CUSTOMER_EDIT->value),Response::HTTP_FORBIDDEN,'403 Forbidden');
		$this->customerService->deleteMany($massDestroyCustomerRequest);
		return \response()->json('Selected records Deleted Successfully.');
	}
}
