<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Fund;
use Illuminate\Http\Request;
use function GuzzleHttp\Promise\all;

class HomeController extends Controller
{
    public function index()
    {
        $fundraisers = Fund::latest()->take(4)->get();
        $nearYous = Fund::nearYou()->get();
        return view('front.home',compact('fundraisers','nearYous'));
    }

    public function home(Request $request)
    {
        $path = str_replace('-','_',$request->path());
        if (view()->exists('front.'.$path)) {
            return view('front.'.$path);
        }
        return abort(404);
    }

}
