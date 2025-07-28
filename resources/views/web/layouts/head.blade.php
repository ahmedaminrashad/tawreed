<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>@yield('title')</title>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">

<style>
    body {

        min-height: 100vh;
        background-color: #f4f4f4;
    }

    .gallery {
        display: flex;
        gap: 10px;
    }

    .gallery-item {
        width: 150px;
        height: 100px;
        object-fit: cover;
        cursor: pointer;
        border: 2px solid #ddd;
        border-radius: 5px;
        transition: transform 0.3s;
    }

    .gallery-item:hover {
        transform: scale(1.1);
    }

    #lightbox {
        text-align: center;
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.8);
        justify-content: center;
        align-items: center;
        z-index: 999;
    }

    #lightbox img {
        max-width: 90%;
        max-height: 80%;
    }

    .close {
        position: absolute;
        top: 20px;
        right: 30px;
        font-size: 30px;
        color: white;
        cursor: pointer;
    }

</style>
@if(app()->getLocale() == 'ar')
<link href="{{ asset('/assets/front/css/bootstrap.css') }}" rel="stylesheet">
<link href="{{ asset('/assets/front/css/bootstrap-rtl.css') }}" rel="stylesheet">
<link href="{{ asset('/assets/front/css/style-rtl.css') }}" rel="stylesheet">
@else
<link href="{{ asset('/assets/front/css/bootstrap.css') }}" rel="stylesheet">
<link href="{{ asset('/assets/front/css/style.css') }}" rel="stylesheet">
@endif


<link href="https://cdn.jsdelivr.net/npm/remixicon@4.5.0/fonts/remixicon.css" rel="stylesheet">
<link rel="stylesheet" href="https://code.jquery.com/ui/1.14.1/themes/base/jquery-ui.css">
<link rel="stylesheet" href="{{ asset('/assets/front/css/jquery.uploader.css') }}">
<link rel="icon" type="image/x-icon" href="{{ asset('/assets/front/img/fix-icon.png') }}">

{{-- Custom CSS --}}
<link href="{{ asset('/assets/front/css/custom.css') }}" rel="stylesheet">

@yield('head')
