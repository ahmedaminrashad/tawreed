@extends('admin.layouts.master')

@section('title', 'Show Activity Classification - ' . $activity_classification->translate('ar')->name)

@section('head')
@endsection

@section('breadcrumb')
<li class="nav-item d-none d-sm-inline-block">
    <a href="{{ route('admin.home') }}" class="nav-link">Home</a>
</li>

<li class="nav-item d-none d-sm-inline-block">
    <a href="{{ route('admin.activity-classifications.index') }}" class="nav-link">Activity Classifications</a>
</li>

<li class="nav-item d-none d-sm-inline-block">
    <a href="javascript::void(0);" class="nav-link">Show Activity Classification - {{ $activity_classification->translate('ar')->name }}</a>
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
                    <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.activity-classifications.index') }}">Classifications</a></li>
                    <li class="breadcrumb-item active">Show Activity Classification - {{ $activity_classification->translate('ar')->name }}</li>
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
            <div class="col-8">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title" style="margin-top: 3px">Show Activity Classification - {{ $activity_classification->translate('ar')->name }}</h3>

                        <div class="card-tools">
                            @can('edit-activity-classifications')
                            <div class="input-group input-group-sm">
                                <a href="{{route('admin.activity-classifications.edit',['activity_classification' => $activity_classification->id])}}" class="btn btn-success float-right">
                                    <i class="fa fa-edit"></i>
                                    Edit
                                </a>
                            </div>
                            @endcan
                        </div>
                    </div>

                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover">

                            <tbody>

                                <tr>
                                    <th class="txt-content">#ID</th>
                                    <td>{{ $activity_classification->id }}</td>
                                </tr>

                                @foreach (config('langs') as $locale => $name)
                                <tr>
                                    <th class="txt-content">{{ $name }} Name</th>
                                    <td>{{ $activity_classification->translate($locale)->name }}</td>
                                </tr>
                                @endforeach

                                <tr>
                                    <th class="txt-content">Created At</th>
                                    <td>{{ $activity_classification->created_date }}</td>
                                </tr>

                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- /.card -->
            </div>
            
        </div>
    </div><!-- /.container-fluid -->
</section>
<!-- /.content -->
@endsection

@section('pagejs')

<!-- Page specific script -->
<script>
    $(function() {});

</script>
@endsection
