<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Styles -->
    @include('web.layouts.head')
</head>
<body>

<style>
      .review-item td.toggle-collapse.collapsed::after {
    content: "{{__('web.see_more')}}";
  }

  .review-item td.toggle-collapse::after {
    content: "{{__('web.see_less')}}";
  }
</style>
    <!-- Header -->
    @include('web.layouts.header')

    <!-- Content -->
    <div class="container-fluid body remove-padding">
        @yield('content')
    </div>

    <!-- Footer -->
    @include('web.layouts.footer')

    <!-- Scripts -->
    @include('web.layouts.script')
<div id="lightbox">
    <span class="close">&times;</span>
    <img id="lightbox-img" src="" alt="Lightbox Image">
</div>
</body>
</html>
