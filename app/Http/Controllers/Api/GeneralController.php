<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\GeneralResource;

class GeneralController extends Controller
{
	final public function setting(): GeneralResource
	{
		$setting = \App\Models\Setting::findOrFail(1);
		return new GeneralResource($setting);
	}
}
