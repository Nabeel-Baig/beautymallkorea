<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Fund;
use App\Models\Order;
use Illuminate\View\View;
use Share;

class FundController extends Controller
{
    final public function index(Category $category): View
    {
        $category = $category->load('funds');
        return view('front.fund',compact('category'));
    }

    final public function fund(Fund $fund): View
    {
        $socialShare = Share::page(url()->current(),$fund->name)->facebook()->twitter()->whatsapp()->getRawLinks();
        $donations = Order::select(\DB::raw('count(*) as donation_count, SUM(amount) as donation_amount'))->where(['fund_id' => $fund->id, 'payment_status' => 'Paid'])->firstOrFail();
        return view('front.fund_detail',compact('fund','donations','socialShare'));
    }
}
