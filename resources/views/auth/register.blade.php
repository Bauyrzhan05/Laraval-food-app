<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="{{ asset('style.css') }}">

<div class="container">
    @include('partials.language-switcher')

    <h1>{{ __('app.register') }}</h1>

    @if($errors->any())
        <div style="background: #f8d7da; color: #721c24; padding: 10px; margin-bottom: 15px; border-radius: 5px;">
            <ul style="margin: 0; padding-left: 20px;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card auth-card">
        <form action="{{ route('register') }}" method="POST">
            @csrf

            <input type="text" name="name" placeholder="{{ __('app.name') }}" value="{{ old('name') }}">
            <input type="email" name="email" placeholder="{{ __('app.email') }}" value="{{ old('email') }}">
            <input type="password" name="password" placeholder="{{ __('app.password') }}">
            <input type="password" name="password_confirmation" placeholder="{{ __('app.confirm_password') }}">

            <button type="submit">{{ __('app.register') }}</button>
        </form>

        <p class="auth-link-text">
            {{ __('app.has_account') }} <a href="{{ route('login') }}">{{ __('app.login') }}</a>
        </p>

        <p class="auth-link-text">
            <a href="/foods">{{ __('app.back_to_foods') }}</a>
        </p>
    </div>
</div>
