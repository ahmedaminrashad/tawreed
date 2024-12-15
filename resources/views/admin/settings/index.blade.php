@extends('admin.layouts.master')

@section('title', 'General Settings')

@section('head')
<!-- DataTables -->
<link rel="stylesheet" href="{{ asset('/assets/adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('/assets/adminlte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('/assets/adminlte/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
@endsection

@section('breadcrumb')
<li class="nav-item d-none d-sm-inline-block">
    <a href="{{ route('admin.home') }}" class="nav-link">Home</a>
</li>

<li class="nav-item d-none d-sm-inline-block">
    <a href="javascript::void(0);" class="nav-link">General Settings</a>
</li>
@endsection

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">General Settings</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Home</a></li>
                    <li class="breadcrumb-item active">General Settings</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<section class="content">
    @include('admin.layouts.flash_msg')

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">General Settings</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="settings_table" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Value</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>Name</th>
                                    <th>Value</th>
                                    <th>Action</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>
<!-- /.content -->
@endsection

@section('pagejs')
<!-- DataTables  & Plugins -->
<script src="{{ asset('/assets/adminlte/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('/assets/adminlte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('/assets/adminlte/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('/assets/adminlte/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
<script src="{{ asset('/assets/adminlte/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('/assets/adminlte/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
<script src="{{ asset('/assets/adminlte/plugins/jszip/jszip.min.js') }}"></script>
<script src="{{ asset('/assets/adminlte/plugins/pdfmake/pdfmake.min.js') }}"></script>
<script src="{{ asset('/assets/adminlte/plugins/pdfmake/vfs_fonts.js') }}"></script>
<script src="{{ asset('/assets/adminlte/plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
<script src="{{ asset('/assets/adminlte/plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
<script src="{{ asset('/assets/adminlte/plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>

<!-- Page specific script -->
<script>
    $(function() {

        var showURL = '{{ route('admin.settings.show', ['setting'=>'#id']) }}';
        var editURL = '{{ route('admin.settings.edit', ['setting'=>'#id']) }}';

        var table = $('#settings_table').DataTable({
            processing: true
            , searching: true
            , serverSide: true
            , responsive: true
            , ajax: "{{ route('admin.settings.index') }}"
            , columns: [
                // {
                //     data: 'id'
                //     , name: 'id'
                // }, 
                {
                    data: 'key'
                    , name: 'key'
                }
                , {
                    data: 'value'
                    , name: 'value'
                    , orderable: false
                    , searchable: false
                }
                , {
                    "data": "action"
                    , "name": "action"
                    , orderable: false
                    , searchable: false
                    , fnCreatedCell: function(nTd, sData, oData, iRow, iCol) {
                        var html = "";

                        @can('show-settings')
                        html += "<a title='View' data-placement='top' href='" + showURL.replace('#id', oData.id) + "' class='btn btn-info btn-sm'><i class='fa fa-eye'></i></a>&nbsp;";
                        @endcan

                        @can('edit-settings')
                        html += "<a title='Edit' data-placement='top' href='" + editURL.replace('#id', oData.id) + "' class='btn btn-info btn-sm'><i class='fas fa-pencil-alt'></i></a>&nbsp;";
                        @endcan

                        $(nTd).html("<span class='action-column'>" + html + "</span>");
                    }
                }
            , ]
        });
    });

</script>
@endsection
