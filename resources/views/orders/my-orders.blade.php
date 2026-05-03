<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="{{ asset('style.css') }}">

<div class="container">
    @include('partials.language-switcher')

    <h1>{{ __('app.my_orders') }}</h1>

    <a href="/foods">&larr; {{ __('app.back_to_foods') }}</a>

    @foreach($orders as $order)
        <div class="card">
            <h3>{{ $order->food->title }}</h3>
            <p><strong>{{ __('app.quantity') }}:</strong> {{ $order->quantity }}</p>
            <p><strong>{{ __('app.status') }}:</strong> {{ __('app.statuses.' . $order->status) }}</p>
            <p><strong>{{ __('app.date') }}:</strong> {{ $order->created_at }}</p>
        </div>
    @endforeach
</div>
