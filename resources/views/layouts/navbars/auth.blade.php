<div class="sidebar" data-color="white" data-active-color="danger">
    <div class="logo">
        <a href="http://www.creative-tim.com" class="simple-text logo-mini">
            <div class="logo-image-small">
                <img src="https://i.pinimg.com/originals/9f/92/9f/9f929f6023c10f6311ecc7273f710557.png">
            </div>
        </a>
        <a href="http://www.creative-tim.com" class="simple-text logo-normal">
            {{ __('DM-System') }}
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
                        <i class="nc-icon nc-briefcase-24"></i>
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
            <li class="{{ $elementActive == 'category' ? 'active' : '' }}">
                @if(\Illuminate\Support\Facades\Auth::user()->account_type=="admin")
                    <a href="{{ route('category.index', 'category') }}">
                        <i class="nc-icon nc-bullet-list-67"></i>
                        <p>{{ __('Categories') }}</p>
                    </a>
                @endif
            </li>


        </ul>
    </div>
</div>
