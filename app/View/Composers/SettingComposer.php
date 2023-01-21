<?php

namespace App\View\Composers;

use App\Models\Setting;
use Illuminate\View\View;

class SettingComposer {
	final public function compose(View $view): void {
		$setting = Setting::findOrFail(1);
		$view->with(compact('setting'));
	}
}
