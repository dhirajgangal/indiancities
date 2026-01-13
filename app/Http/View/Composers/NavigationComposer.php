<?php

namespace App\Http\View\Composers;

use Illuminate\View\View;
use App\Models\City;

class NavigationComposer
{
    public function compose(View $view)
    {
        $cities = City::where('status', true)->get();
        $view->with('cities', $cities);
    }
}
