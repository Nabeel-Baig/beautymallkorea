<?php

namespace App\View\Composers;

use Illuminate\View\View;
use App\Models\Setting;

class SettingComposer
{
    public function compose(View $view)
    {
        $view->with('setting', Setting::findOrFail(1));
    }
}
