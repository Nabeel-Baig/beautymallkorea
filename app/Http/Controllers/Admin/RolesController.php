<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\roles\MassDestroyRoleRequest;
use App\Http\Requests\roles\StoreRoleRequest;
use App\Http\Requests\roles\UpdateRoleRequest;
use App\Models\Role;
use Gate;
use Symfony\Component\HttpFoundation\Response;

class RolesController extends Controller
{
    public function __construct()
    {
        $this->title = ucwords('roles');
    }

    public function index()
    {
        abort_if(Gate::denies('role_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if (request()->ajax()) {
            $roles = Role::orderBy('id','desc')->get();
            return datatables()->of($roles)
                ->addColumn('checkbox', function ($data) {
                    return '<input type="checkbox" class="delete_checkbox flat" value="' . $data['id'] . '">';
                })->addColumn('action', function ($data) {
                    $edit = ''; $duplicate = ''; $view = ''; $delete = '';
                    if (Gate::allows('role_edit')) {
                        $edit = '<a title="Edit" href="' . route('admin.roles.edit',$data->id) . '" class="btn btn-primary btn-sm"><i class="fas fa-pen"></i></a>&nbsp;';
                    }
                    if (Gate::allows('role_show')) {
                        $view = '<button title="View" type="button" name="view" id="' . $data['id'] . '" class="view btn btn-info btn-sm"><i class="fa fa-eye"></i></button>&nbsp;';
                    }
                    if (Gate::allows('role_delete')) {
                        $delete = '<button title="Delete" type="button" name="delete" id="' . $data['id'] . '" class="delete btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>';
                    }
                    return $edit.$view.$delete;
                })->rawColumns(['checkbox', 'action'])->make(true);
        }
        $content['title'] = $this->title;
        return view('admin.roles.list')->with($content);
    }

    public function create()
    {
        abort_if(Gate::denies('role_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $permissions = \App\Models\Permission::latest()->get()->pluck('title','id');
        $title = $this->title;
        return view('admin.roles.create',compact('title','permissions'));
    }

    public function store(StoreRoleRequest $request)
    {
        $role = Role::create($request->all());
        $role->permissions()->sync($request->input('permissions',[]));
        return redirect()->route('admin.roles.index')->withToastSuccess('Role Created Successfully!');
    }

    public function show(Role $role)
    {
        $role->load('permissions');
        return \response()->json($role);
    }

    public function edit(Role $role)
    {
        abort_if(Gate::denies('role_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $permissions = \App\Models\Permission::latest()->get()->pluck('title','id');
        $role->load('permissions');
        $title = $this->title;
        return view('admin.roles.edit',compact('title','role','permissions'));
    }

    public function update(UpdateRoleRequest $request, Role $role)
    {
        $role->update($request->all());
        $role->permissions()->sync($request->input('permissions',[]));
        return redirect()->route('admin.roles.index')->withToastSuccess('Role Updated Successfully!');
    }

    public function destroy(Role $role)
    {
        abort_if(Gate::denies('role_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $role->delete();
        return \response()->json('Role Deleted Successfully!');
    }

    public function massDestroy(MassDestroyRoleRequest $request)
    {
        Role::whereIn('id', request('ids'))->delete();
        return \response()->json('Selected records Deleted Successfully.');
    }
}
