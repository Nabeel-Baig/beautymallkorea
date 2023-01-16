<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Users\MassDestroyUserRequest;
use App\Http\Requests\Users\StoreUserRequest;
use App\Http\Requests\Users\UpdateUserRequest;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;
use function request;

class UsersController extends Controller
{
	public function __construct()
	{
		$this->title = ucwords('users');
	}

	public function index()
	{
		abort_if(Gate::denies('user_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
		if (request()->ajax()) {
			$users = User::orderBy('id', 'desc')->get();
			return datatables()->of($users)
				->addColumn('checkbox', function ($data) {
					return '<input type="checkbox" class="delete_checkbox flat" value="' . $data['id'] . '">';
				})->addColumn('image', function ($data) {
					return '<img width="65" src="' . asset(!empty($data->avatar) ? $data->avatar : 'https://ui-avatars.com/api/?background=random&name=' . ucfirst($data->name)) . '">';
				})->addColumn('action', function ($data) {
					$edit = '';
					$duplicate = '';
					$view = '';
					$delete = '';
					if (Gate::allows('user_edit')) {
						$edit = '<a title="Edit" href="' . route('admin.users.edit', $data->id) . '" class="btn btn-primary btn-sm"><i class="fas fa-pen"></i></a>&nbsp;';
					}
					if (Gate::allows('user_show')) {
						$view = '<button title="View" type="button" name="view" id="' . $data['id'] . '" class="view btn btn-info btn-sm"><i class="fa fa-eye"></i></button>&nbsp;';
					}
					if (Gate::allows('user_delete')) {
						$delete = '<button title="Delete" type="button" name="delete" id="' . $data['id'] . '" class="delete btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>';
					}
					return $edit . $view . $delete;
				})->rawColumns(['checkbox', 'action', 'image'])->make(true);
		}
		$content['title'] = $this->title;
		return view('admin.users.list')->with($content);
	}

	public function store(StoreUserRequest $request)
	{
		$user = User::create(handleFiles(request()->segment(2), $request->validated()));
		$user->password = Hash::make($request->get('password'));
		$user->save();
		$user->roles()->sync($request->input('roles', []));
		return redirect()->route('admin.users.index')->withToastSuccess('User Created Successfully!');
	}

	public function create()
	{
		abort_if(Gate::denies('user_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

		$roles = Role::where('id', '!=', 1)->latest()->get()->pluck('title', 'id');
		$title = $this->title;
		return view('admin.users.create', compact('roles', 'title'));
	}

	public function show(User $user)
	{
		return \response()->json($user);
	}

	public function edit(User $user)
	{
		abort_if(Gate::denies('user_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
		$roles = Role::where('id', '!=', 1)->latest()->get()->pluck('title', 'id');
		$user->load('roles');
		$title = $this->title;
		return view('admin.users.edit', compact('roles', 'user', 'title'));
	}

	public function update(UpdateUserRequest $request, User $user)
	{
		$user->update(handleFilesIfPresent(request()->segment(2), $request->validated(), $user));
		$user->password = Hash::make($request->get('password'));
		$user->save();
		$user->roles()->sync($request->input('roles', []));
		return redirect()->route('admin.users.index')->withToastSuccess('User Updated Successfully!');
	}

	public function destroy(User $user)
	{
		abort_if(Gate::denies('user_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');
		$user->delete();
		return \response()->json('User Deleted Successfully!');
	}

	public function massDestroy(MassDestroyUserRequest $request)
	{
		User::whereIn('id', request('ids'))->delete();
		return \response()->json('Selected records Deleted Successfully.');
	}
}
