@extends('admin.layouts.master')

@section('title', 'Activity Classifications')

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
    <a href="javascript::void(0);" class="nav-link">Activity Classifications</a>
</li>
@endsection

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Activity Classifications</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Home</a></li>
                    <li class="breadcrumb-item active">Activity Classifications</li>
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
                                    <input type="text" class="form-control" id="text_search" name="text_search" placeholder="Activity Classifications Search">
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
                        <h3 class="card-title">Activity Classifications</h3>
                        @can('create-activity-classifications')
                        <div class="float-right">
                            <a href="{{ route('admin.activity-classifications.create') }}"><button class="btn btn-primary"><i class="fa fa-plus"></i> Create Activity Classification</button></a>
                        </div>
                        @endcan()
                    </div>
                    <div class="card-body">
                        <table id="classifications_table" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Work Category</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>Name</th>
                                    <th>Work Category</th>
                                    <th>Action</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('pagejs')
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

<script>
    $(function() {
        var showURL = '{{ route('admin.activity-classifications.show', ['activity_classification'=>'#id']) }}';
        var editURL = '{{ route('admin.activity-classifications.edit', ['activity_classification'=>'#id']) }}';
		var deleteURL = '{{ route('admin.activity-classifications.destroy', ['activity_classification'=>'#id']) }}';

        var table = $('#classifications_table').DataTable({
            processing: true
            , searching: true
            , serverSide: true
            , responsive: true
            , ajax: "{{ route('admin.activity-classifications.index') }}"
            , columns: [{
                    data: 'ar_name'
                    , name: 'ar_name'
                }
                ,{
                    data: 'work_category.arabic_name'
                }
                , {
                    "data": "action"
                    , "name": "action"
                    , orderable: false
                    , searchable: false
                    , fnCreatedCell: function(nTd, sData, oData, iRow, iCol) {
                        var html = "";

                        @can('show-activity-classifications')
                        html += "<a title='View' data-placement='top' href='" + showURL.replace('#id', oData.id) + "' class='btn btn-info btn-sm'><i class='fa fa-eye'></i></a>&nbsp;";
                        @endcan

                        @can('edit-activity-classifications')
                        html += "<a title='Edit' data-placement='top' href='" + editURL.replace('#id', oData.id) + "' class='btn btn-info btn-sm'><i class='fas fa-pencil-alt'></i></a>&nbsp;";
                        @endcan

                        @can('delete-activity-classifications')
                        var btnIcon = "<i class='fa fa-ban'></i>";
                        var btnTitle = "Delete Activity Classification";
                        var btnClass = "btn-danger";

                        var statusUrl = deleteURL.replace('#id', oData.id);
                        var name = 'Activity Classification #' + oData.id;
                        var title = name.replaceAll(" ", "_");


                        html += "<a title=" + btnTitle + " href='javascript:void(0)' class='edit btn btn-sm delete_classification " + btnClass + "' id=" + oData.id + " label='" + title + "' url='" + statusUrl + "'>" + btnIcon + "</a>";
                        @endcan

                        $(nTd).html("<span class='action-column'>" + html + "</span>");
                    }
                }
            , ]
        });

        $(document).on("click", ".delete_classification", function() {
            var id = $(this).attr("id");

            var url = $(this).attr("url");
            var status = $(this).attr('currentStatus');

            var label = $(this).attr('label');
            var finalLable = label.replaceAll("_", " ");

            var alertMessage = "Are you sure to delete this Activity Classification (<strong>" + finalLable + "</strong>) ?";
            var successMessage = "Activity Classification (<strong>" + finalLable + "</strong>) was deleted successfully";

            var message = " " + alertMessage + " (<B>" + $(this).attr("label") + "</B>) ?";

            warningBox(alertMessage, function() {
                $.ajax({
                    url: url
                    , type: "POST"
                    , data: {_method: "delete", _token :"{{ csrf_token() }}"}
                    , success: function(result) {
                        table.row("#" + id).remove().draw();

                        infoBox(successMessage);
                    }
                });

                // $.post(url, {
                //     "_token": '{{ csrf_token() }}'
                // }, function(data, status) {
                //     table.row("#" + id).remove().draw();

                //     infoBox(successMessage);
                // });
            });

        });

        $('#search_button').click(function() {
            table.search($("#text_search").val());
            table.draw();
        });
    });

    $('#reset_button').on('click', function() {
        $("#text_search").val("");
        $('#search_button').trigger('click');
    });

</script>
@endsection
