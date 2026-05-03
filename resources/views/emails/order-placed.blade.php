@php
    $total = $order->quantity * $order->food->price;
@endphp

<p>{{ __('app.emails.hello', ['name' => $order->user->name]) }}</p>

<p>
    {{ __('app.emails.order_placed', [
        'food' => $order->food->title,
        'quantity' => $order->quantity,
        'total' => number_format($total, 2),
    ]) }}
</p>

<p>{{ __('app.emails.current_status', ['status' => __('app.statuses.' . $order->status)]) }}</p>
