<footer class="container-fluid remove-padding">
    <div class="footer-menu container-fluid remove-padding">
        <div class="container">
            <a href="{{ route('home') }}">
                <img src="{{ asset('/assets/front/img/logo2.png') }}">
            </a>
            <ul>
                <li><a href="{{ route('tenders.index') }}">Tenders</a></li>
                <li><a href="{{ route('about') }}">About us</a></li>
                <li><a href="{{ route('contact') }}">Contact us</a></li>
                <li><a href="{{ route('privacy') }}">Privacy Policy</a></li>
                <li><a href="{{ route('terms') }}">Terms & Conditions</a></li>
            </ul>
        </div>
    </div>
    <div class="container-fluid remove-padding copy-main">
        <div class="container">
            <p>© 2024 QuoTech. All rights reserved.</p>
            <ul>
                <li><a href="{{ $facebook_link }}" target="blanked"><i class="ri-facebook-fill"></i></a></li>
                <li><a href="{{ $twitter_link }}" target="blanked"><i class="ri-twitter-x-line"></i></a></li>
                <li><a href="{{ $instagram_link }}" target="blanked"><i class="ri-instagram-fill"></i></a></li>
                <li><a href="{{ $linkedin_link }}" target="blanked"><i class="ri-linkedin-fill"></i></a></li>
            </ul>
        </div>
    </div>
</footer>