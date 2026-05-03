<div class="language-switcher">
    <span>{{ __('app.language') }}:</span>

    @foreach(config('app.supported_locales', ['en']) as $locale)
        <a
            href="{{ route('locale.switch', $locale) }}"
            class="{{ app()->getLocale() === $locale ? 'active' : '' }}"
        >
            {{ __('app.locales.' . $locale) }}
        </a>
    @endforeach
</div>
