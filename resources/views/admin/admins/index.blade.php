@extends('admin.layouts.master')

@section('title', 'Admin Users')

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
    <a href="javascript::void(0);" class="nav-link">Admin Users</a>
</li>
@endsection

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Admin Users</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Home</a></li>
                    <li class="breadcrumb-item active">Admin Users</li>
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
                    <div class="card-body">
                        <div class="row">

                            <div class="col-md-6">
                                <div class="form-group">
                                    {!! Form::select('role_id', ['' => 'Select Role'] + $roles, '', ['id' => 'role_id', 'data-toggle' => 'tooltip', 'class' => 'form-control select2', 'data-placement' => 'top', 'title' => 'Select Role']) !!}
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="text" class="form-control" id="text_search" name="text_search" placeholder="Admin Users Search">
                                </div>
                            </div>

                            <div class="col-md-2 float">
                                <button type="button" id="search_button" class="btn btn-primary" style="width: 100%"><i class="fas fa-search"></i></button>
                            </div>

                            <div class="col-md-2 float">
                                <button type="button" id="reset_button" class="btn btn-secondary" style="width: 100%">Reset</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Admin Users</h3>
                        @can('create-admins')
                        <div class="float-right">
                            <a href="{{ route('admin.admins.create') }}"><button class="btn btn-primary"><i class="fa fa-plus"></i> Create Admin User</button></a>
                        </div>
                        @endcan()
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="admins_table" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    {{-- <th>ID</th> --}}
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    {{-- <th>ID</th> --}}
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Role</th>
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
        var showURL = '{{ route('admin.admins.show', ['admin'=>'#id']) }}';
        var editURL = '{{ route('admin.admins.edit', ['admin'=>'#id']) }}';

        var table = $('#admins_table').DataTable({
            processing: true
            , searching: true
            , serverSide: true
            , responsive: true
            , ajax: "{{ route('admin.admins.index') }}"
            , columns: [
                // {
                //     data: 'id'
                //     , name: 'id'
                // }, 
                {
                    data: 'name'
                    , name: 'name'
                }
                , {
                    data: 'email'
                    , name: 'email'
                }
                , {
                    data: 'role_name'
                    , name: 'role_name'
                }
                , {
                    "data": "action"
                    , "name": "action"
                    , orderable: false
                    , searchable: false
                    , fnCreatedCell: function(nTd, sData, oData, iRow, iCol) {
                        var html = "";

                        @can('show-admins')
                        html += "<a title='View' data-placement='top' href='" + showURL.replace('#id', oData.id) + "' class='btn btn-info btn-sm'><i class='fa fa-eye'></i></a>&nbsp;";
                        @endcan

                        @can('edit-admins')
                        html += "<a title='Edit' data-placement='top' href='" + editURL.replace('#id', oData.id) + "' class='btn btn-info btn-sm'><i class='fas fa-pencil-alt'></i></a>&nbsp;";
                        @endcan

                        $(nTd).html("<span class='action-column'>" + html + "</span>");
                    }
                }
            , ]
        });

        $('#search_button').click(function() {
            table.search($("#text_search").val());
            table.columns(2).search($("#role_id").val());
            table.draw();
        });
    });

    $('#reset_button').on('click', function() {
        $("#role_id").val("");
        $("#text_search").val("");
        $('#search_button').trigger('click');
    });

</script>
@endsection
