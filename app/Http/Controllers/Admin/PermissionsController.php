<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\permissions\MassDestroyPermissionRequest;
use App\Http\Requests\permissions\StorePermissionRequest;
use App\Http\Requests\permissions\UpdatePermissionRequest;
use App\Models\Permission;
use Gate;
use Symfony\Component\HttpFoundation\Response;

class PermissionsController extends Controller
{
    public function __construct()
    {
        $this->title = ucwords(str_replace('-', ' ', request()->segment(2)));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort_if(Gate::denies('permission_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if (request()->ajax()) {
            $permissions = Permission::orderBy('id','desc')->get();
            return datatables()->of($permissions)
                ->addColumn('checkbox', function ($data) {
                    return '<input type="checkbox" class="delete_checkbox flat" value="' . $data['id'] . '">';
                })->addColumn('action', function ($data) {
                    $edit = ''; $duplicate = ''; $view = ''; $delete = '';
                    if (Gate::allows('permission_edit')) {
                        $edit = '<a title="Edit" href="' . route('admin.permissions.edit',$data->id) . '" class="btn btn-primary btn-sm"><i class="fas fa-pen"></i></a>&nbsp;';
                    }
                    if (Gate::allows('permission_show')) {
                        $view = '<button title="View" type="button" name="view" id="' . $data['id'] . '" class="view btn btn-info btn-sm"><i class="fa fa-eye"></i></button>&nbsp;';
                    }
                    if (Gate::allows('permission_delete')) {
                        $delete = '<button title="Delete" type="button" name="delete" id="' . $data['id'] . '" class="delete btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>';
                    }
                    return $edit.$view.$delete;
                })->rawColumns(['checkbox', 'action'])->make(true);
        }
        $content['title'] = $this->title;
        return view('admin.' . request()->segment(2) . '.list')->with($content);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort_if(Gate::denies('permission_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $title = $this->title;
        return view('admin.' . request()->segment(2) . '.form',compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePermissionRequest $request)
    {
        Permission::create($request->all());
        return redirect()->route('admin.permissions.index')->withToastSuccess('Permission Created Successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Permission $permission)
    {
        return \response()->json($permission);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Permission $permission)
    {
        abort_if(Gate::denies('permission_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $title = $this->title;
        return view('admin.' . request()->segment(2) . '.form',compact('title','permission'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePermissionRequest $request, Permission $permission)
    {
        $permission->update($request->all());
        return redirect()->route('admin.permissions.index')->withToastSuccess('Permission Updated Successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Permission $permission)
    {
        abort_if(Gate::denies('permission_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $permission->delete();
        return \response()->json('Permission Deleted Successfully!');
    }

    public function massDestroy(MassDestroyPermissionRequest $request)
    {
        Permission::whereIn('id', request('ids'))->delete();
        return \response()->json('Selected records Deleted Successfully.');
    }
}
