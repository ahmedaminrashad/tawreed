@extends('admin.layouts.master')

@section('title', $pageTitle)

@section('head')
@endsection

@section('content')

<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Roles</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.roles.index') }}">Roles</a></li>
                    <li class="breadcrumb-item active">{{ $pageAction }}</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <form method="post" action="{{ route('admin.roles.store') }}">
            <div class="row">
                <div class="col-6">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">{{ $formTitle }}</h3>
                        </div>
                        <!-- /.card-header -->

                        @include('admin.layouts.flash_msg')

                        <div class="card-body">
                            @csrf
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" class="form-control" value="{{ old('name') }}" name="name" id="name" placeholder="Enter Role Name">
                            </div>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
            </div>

            <div class="main-content">

                <div class="row">
                    <div class="col-12">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Permissions</h3>
                            </div>

                            <div class="row gutters">
                                @php($card = 0)
                                @foreach($permissionsGroups as $group => $permissions)
                                @if($card>0 && ($card%3)==0)
                            </div>
                            <div class="row gutters">
                                @endif
                                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4">
                                    <div class="card card-success mt-3 ml-3">
                                        <div class="card-header"><i class="icon-lock"></i> {{ $group }}</div>
                                        <div class="card-body">
                                            @foreach($permissions as $id => $name)
                                            <div class="form-check">
                                                <label class="form-check-label">
                                                    <input id="perm-{{ $id }}" name="permissions[]" 
                                                    class="form-check-input permission" type="checkbox" value="{{ $id }}">
                                                    <label for="perm-{{ $id }}">{{ $name }}</label>
                                                </label>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                @php($card = $card + 1)
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary float-right">Submit</button>
            </div>
            <!-- /.card-footer -->
        </form>
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
