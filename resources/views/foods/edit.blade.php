<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="{{ asset('style.css') }}">

<div class="container">
    @include('partials.language-switcher')

    <h1>{{ __('app.edit_food') }}</h1>

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
        <form action="/foods/{{ $food->id }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <input type="text" name="title" value="{{ old('title', $food->title) }}">

            <textarea name="description">{{ old('description', $food->description) }}</textarea>

            <input type="number" step="0.01" name="price" value="{{ old('price', $food->price) }}" placeholder="{{ __('app.price') }}">

            <input type="number" name="quantity" value="{{ old('quantity', $food->quantity) }}" placeholder="{{ __('app.quantity') }}">

            @if($food->image)
                <img src="{{ asset('storage/' . $food->image) }}" alt="{{ $food->title }}" class="food-image-preview">
            @endif

            <input type="file" name="image" accept="image/*">

            <button type="submit">{{ __('app.update') }}</button>
        </form>
    </div>
</div>
