<aside class="col-md-4 col-xs-12 hidden-xs hidden-sm">
    <ul>
        <li @if($active == 'profile') class="active" @endif><a href="{{ route('profile.index') }}"><img src="{{ asset('/assets/front/img/17.svg') }}"> My Profile</a></li>
        <li @if($active == 'tenders') class="active" @endif><a href="javascript:void(0);"><img src="{{ asset('/assets/front/img/18.svg') }}"> My Tenders</a></li>
        <li @if($active == 'proposals') class="active" @endif><a href="javascript:void(0);"><img src="{{ asset('/assets/front/img/19.svg') }}"> My Proposals</a></li>
        <li @if($active == 'messages') class="active" @endif><a href="javascript:void(0);"><img src="{{ asset('/assets/front/img/20.svg') }}"> Messages</a></li>
        <li @if($active == 'wallet') class="active" @endif><a href="javascript:void(0);"><img src="{{ asset('/assets/front/img/21.svg') }}"> Wallet</a></li>
        <li @if($active == 'feedback') class="active" @endif><a href="javascript:void(0);"><img src="{{ asset('/assets/front/img/22.svg') }}"> Feedback</a></li>
        <li @if($active == 'settings') class="active" @endif><a href="{{ route('profile.settings.index') }}"><img src="{{ asset('/assets/front/img/23.svg') }}"> Settings</a></li>
        <li><a class="link-style" data-toggle="modal" data-target="#logout"><img src="{{ asset('/assets/front/img/24.svg') }}"> Logout </a></li>
    </ul>
</aside>

<div id="logout" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <h3>Logout</h3>
            <span class="close" data-dismiss="modal"><i class="ri-close-line"></i></span>
            <img src="{{ asset('/assets/front/img/35.svg') }}">
            <h1>Are you sure you want to log out</h1>
            <p>We look forward to seeing you again soon!</p>
            <ul>
                <li><a href="javascript:void(0);" data-dismiss="modal">Cancel</a></li>
                <li>
                    <a class="link-style" id="logout-btn">Log out</a>
                </li>
                <form id="profile_logout_form" method="POST" action="{{ route('logout') }}">
                    @csrf
                </form>
            </ul>
        </div>
    </div>
</div>