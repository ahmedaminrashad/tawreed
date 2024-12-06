@extends('admin.layouts.master')

@section('title', 'Show Setting - ' . $setting->key)

@section('head')
@endsection

@section('content')

<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Settings</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.settings.index') }}">Settings</a></li>
                    <li class="breadcrumb-item active">Show Setting - {{ $setting->key }}</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-8">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title" style="margin-top: 3px">{{ $setting->key }}</h3>

                        <div class="card-tools">
                            @can('edit-settings')
                            <div class="input-group input-group-sm">
                                <a href="{{route('admin.settings.edit',['setting' => $setting->id])}}" class="btn btn-success float-right">
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
                                    <td>{{ $setting->id }}</td>
                                </tr>

                                {{-- <tr>
                                    <th class="txt-content">Key</th>
                                    <td>{{ $setting->key }}</td>
                                </tr> --}}

                                <tr>
                                    <th class="txt-content">{{ $setting->key }}</th>
                                    <td>{{ $setting->value }}</td>
                                </tr>

                                {{-- <tr>
                                    <th class="txt-content">Group</th>
                                    <td>{{ $setting->group }}</td>
                                </tr> --}}

                                <tr>
                                    <th class="txt-content">Created At</th>
                                    <td>{{ $setting->created_at }}</td>
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
