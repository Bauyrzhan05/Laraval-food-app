<?php

namespace App\Http\Controllers;

use App\Mail\OrderPlacedMail;
use App\Mail\OrderStatusUpdatedMail;
use App\Models\Food;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class OrderController extends Controller
{
    public function store(Request $request, $foodId)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $food = Food::findOrFail($foodId);

        if ($food->quantity < $request->quantity) {
            return redirect('/foods')->with('error', __('app.messages.not_enough_food'));
        }

        $order = Order::create([
            'user_id' => Auth::id(),
            'food_id' => $food->id,
            'quantity' => $request->quantity,
            'status' => 'pending',
        ]);

        $food->decrement('quantity', $request->quantity);

        $order->load(['user', 'food']);

        Mail::to($order->user->email)->send(new OrderPlacedMail($order));

        return redirect('/my-orders')->with('success', __('app.messages.order_created'));
    }

    public function myOrders()
    {
        $orders = Order::with('food')
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('orders.my-orders', compact('orders'));
    }

    public function allOrders()
    {
        $orders = Order::with(['user', 'food'])
            ->latest()
            ->get();

        return view('orders.index', compact('orders'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,preparing,on_the_way,delivered',
        ]);

        $order = Order::findOrFail($id);

        $user = Auth::user();

        if ($user->hasRole('courier') && ! in_array($request->status, ['on_the_way', 'delivered'])) {
            return back()->with('error', __('app.messages.courier_status_only'));
        }

        if ($user->hasRole('manager') && ! in_array($request->status, ['preparing'])) {
            return back()->with('error', __('app.messages.manager_status_only'));
        }

        $order->update([
            'status' => $request->status,
        ]);

        $order->load(['user', 'food']);

        Mail::to($order->user->email)->send(new OrderStatusUpdatedMail($order));

        return back()->with('success', __('app.messages.order_status_updated'));
    }
}
