<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="{{ asset('style.css') }}">

<div class="container">
    @include('partials.language-switcher')

    <h1>{{ __('app.all_orders') }}</h1>

    <a href="/foods">&larr; {{ __('app.back_to_foods') }}</a>

    @if(session('success'))
        <div style="background: #d4edda; color: #155724; padding: 10px; margin-bottom: 15px; border-radius: 5px;">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div style="background: #f8d7da; color: #721c24; padding: 10px; margin-bottom: 15px; border-radius: 5px;">
            {{ session('error') }}
        </div>
    @endif

    @foreach($orders as $order)
        <div class="card">
            <h3>{{ $order->food->title }}</h3>
            <p><strong>{{ __('app.user') }}:</strong> {{ $order->user->name }}</p>
            <p><strong>{{ __('app.quantity') }}:</strong> {{ $order->quantity }}</p>
            <p><strong>{{ __('app.status') }}:</strong> {{ __('app.statuses.' . $order->status) }}</p>

            @can('order-status-update')
                <form action="/orders/{{ $order->id }}/status" method="POST">
                    @csrf
                    @method('PUT')

                    <select name="status">
                        <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>{{ __('app.statuses.pending') }}</option>
                        <option value="preparing" {{ $order->status == 'preparing' ? 'selected' : '' }}>{{ __('app.statuses.preparing') }}</option>
                        <option value="on_the_way" {{ $order->status == 'on_the_way' ? 'selected' : '' }}>{{ __('app.statuses.on_the_way') }}</option>
                        <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>{{ __('app.statuses.delivered') }}</option>
                    </select>

                    <button type="submit">{{ __('app.update_status') }}</button>
                </form>
            @endcan
        </div>
    @endforeach
</div>
