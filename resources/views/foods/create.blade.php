<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="{{ asset('style.css') }}">

<div class="container">
    @include('partials.language-switcher')

    <h1>{{ __('app.add_food') }}</h1>

    @if($errors->any())
        <div style="background: #f8d7da; color: #721c24; padding: 10px; margin-bottom: 15px; border-radius: 5px;">
            <ul style="margin: 0; padding-left: 20px;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card">
        <form action="/foods" method="POST" enctype="multipart/form-data">
            @csrf

            <input type="text" name="title" placeholder="{{ __('app.food_name') }}" value="{{ old('title') }}">

            <textarea name="description" placeholder="{{ __('app.description') }}">{{ old('description') }}</textarea>

            <input type="number" step="0.01" name="price" placeholder="{{ __('app.price') }}" value="{{ old('price') }}">

            <input type="number" name="quantity" placeholder="{{ __('app.quantity') }}" value="{{ old('quantity') }}">

            <input type="file" name="image" accept="image/*">

            <button type="submit">{{ __('app.save') }}</button>
        </form>
    </div>
</div>
