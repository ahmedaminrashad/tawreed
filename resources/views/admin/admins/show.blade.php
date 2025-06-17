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
    @include('admin.layouts.flash_msg')

    <div class="container-fluid">
        <div class="row">
            <div class="col-8">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title" style="margin-top: 3px">{{ $admin->name }}</h3>

                        <div class="card-tools">
                            @can('edit-admins')
                            {{-- <div class="input-group input-group-sm">
                                <a href="{{route('admin.admins.reset.password',['admin' => $admin->id])}}" class="btn btn-success float-right">
                            <i class="fa fa-edit"></i>
                            Reset Password
                            </a>
                        </div> --}}
                        <div class="input-group input-group-sm">
                            <button type="button" class="btn btn-default mr-3" data-toggle="modal" data-target="#reset-password-modal"  data-keyboard="false">
                                Reset Password
                            </button>

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
                                <td>{{ $admin->created_date }}</td>
                            </tr>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-4">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Admin Image Preview</h3>
                </div>
                <div class="card-body" style="height: 365px">
                    <div class="row">
                        <div class="col-md-12">
                            @if ($admin->image)
                            <img id="image_preview" src="{{ asset('assets/uploads/admins/' . $admin->id . '/images/' . $admin->image) }}" alt="Admin Image">
                            @else
                            <img id="image_preview" src="{{ asset('/assets/images/image_preview.png') }}" alt="Admin Image">
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
</section>

<div class="modal fade" id="reset-password-modal">
    <form action="{{ route('admin.admins.reset.password',['admin' => $admin->id]) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Reset Password</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="old_password">Old Password</label>
                                <input type="password" class="form-control" name="old_password" id="old_password" placeholder="Enter Old Password">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="password">New Password</label>
                                <input type="password" class="form-control" name="password" id="password" placeholder="Enter Password">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="password_confirmation">Confirm Password</label>
                                <input type="password" class="form-control" name="password_confirmation" id="password_confirmation" placeholder="Enter Password Confirmation">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Update Password</button>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@section('pagejs')

<!-- Page specific script -->
<script>
    $(function() {});

</script>
@endsection
