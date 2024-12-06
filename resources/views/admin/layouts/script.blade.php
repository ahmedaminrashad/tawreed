<!-- jQuery -->
<script src="{{ asset('/assets/adminlte/plugins/jquery/jquery.min.js') }}"></script>
<!-- jQuery UI 1.11.4 -->
<script src="{{ asset('/assets/adminlte/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
    $.widget.bridge('uibutton', $.ui.button)

</script>
<!-- Bootstrap 4 -->
<script src="{{ asset('/assets/adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- ChartJS -->
<script src="{{ asset('/assets/adminlte/plugins/chart.js/Chart.min.js') }}"></script>
<!-- Sparkline -->
<script src="{{ asset('/assets/adminlte/plugins/sparklines/sparkline.js') }}"></script>
<!-- JQVMap -->
{{-- <script src="{{ asset('/assets/adminlte/plugins/jqvmap/jquery.vmap.min.js') }}"></script>
<script src="{{ asset('/assets/adminlte/plugins/jqvmap/maps/jquery.vmap.usa.js') }}"></script> --}}
<!-- jQuery Knob Chart -->
<script src="{{ asset('/assets/adminlte/plugins/jquery-knob/jquery.knob.min.js') }}"></script>
<!-- daterangepicker -->
<script src="{{ asset('/assets/adminlte/plugins/moment/moment.min.js') }}"></script>
<script src="{{ asset('/assets/adminlte/plugins/daterangepicker/daterangepicker.js') }}"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="{{ asset('/assets/adminlte/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
<!-- Summernote -->
<script src="{{ asset('/assets/adminlte/plugins/summernote/summernote-bs4.min.js') }}"></script>
<!-- overlayScrollbars -->
<script src="{{ asset('/assets/adminlte/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('/assets/adminlte/dist/js/adminlte.js') }}"></script>
<!-- AdminLTE for demo purposes -->
{{-- <script src="{{ asset('/assets/adminlte/dist/js/demo.js') }}"></script> --}}
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
{{-- <script src="{{ asset('/assets/adminlte/dist/js/pages/dashboard.js') }}"></script> --}}
{{-- <script src="{{ asset('/assets/adminlte/dist/js/adminlte.min.js') }}"></script> --}}
<script src="{{ asset('/assets/adminlte/plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>

{{-- custom JS --}}
<script src="{{ asset('/assets/js/custom.js') }}"></script>

<!-- Bootstrap4 Duallistbox -->
<script src="{{ asset('/assets/adminlte/plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js') }}"></script>

<!-- Select2 -->
<script src="{{ asset('/assets/adminlte/plugins/select2/js/select2.full.min.js') }}"></script>

<script>
    // const authedId = "{{ auth()?-> user()?-> id ?? null }}";
    // const baseUrl = "{{ url('/') }}";
    // $(function() {
    //     bsCustomFileInput.init();
    // });

</script>

@yield('pagejs')
