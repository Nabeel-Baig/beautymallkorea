<?php

namespace App\Http\Controllers\Admin;

use App\Enums\PermissionEnum;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Services\OrderService;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\Response;

class OrdersController extends Controller
{
    public function __construct(private readonly OrderService $orderService)
    {
        $this->title = ucwords('orders');
    }

    final public function index(): View
    {
        abort_if(Gate::denies(PermissionEnum::ORDER_ACCESS->value), Response::HTTP_FORBIDDEN, '403 Forbidden');
		$content['title'] = $this->title;
		$content['headers'] = ["Order ID", "First Name", "Last Name", "Email", "Contact", "Status", "Total", "Created At"];
		return view("admin.orders.index")->with($content);
    }

	final public function paginate(): JsonResponse {
		abort_if(Gate::denies(PermissionEnum::ORDER_ACCESS->value),Response::HTTP_FORBIDDEN,'403 Forbidden');
		return $this->orderService->paginate();
	}

	final public function show(Order $order): View
    {
		$order->load('orderItems');
        abort_if(Gate::denies(PermissionEnum::ORDER_SHOW->value),RESPONSE::HTTP_FORBIDDEN, '403 Forbidden');
        return view('admin.orders.invoice',compact('order'));
    }

    public function edit(Order $order)
    {
        abort_if(Gate::denies('order_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $categories = Category::latest()->get()->pluck('name', 'id');
        $title = $this->title;
        return view('admin.' . request()->segment(2) . '.edit',compact('categories','order','title'));
    }

    public function update(UpdateOrderRequest $request, Order $order)
    {
        $order->update(handleFilesIfPresent(\request()->segment(2),$request->validated(), $order));
        return redirect()->route('admin.' . request()->segment(2) . '.index')->withToastSuccess('Order Updated Successfully!');
    }

    public function destroy(Order $order)
    {
        abort_if(Gate::denies('order_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $order->delete();
        return \response()->json('Order Deleted Successfully!');
    }

    public function massDestroy(MassDestroyOrderRequest $request)
    {
        Order::whereIn('id', request('ids'))->delete();
        return \response()->json('Selected records Deleted Successfully.');
    }
}
