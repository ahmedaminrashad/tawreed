<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Styles -->
    @include('web.layouts.head')
</head>
<body>

    <!-- Header -->
    @include('web.layouts.header')

    <!-- Content -->
    <div class="container-fluid body">
        @yield('content')
    </div>

    <!-- Footer -->
    @include('web.layouts.footer')

    <!-- Scripts -->
    @include('web.layouts.script')
</body>
</html>
