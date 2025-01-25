@extends('web.layouts.master')

@section('title', 'Contact us')

@section('content')
<div class="container-fluid body remove-padding">

    <div class="container stie-map">
        <ul>
            <li><a href="{{ route('contact') }}">Home</a></li>
            <li><span>/</span></li>
            <li>
                <p>Contact us</p>
            </li>
        </ul>
    </div>

    <div class="container remove-padding about-main">
        <div class="col-xs-12 contact-section">

            <h1>Contact us</h1>

            <p>
                Enim tempor eget pharetra facilisis sed maecenas adipiscing. Eu leo molestie vel, ornare non id blandit netus.
            </p>

            <div class="col-xs-12 remove-padding">
                <a href="tel:{{ $phone }}"><span><i class="ri-whatsapp-line"></i></span> {{ $phone }}</a>
                <br>
                <a href="mailto:{{ $email }}"><span><i class="ri-mail-open-line"></i></span> {{ $email }}</a>
            </div>

            <ul class="col-xs-12 remove-padding">
                <li><a href="{{ $facebook_link }}" target="blanked"><i class="ri-facebook-fill"></i></a></li>
                <li><a href="{{ $twitter_link }}" target="blanked"><i class="ri-twitter-x-line"></i></a></li>
                <li><a href="{{ $instagram_link }}" target="blanked"><i class="ri-instagram-fill"></i></a></li>
                <li><a href="{{ $linkedin_link }}" target="blanked"><i class="ri-linkedin-fill"></i></a></li>
            </ul>
        </div>
    </div>
</div>
@endsection

@section('script')

<script type="text/javascript">
    $(document).ready(function() {});

</script>

@endsection
