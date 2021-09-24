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
                <a href="{{ route('home', 'dashboard') }}">
                    <i class="nc-icon nc-bank"></i>
                    <p>{{ __('Home') }}</p>
                </a>
            </li>


            <li class="{{ $elementActive == 'account' ? 'active' : '' }}">
                    <a href="{{ route('account.index', 'account') }}">
                        <i class="nc-icon nc-bullet-list-67"></i>
                        <p>{{ __('Accounts') }}</p>
                    </a>

            </li>
            <li class="{{ $elementActive == 'opportunity' ? 'active' : '' }}">
                <a href="{{ route('opportunity.index', 'opportunity') }}">
                    <i class="nc-icon nc-bullet-list-67"></i>
                    <p>{{ __('Opportunity') }}</p>
                </a>

            </li>



        </ul>
    </div>
</div>
