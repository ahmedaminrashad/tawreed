<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>@yield('title')</title>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">

@if(app()->getLocale() == 'ar')
<link href="{{ asset('/assets/front/css/bootstrap.css') }}" rel="stylesheet">
<link href="{{ asset('/assets/front/css/bootstrap_rtl.css') }}" rel="stylesheet">
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
