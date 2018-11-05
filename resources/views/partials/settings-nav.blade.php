<nav class="nav nav-tabs nav-justified instance-nav-list">
        <a class="nav-link home {{ $currentRouteName === 'settings.profile' ? 'active' : '' }}" href="{{ route('settings.profile') }}">{{ __('Profile') }}</a>

        <a class="nav-link home {{ Request::path() === 'settings/users' ? 'active' : '' }}" href="{{ url('settings/users') }}">{{ __('Users') }}</a>

        <a class="nav-link home {{ $currentRouteName === 'settings.api' ? 'active' : '' }}" href="{{ route('settings.api') }}">{{ __('API') }}</a>
</nav>