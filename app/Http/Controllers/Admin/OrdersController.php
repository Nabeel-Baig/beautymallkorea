<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Order;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\orders\StoreOrderRequest;
use App\Http\Requests\orders\UpdateOrderRequest;
use App\Http\Requests\orders\MassDestroyOrderRequest;
use Gate;

class OrdersController extends Controller
{
    public function __construct()
    {
        $this->title = ucwords('orders');
    }

    public function index()
    {
        abort_if(Gate::denies('order_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        if (request()->ajax()) {
            $orders = Order::with(['funds:id,name','users:id,name'])->orderBy('id','desc');
            $user = \auth()->user();
            if ($user->CountUserRole() > 0) {
                $orders->get();
            } else {
                $orders->where('user_id',$user->id)->get();
            }
            return datatables()->of($orders)
                ->addColumn('checkbox', function ($data) {
                    return '<input type="checkbox" class="delete_checkbox flat" value="' . $data['id'] . '">';
                })->addColumn('action', function ($data) {
                    $view = ''; $delete = '';
                    if (Gate::allows('order_show')) {
                        $view = '<button title="View" type="button" name="view" id="' . $data['id'] . '" class="view btn btn-info btn-sm"><i class="fa fa-eye"></i></button>&nbsp;';
                    }
                    if (Gate::allows('order_delete')) {
                        $delete = '<button title="Delete" type="button" name="delete" id="' . $data['id'] . '" class="delete btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>';
                    }
                    return $view.$delete;
                })->rawColumns(['checkbox', 'action'])->make(true);
        }
        $content['title'] = $this->title;
        return view('admin.' . request()->segment(2) . '.list')->with($content);
    }

    public function create()
    {
        abort_if(Gate::denies('order_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $categories = Category::latest()->get()->pluck('name', 'id');
        $title = $this->title;
        return view('admin.' . request()->segment(2) . '.create', compact('categories','title'));
    }

    public function store(StoreOrderRequest $request)
    {
        $order = handleFiles(\request()->segment(2),$request->validated());
        $order += ['user_id' => auth()->user()->id];
        Order::create($order);
        return redirect()->route('admin.' . request()->segment(2) . '.index')->withToastSuccess('Order Created Successfully!');
    }

    public function show(Order $order)
    {
        abort_if(Gate::denies('order_show'),RESPONSE::HTTP_FORBIDDEN, '403 Forbidden');
        $order->load('funds');
        return \response()->json($order);
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
