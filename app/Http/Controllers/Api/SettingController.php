<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\Setting\SettingResource;
use App\Models\Setting;

class SettingController extends Controller
{
	final public function setting(): SettingResource
	{
		$setting = Setting::findOrFail(1);
		return new SettingResource($setting);
	}
}
