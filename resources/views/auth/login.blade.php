<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="{{ asset('style.css') }}">

<div class="container">
    @include('partials.language-switcher')

    <h1>{{ __('app.login') }}</h1>

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
        <form action="{{ route('login') }}" method="POST">
            @csrf

            <input type="email" name="email" placeholder="{{ __('app.email') }}" value="{{ old('email') }}">
            <input type="password" name="password" placeholder="{{ __('app.password') }}">

            <label class="checkbox-row">
                <input type="checkbox" name="remember">
                <span>{{ __('app.remember_me') }}</span>
            </label>

            <button type="submit">{{ __('app.login') }}</button>
        </form>

        <p class="auth-link-text">
            {{ __('app.no_account') }} <a href="{{ route('register') }}">{{ __('app.register') }}</a>
        </p>

        <p class="auth-link-text">
            <a href="/foods">{{ __('app.back_to_foods') }}</a>
        </p>
    </div>
</div>
