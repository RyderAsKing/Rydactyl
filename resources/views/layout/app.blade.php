@include('layout.header')
@include('layout.footer')
<html lang="en">
    @yield('header')

    <body>
        @yield('navbar')
        @yield('content')

        @yield('footer')
    </body>

</html>