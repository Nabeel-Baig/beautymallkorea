<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function becomeMember(Request $request)
    {
        $request->validate([
            'email1' => 'required|email|string',
            'country' => 'required|string',
            'zipcode' => 'required',
            'description' => 'required|string',
            'amount' => 'required',
        ]);
        $user = $this->register($request);

        $order_id = IdGenerator::generate(['table' => 'orders', 'field' => 'order_id', 'length' => 6, 'prefix' => 'INV-']);
        $order = new Order;
        $order->name = $request->name;
        $order->email = $request->email1;
        $order->country = $request->country;
        $order->zipcode = $request->zipcode;
        $order->description = $request->description;
        $order->amount = $request->amount;
        $order->user_id = $user->id;
        $order->order_id = $order_id;
        $order->payment_status = 'Unpaid';
        $order->save();

        return redirect()->route('home.index')->withSuccess('Thank you for registering with us');
    }

    public function signUp(Request $request)
    {
        $this->register($request);
        return redirect()->route('home.index')->withSuccess('Thank you for registering with us');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|min:6',
        ]);
        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->save();
        $user->roles()->sync(3);
        return $user;
    }
}
