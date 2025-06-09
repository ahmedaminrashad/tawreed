<footer class="container-fluid remove-padding">
    <div class="footer-menu container-fluid remove-padding">
        <div class="container">
            <a href="{{ route('home') }}">
                <img src="{{ asset('/assets/front/img/logo2.png') }}">
            </a>
            <ul>
                <li><a href="{{ route('tenders.index') }}">{{ __('web.tenders') }}</a></li>
                <li><a href="{{ route('about') }}">{{ __('web.about_us') }}</a></li>
                <li><a href="{{ route('contact') }}">{{ __('web.contact_us') }}</a></li>
                <li><a href="{{ route('privacy') }}">{{ __('web.privacy_policy') }}</a></li>
                <li><a href="{{ route('terms') }}">{{ __('web.terms_conditions') }}</a></li>
            </ul>
        </div>
    </div>
    <div class="container">
        <div class="col-xs-12 footer-main">
            <div class="col-md-4 col-xs-12">
                <h2>{{ __('web.company_name') }}</h2>
                <p>{{ __('web.footer_description') }}</p>
            </div>
            <div class="col-md-2 col-xs-12">
                <h3>{{ __('web.quick_links') }}</h3>
                <ul>
                    <li><a href="{{ route('about') }}">{{ __('web.about_us') }}</a></li>
                    <li><a href="{{ route('contact') }}">{{ __('web.contact_us') }}</a></li>
                    <li><a href="{{ route('privacy') }}">{{ __('web.privacy_policy') }}</a></li>
                    <li><a href="{{ route('terms') }}">{{ __('web.terms_conditions') }}</a></li>
                </ul>
            </div>
            <div class="col-md-3 col-xs-12">
                <h3>{{ __('web.contact_us') }}</h3>
                <ul>
                    <li><i class="ri-map-pin-line"></i>
                        <p>{{ $address }}</p>
                    </li>
                    <li><i class="ri-mail-line"></i>
                        <p>{{ $email }}</p>
                    </li>
                    <li><i class="ri-phone-line"></i>
                        <p>{{ $phone }}</p>
                    </li>
                </ul>
            </div>
            <div class="col-md-3 col-xs-12">
                <h3>{{ __('web.follow_us') }}</h3>
                <ul>
                    <li><a href="{{ $facebook_link }}" target="blanked"><i class="ri-facebook-fill"></i></a></li>
                    <li><a href="{{ $twitter_link }}" target="blanked"><i class="ri-twitter-fill"></i></a></li>
                    <li><a href="{{ $instagram_link }}" target="blanked"><i class="ri-instagram-fill"></i></a></li>
                    <li><a href="{{ $linkedin_link }}" target="blanked"><i class="ri-linkedin-fill"></i></a></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="container-fluid remove-padding copy-main">
        <div class="container">
            <p>{{ __('web.copyright') }}</p>
            <ul>
                <li><a href="{{ $facebook_link }}" target="blanked"><i class="ri-facebook-fill"></i></a></li>
                <li><a href="{{ $twitter_link }}" target="blanked"><i class="ri-twitter-fill"></i></a></li>
                <li><a href="{{ $instagram_link }}" target="blanked"><i class="ri-instagram-fill"></i></a></li>
                <li><a href="{{ $linkedin_link }}" target="blanked"><i class="ri-linkedin-fill"></i></a></li>
            </ul>
        </div>
    </div>
</footer>