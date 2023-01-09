<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Fund;
use Illuminate\Http\Request;

class DiscoverController extends Controller
{
    public function index()
    {
        $fundraisers = Fund::latest()->take(4)->get();
        $categories = Category::take(4)->get();
        return view('front.discover',compact('fundraisers','categories'));
    }
}
