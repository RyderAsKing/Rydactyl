@include('layout.header')
@include('layout.sidebar')
@include('layout.navbar')
@include('layout.footer')

<html lang="en">
    @yield('header')

    <body>
        <div class="container-scroller">
            @yield('sidebar')
            <div class="container-fluid page-body-wrapper">
                @yield('navbar')
                @yield('content')
            </div>
            @yield('footer')
    </body>

</html>