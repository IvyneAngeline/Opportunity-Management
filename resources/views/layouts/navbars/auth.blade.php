<div class="sidebar" data-color="white" data-active-color="danger">
    <div class="logo">
        <a href="http://www.creative-tim.com" class="simple-text logo-mini">
            <div class="logo-image-small">
                <img src="{{ asset('paper') }}/img/logo-small.png">
            </div>
        </a>
        <a href="http://www.creative-tim.com" class="simple-text logo-normal">
            {{ __('D-system') }}
        </a>
    </div>
    <div class="sidebar-wrapper">
        <ul class="nav">
            <li class="{{ $elementActive == 'dashboard' ? 'active' : '' }}">
                <a href="{{ route('page.index', 'dashboard') }}">
                    <i class="nc-icon nc-bank"></i>
                    <p>{{ __('Dashboard') }}</p>
                </a>
            </li>

            <li class="{{ $elementActive == 'user' ? 'active' : '' }}">
                @if(\Illuminate\Support\Facades\Auth::user()->account_type=="admin")
                <a href="{{ route('user.index', 'user') }}">
                    <i class="nc-icon nc-circle-10"></i>
                    <p>{{ __('Users') }}</p>
                </a>
                @endif
            </li>
            <li class="{{ $elementActive == 'admin' ? 'active' : '' }}">
                @if(\Illuminate\Support\Facades\Auth::user()->account_type=="admin")
                    <a href="{{ route('admin', 'admin') }}">
                        <i class="nc-icon nc-circle-10"></i>
                        <p>{{ __('Administrators') }}</p>
                    </a>
                @endif
            </li>

            <li class="{{ $elementActive == 'posts' ? 'active' : '' }}">
                <a href="{{ route('post.index', 'posts') }}">
                    <i class="nc-icon nc-paper"></i>
                    <p>{{ __('Resources') }}</p>
                </a>
            </li>

        </ul>
    </div>
</div>
