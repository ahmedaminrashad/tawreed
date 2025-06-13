<aside class="col-md-4 col-xs-12 hidden-xs hidden-sm">
    <ul>
        <li @if($active == 'profile') class="active" @endif><a href="{{ route('profile.index') }}"><img src="{{ asset('/assets/front/img/17.svg') }}"> {{ __('web.profile') }}</a></li>
        <li @if($active == 'tenders') class="active" @endif><a href="{{ route('profile.tenders') }}"><img src="{{ asset('/assets/front/img/18.svg') }}"> {{ __('web.my_tenders') }}</a></li>
        <li @if($active == 'proposals') class="active" @endif><a href="{{ route('profile.proposals') }}"><img src="{{ asset('/assets/front/img/19.svg') }}"> {{ __('web.my_proposals') }}</a></li>
        <li @if($active == 'messages') class="active" @endif><a href="javascript:void(0);"><img src="{{ asset('/assets/front/img/20.svg') }}"> Messages</a></li>
        <li @if($active == 'wallet') class="active" @endif><a href="{{ route('profile.wallet') }}"><img src="{{ asset('/assets/front/img/21.svg') }}"> {{ __('web.wallet') }}</a></li>
        <li @if($active == 'feedback') class="active" @endif><a href="javascript:void(0);"><img src="{{ asset('/assets/front/img/22.svg') }}"> Feedback</a></li>
        <li @if($active == 'settings') class="active" @endif><a href="{{ route('profile.settings.index') }}"><img src="{{ asset('/assets/front/img/23.svg') }}"> {{ __('web.settings') }}</a></li>
        <li><a class="link-style" data-toggle="modal" data-target="#logout"><img src="{{ asset('/assets/front/img/24.svg') }}"> {{ __('web.logout') }}</a></li>
    </ul>
</aside>

<div id="logout" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <h3>{{ __('web.logout') }}</h3>
            <span class="close" data-dismiss="modal"><i class="ri-close-line"></i></span>
            <img src="{{ asset('/assets/front/img/35.svg') }}">
            <h1>الملف الشخصي</h1>
            <p>موليت في لابوروم تيمبور لوريم إنسيديدونت إيرور. أوتي إيو إكس أد سونت. بارياتور سينت كولبا دو إنسيديدونت إيوسمود إيوسمود كولبا. لابوروم تيمبور لوريم إنسيديدونت.</p>
            <ul>
                <li><a href="javascript:void(0);" data-dismiss="modal">{{ __('web.close') }}</a></li>
                <li>
                    <a class="link-style" id="logout-btn">{{ __('web.logout') }}</a>
                </li>
                <form id="profile_logout_form" method="POST" action="{{ route('logout') }}">
                    @csrf
                </form>
            </ul>
        </div>
    </div>
</div>