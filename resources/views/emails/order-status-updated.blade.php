<p>{{ __('app.emails.hello', ['name' => $order->user->name]) }}</p>

<p>
    {{ __('app.emails.status_updated', ['food' => $order->food->title]) }}
    <strong>{{ __('app.statuses.' . $order->status) }}</strong>.
</p>

<p>{{ __('app.quantity') }}: {{ $order->quantity }}</p>
