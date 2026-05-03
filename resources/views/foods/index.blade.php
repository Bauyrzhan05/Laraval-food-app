<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="{{ asset('style.css') }}">

<div class="container">
    @include('partials.language-switcher')

    <h1>{{ __('app.food_list') }}</h1>

    <div style="margin-bottom: 15px; padding: 10px; background: #f0f0f0; border-radius: 5px;">
        @auth
            <strong>{{ __('app.logged_in_as') }}:</strong> {{ auth()->user()->name }}
            ({{ __('app.role') }}: {{ auth()->user()->getRoleNames()->first() ?? __('app.none') }})

            @can('order-list-own')
                | <a href="/my-orders">{{ __('app.my_orders') }}</a>
            @endcan

            @can('order-list-all')
                | <a href="/orders">{{ __('app.all_orders') }}</a>
            @endcan

            <form action="{{ route('logout.perform') }}" method="POST" style="display: inline-block; margin-top: 0;">
                @csrf
                <button type="submit" class="btn-link">{{ __('app.logout') }}</button>
            </form>
        @else
            <strong>{{ __('app.not_logged_in') }}</strong>
            <a href="{{ route('login') }}">{{ __('app.login') }}</a> |
            <a href="{{ route('register') }}">{{ __('app.register') }}</a>
        @endauth
    </div>

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

    @can('food-create')
        <a href="/foods/create" class="btn btn-add">+ {{ __('app.add_food') }}</a>
    @endcan

    @foreach($foods as $food)
        <div class="card">
            @if($food->image)
                <img src="{{ asset('storage/' . $food->image) }}" alt="{{ $food->title }}" class="food-image">
            @endif

            <h3>{{ $food->title }}</h3>
            <p>{{ $food->description }}</p>

            <p><strong>{{ __('app.price') }}:</strong> ${{ $food->price }}</p>
            <p><strong>{{ __('app.available') }}:</strong> {{ $food->quantity }}</p>

            @auth
                @can('order-create')
                    @if($food->quantity > 0)
                        <form action="/orders/{{ $food->id }}" method="POST" style="margin-top: 10px;">
                            @csrf
                            <label>{{ __('app.quantity') }}:</label>
                            <input type="number" name="quantity" min="1" max="{{ $food->quantity }}" value="1">
                            <button type="submit" class="btn btn-add">{{ __('app.order') }}</button>
                        </form>
                    @else
                        <p style="color: red;"><strong>{{ __('app.out_of_stock') }}</strong></p>
                    @endif
                @endcan
            @endauth

            @can('food-edit')
                <a href="/foods/{{ $food->id }}/edit" class="btn btn-edit">{{ __('app.edit_food') }}</a>
            @endcan

            @role('admin')
                <form action="/foods/{{ $food->id }}" method="POST" style="margin-top: 10px;">
                    @csrf
                    @method('DELETE')
                    <button class="btn-delete">{{ __('app.delete') }}</button>
                </form>
            @endrole
        </div>
    @endforeach
</div>
