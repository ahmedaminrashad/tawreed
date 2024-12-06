@extends('admin.layouts.master')

@section('title', 'Show Admin User - ' . $admin->name)

@section('head')
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
                    <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.admins.index') }}">Admin Users</a></li>
                    <li class="breadcrumb-item active">Show Admin User - {{ $admin->name }}</li>
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
                        <h3 class="card-title" style="margin-top: 3px">{{ $admin->name }}</h3>

                        <div class="card-tools">
                            @can('edit-admins')
                            <div class="input-group input-group-sm">
                                <a href="{{route('admin.admins.edit',['admin' => $admin->id])}}" class="btn btn-success float-right">
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
                                    <td>{{ $admin->id }}</td>
                                </tr>

                                <tr>
                                    <th class="txt-content">Name</th>
                                    <td>{{ $admin->name }}</td>
                                </tr>

                                <tr>
                                    <th class="txt-content">Email</th>
                                    <td>{{ $admin->email }}</td>
                                </tr>

                                <tr>
                                    <th class="txt-content">Role</th>
                                    <td>{{ $admin->adminRole }}</td>
                                </tr>

                                <tr>
                                    <th class="txt-content">Created At</th>
                                    <td>{{ $admin->created_at }}</td>
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
