<header class="container-fluid remove-padding member-head">
    <span class="mobile-menu-btn visible-xs visible-sm">
        <i class="ri-menu-line"></i>
    </span>
    <div class="container remove-padding">
        <div class="col-md-1">
            <a href="{{ route('home') }}">
                <img src="{{ asset('/assets/front/img/logo.png') }}">
            </a>
        </div>
        <div class="mobile-menu-container">
            <div class="col-md-3 main-menu">
                <ul>
                    <li><a href="{{ route('tenders.index') }}">{{ __('web.tenders') }}</a></li>
                    <li><a href="{{ route('contact') }}">{{ __('web.contact_us') }}</a></li>
                    <li><a href="{{ route('about') }}">{{ __('web.about_us') }}</a></li>
                </ul>
            </div>
            <div class="col-md-4 search-main">
                <form>
                    <span></span>
                    <input type="text" name="search_text" id="search_text" placeholder="{{ __('web.search_placeholder') }}">
                    <select data-minimum-results-for-search="Infinity" class="js-example-basic-single" name="state">
                        <option value="1">{{ __('web.categories') }}</option>
                        <option value="2">{{ __('web.category_1') }}</option>
                        <option value="3">{{ __('web.category_2') }}</option>
                    </select>
                </form>
            </div>
            @if(!auth('web')->check())
            <div class="col-md-3">
                <ul class="side-menu">
                    <li>
                        <a class="link-style" data-toggle="modal" data-target="#logIn">{{ __('web.login') }}</a>
                    </li>
                    <li class="sign-btn">
                        <a class="link-style" data-toggle="modal" data-target="#signUp">{{ __('web.register') }}</a>
                    </li>
                    <li class="dropdown">
                        <button type="button" data-toggle="dropdown">
                            <i class="ri-global-line"></i>
                        </button>
                        <span><i class="ri-arrow-down-s-fill"></i></span>
                        <ul class="dropdown-menu">
                            <li class="{{ app()->getLocale() == 'en' ? 'active' : '' }}">
                                <a href="{{ route('language.switch', 'en') }}">{{ __('web.english') }}</a>
                            </li>
                            <li class="{{ app()->getLocale() == 'ar' ? 'active' : '' }}">
                                <a href="{{ route('language.switch', 'ar') }}">{{ __('web.arabic') }}</a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
            @else
            <div class="col-md-4 member-side">
                <ul>
                    <li><a href="{{ route('tenders.create') }}" class="Create-Tender-btn"><i class="ri-add-circle-line"></i> {{ __('web.create_tender') }}</a></li>
                    <li class="dropdown">
                        <button type="button" data-toggle="dropdown">
                            <i class="ri-global-line"></i>
                        </button>
                        <span><i class="ri-arrow-down-s-fill"></i></span>
                        <ul class="dropdown-menu lang-main">
                            <h3 class="visible-xs visible-sm">{{ __('web.language') }}</h3>
                            <span class="visible-xs visible-sm close-btn">{{ __('web.close') }}</span>

                            <li class="{{ app()->getLocale() == 'en' ? 'active' : '' }}"><a href="{{ route('language.switch', 'en') }}">{{ __('web.english') }}</a></li>
                            <li class="{{ app()->getLocale() == 'ar' ? 'active' : '' }}"><a href="{{ route('language.switch', 'ar') }}">{{ __('web.arabic') }}</a></li>
                        </ul>
                    </li>

                    <li class="dropdown">
                        <button type="button" data-toggle="dropdown">
                            <i class="ri-notification-line"></i>
                            <h6>2</h6>
                        </button>
                        <span><i class="ri-arrow-down-s-fill"></i></span>
                        <ul class="dropdown-menu notification-main">

                            <h3>{{ __('web.notifications') }}</h3>
                            <span class="visible-xs visible-sm close-btn">{{ __('web.close') }}</span>
                            <div class="tabbed">
                                <input type="radio" id="tab1" name="css-tabs" checked>
                                <input type="radio" id="tab2" name="css-tabs">
                                <input type="radio" id="tab3" name="css-tabs">

                                <ul class="tabs">
                                    <li class="tab"><label for="tab1">{{ __('web.all') }}</label></li>
                                    <li class="tab"><label for="tab2">{{ __('web.unread') }}</label></li>
                                    <li class="tab"><label for="tab3">{{ __('web.read') }}</label></li>
                                </ul>

                                <div class="tab-content">
                                    <div class="col-xs-12 remove-padding">
                                        <div class="col-xs-12 remove-padding notification-item">
                                            <img src="{{ asset('/assets/front/img/1.png') }}">
                                            <a href="javascript:void(0);">{{ __('web.verification_request_rejected') }}</a>
                                            <h5>{{ __('web.last_wednesday_at') }}</h5>
                                        </div>
                                        <div class="col-xs-12 remove-padding notification-item unread-notification">
                                            <img src="{{ asset('/assets/front/img/1.png') }}">
                                            <a href="javascript:void(0);">{{ __('web.verification_request_rejected') }}</a>
                                            <h5>{{ __('web.last_wednesday_at') }}</h5>
                                        </div>
                                        <div class="col-xs-12 remove-padding notification-item">
                                            <img src="{{ asset('/assets/front/img/1.png') }}">
                                            <a href="javascript:void(0);">{{ __('web.verification_request_rejected') }}</a>
                                            <h5>{{ __('web.last_wednesday_at') }}</h5>
                                        </div>
                                        <div class="col-xs-12 remove-padding notification-item">
                                            <img src="{{ asset('/assets/front/img/1.png') }}">
                                            <a href="javascript:void(0);">{{ __('web.verification_request_rejected') }}</a>
                                            <h5>{{ __('web.last_wednesday_at') }}</h5>
                                        </div>
                                    </div>
                                </div>

                                <div class="tab-content">
                                    <div class="col-xs-12 remove-padding notification-item">
                                        <img src="{{ asset('/assets/front/img/1.png') }}">
                                        <a href="javascript:void(0);">{{ __('web.verification_request_rejected') }}</a>
                                        <h5>{{ __('web.last_wednesday_at') }}</h5>
                                    </div>
                                    <div class="col-xs-12 remove-padding notification-item">
                                        <img src="{{ asset('/assets/front/img/1.png') }}">
                                        <a href="javascript:void(0);">{{ __('web.verification_request_rejected') }}</a>
                                        <h5>{{ __('web.last_wednesday_at') }}</h5>
                                    </div>
                                    <div class="col-xs-12 remove-padding notification-item">
                                        <img src="{{ asset('/assets/front/img/1.png') }}">
                                        <a href="javascript:void(0);">{{ __('web.verification_request_rejected') }}</a>
                                        <h5>{{ __('web.last_wednesday_at') }}</h5>
                                    </div>
                                    <div class="col-xs-12 remove-padding notification-item">
                                        <img src="{{ asset('/assets/front/img/1.png') }}">
                                        <a href="javascript:void(0);">{{ __('web.verification_request_rejected') }}</a>
                                        <h5>{{ __('web.last_wednesday_at') }}</h5>
                                    </div>
                                    <div class="col-xs-12 remove-padding notification-item">
                                        <img src="{{ asset('/assets/front/img/1.png') }}">
                                        <a href="javascript:void(0);">{{ __('web.verification_request_rejected') }}</a>
                                        <h5>{{ __('web.last_wednesday_at') }}</h5>
                                    </div>
                                </div>

                                <div class="tab-content">
                                    <div class="col-xs-12 remove-padding notification-item">
                                        <img src="{{ asset('/assets/front/img/1.png') }}">
                                        <a href="javascript:void(0);">{{ __('web.verification_request_rejected') }}</a>
                                        <h5>{{ __('web.last_wednesday_at') }}</h5>
                                    </div>
                                    <div class="col-xs-12 remove-padding notification-item">
                                        <img src="{{ asset('/assets/front/img/1.png') }}">
                                        <a href="javascript:void(0);">{{ __('web.verification_request_rejected') }}</a>
                                        <h5>{{ __('web.last_wednesday_at') }}</h5>
                                    </div>
                                    <div class="col-xs-12 remove-padding notification-item">
                                        <img src="{{ asset('/assets/front/img/1.png') }}">
                                        <a href="javascript:void(0);">{{ __('web.verification_request_rejected') }}</a>
                                        <h5>{{ __('web.last_wednesday_at') }}</h5>
                                    </div>
                                </div>
                            </div>
                        </ul>
                    </li>
                    <li><a href="javascript:void(0);"><i class="ri-message-3-line"></i>
                            <h6>2</h6>
                        </a></li>
                    <li class="dropdown">
                        <button type="button" data-toggle="dropdown">
                            <i class="ri-user-line"></i> {{auth()->user()->full_name}}-
                        </button>
                        <span><i class="ri-arrow-down-s-fill"></i></span>
                        <ul class="dropdown-menu profile-drop">
                            <h3 class="visible-xs visible-sm">{{ __('web.profile') }}</h3>
                            <span class="visible-xs visible-sm close-btn">{{ __('web.close') }}</span>

                            <li><a href="{{ route('profile.index') }}"><i class="ri-user-line"></i> {{ __('web.profile') }}</a></li>
                            <li><a href="{{ route('profile.tenders') }}"><i class="ri-key-fill"></i> {{ __('web.my_tenders') }}</a></li>
                            <li><a href="{{ route('profile.proposals') }}"><i class="ri-article-line"></i> {{ __('web.my_proposals') }}</a></li>
                            <li><a href="{{ route('profile.wallet') }}"><i class="ri-wallet-line"></i> {{ __('web.wallet') }}</a></li>
                            <li><a href="{{ route('profile.settings.index') }}"><i class="ri-settings-2-line"></i> {{ __('web.settings') }}</a></li>
                            <li>
                                <a class="link-style">
                                    <i class="ri-shut-down-line"></i>
                                    <button type="submit" id="logout_btn" class="link-style">{{ __('web.logout') }}</button>
                                    <form id="logout_form" method="POST" action="{{ route('logout') }}">
                                        @csrf
                                    </form>
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
            @endif
        </div>
    </div>
</header>

@include('web.layouts.auth-header')

@yield('header')
