@section('footer')
<!-- plugins:js -->
<script src={{ asset('vendors/js/vendor.bundle.base.js') }}></script>
<!-- endinject -->
<!-- Plugin js for this page -->
<script src={{ asset('vendors/chart.js/Chart.min.js') }}></script>
<script src={{ asset('vendors/progressbar.js/progressbar.min.js') }}></script>
<script src={{ asset('vendors/jvectormap/jquery-jvectormap.min.js') }}></script>
<script src={{ asset('vendors/jvectormap/jquery-jvectormap-world-mill-en.js') }}></script>
<script src={{ asset('vendors/owl-carousel-2/owl.carousel.min.js') }}></script>
<script src={{ asset('js/datatables.min.js') }}></script>
<!-- End plugin js for this page -->
<!-- inject:js -->
<script src={{ asset('js/off-canvas.js') }}></script>
<script src={{ asset('js/hoverable-collapse.js') }}></script>
<script src={{ asset('js/settings.js') }}></script>
<!-- endinject -->
@endsection