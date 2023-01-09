<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Fund;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\funds\StoreFundRequest;
use App\Http\Requests\funds\UpdateFundRequest;
use App\Http\Requests\funds\MassDestroyFundRequest;
use Gate;

class FundsController extends Controller
{
    public function __construct()
    {
        $this->title = ucwords('funds');
    }

    public function index()
    {
        abort_if(Gate::denies('fund_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        if (request()->ajax()) {
            $funds = Fund::with(['category:id,name','users:id,name'])->orderBy('id','desc');
            $user = \auth()->user();
            if ($user->CountUserRole() > 0) {
                $funds->get();
            } else {
                $funds->where('user_id',$user->id)->get();
            }
            return datatables()->of($funds)
                ->addColumn('checkbox', function ($data) {
                    return '<input type="checkbox" class="delete_checkbox flat" value="' . $data['id'] . '">';
                })->addColumn('image', function ($data) {
                    return '<img width="65" src="' . asset($data->image) . '">';
                })->addColumn('action', function ($data) {
                    $edit = ''; $duplicate = ''; $view = ''; $delete = '';
                    if (Gate::allows('fund_edit')) {
                        $edit = '<a title="Edit" href="' . route('admin.funds.edit',$data->id) . '" class="btn btn-primary btn-sm"><i class="fas fa-pen"></i></a>&nbsp;';
                    }
                    if (Gate::allows('fund_show')) {
                        $view = '<button title="View" type="button" name="view" id="' . $data['id'] . '" class="view btn btn-info btn-sm"><i class="fa fa-eye"></i></button>&nbsp;';
                    }
                    if (Gate::allows('fund_delete')) {
                        $delete = '<button title="Delete" type="button" name="delete" id="' . $data['id'] . '" class="delete btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>';
                    }
                    return $edit.$view.$delete;
                })->rawColumns(['checkbox', 'action','image'])->make(true);
        }
        $content['title'] = $this->title;
        return view('admin.' . request()->segment(2) . '.list')->with($content);
    }

    public function create()
    {
        abort_if(Gate::denies('fund_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $categories = Category::latest()->get()->pluck('name', 'id');
        $title = $this->title;
        return view('admin.' . request()->segment(2) . '.create', compact('categories','title'));
    }

    public function store(StoreFundRequest $request)
    {
        $fund = handleFiles(\request()->segment(2),$request->validated());
        $fund += ['user_id' => auth()->user()->id];
        Fund::create($fund);
        return redirect()->route('admin.' . request()->segment(2) . '.index')->withToastSuccess('Fund Created Successfully!');
    }

    public function show(Fund $fund)
    {
        $fund->load('category');
        return \response()->json($fund);
    }

    public function edit(Fund $fund)
    {
        abort_if(Gate::denies('fund_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $categories = Category::latest()->get()->pluck('name', 'id');
        $title = $this->title;
        return view('admin.' . request()->segment(2) . '.edit',compact('categories','fund','title'));
    }

    public function update(UpdateFundRequest $request, Fund $fund)
    {
        $fund->update(handleFilesIfPresent(\request()->segment(2),$request->validated(), $fund));
        return redirect()->route('admin.' . request()->segment(2) . '.index')->withToastSuccess('Fund Updated Successfully!');
    }

    public function destroy(Fund $fund)
    {
        abort_if(Gate::denies('fund_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $fund->delete();
        return \response()->json('Fund Deleted Successfully!');
    }

    public function massDestroy(MassDestroyFundRequest $request)
    {
        Fund::whereIn('id', request('ids'))->delete();
        return \response()->json('Selected records Deleted Successfully.');
    }
}
