<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\settings\UpdateSettingRequest;
use App\Models\Setting;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class SettingsController extends Controller
{
    public function __construct()
    {
        $this->title = ucwords(str_replace('-', ' ', request()->segment(2)));
    }

    public function index()
    {
        //
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        //
    }

    public function edit(Setting $setting)
    {
        abort_if(Gate::denies('setting_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $title = $this->title;
        return view('admin.settings.form', compact('title', 'setting'));
    }

    public function update(UpdateSettingRequest $request, Setting $setting)
    {
        $setting->update(handleFilesIfPresent(request()->segment(2), $request->validated(), $setting));
        return redirect()->route('admin.settings.edit',$setting->id)->withToastSuccess('Setting Updated Successfully!');
    }

    public function destroy($id)
    {
        //
    }
}
