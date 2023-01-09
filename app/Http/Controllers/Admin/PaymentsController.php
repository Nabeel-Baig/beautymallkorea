<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Payment;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\payments\MassDestroyPaymentRequest;
use Gate;

class PaymentsController extends Controller
{
    public function __construct()
    {
        $this->title = ucwords('payments');
    }

    public function index()
    {
        abort_if(Gate::denies('payment_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        if (request()->ajax()) {
            $payments = Payment::with(['orders:id,order_id','users:id,name'])->orderBy('id','desc');
            $user = \auth()->user();
            if ($user->CountUserRole() > 0) {
                $payments->get();
            } else {
                $payments->where('user_id',$user->id)->get();
            }
            return datatables()->of($payments)
                ->addColumn('checkbox', function ($data) {
                    return '<input type="checkbox" class="delete_checkbox flat" value="' . $data['id'] . '">';
                })->addColumn('action', function ($data) {
                    $view = ''; $delete = '';
                    if (Gate::allows('payment_show')) {
                        $view = '<a target="_blank" title="View Invoice" href="' . $data->receipt_url . '" class="view btn btn-info btn-sm"><i class="fa fa-eye"></i></a>&nbsp;';
                    }
                    if (Gate::allows('payment_delete')) {
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
        abort_if(Gate::denies('payment_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $categories = Category::latest()->get()->pluck('name', 'id');
        $title = $this->title;
        return view('admin.' . request()->segment(2) . '.create', compact('categories','title'));
    }

    public function show(Payment $order)
    {
        $order->load('funds');
        return \response()->json($order);
    }

    public function destroy(Payment $order)
    {
        abort_if(Gate::denies('payment_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $order->delete();
        return \response()->json('Payment Deleted Successfully!');
    }

    public function massDestroy(MassDestroyPaymentRequest $request)
    {
        Payment::whereIn('id', request('ids'))->delete();
        return \response()->json('Selected records Deleted Successfully.');
    }
}
