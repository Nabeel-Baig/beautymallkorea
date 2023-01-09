<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;


class DashboardController extends Controller
{
    public function index()
    {
        // dd('1');
        /* $donation = Order::select(\DB::raw('count(*) as donation_count, SUM(amount) as donation_amount'))->where('payment_status','Paid');
        $fund = new Fund;
        $user = \auth()->user();
        if ($user->CountUserRole() > 0) {
            $fund = $fund->count();
            $donation = $donation->firstOrFail();
        } else {
            $where = ['user_id'=>$user->id];
            $fund = $fund->where($where)->count();
            $donation = $donation->where($where)->firstOrFail();
        } */
        return view('admin.dashboard.index');
    }
}
