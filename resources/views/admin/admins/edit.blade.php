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
                <h1 class="m-0">Admin Users</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.admins.index') }}">Admin Users</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.admins.show', ['admin' => $admin]) }}">Admin User - {{ $admin->name }}</a></li>
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
        <form method="post" action="{{ route('admin.admins.update', ['admin' => $admin]) }}" enctype="multipart/form-data">
            @csrf
            @method('put')

            <div class="row">
                <div class="col-8">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">{{ $formTitle }}</h3>
                        </div>
                        <!-- /.card-header -->

                        @include('admin.layouts.flash_msg')

                        <div class="card-body">
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" class="form-control" value="{{ old('name') ? old('name') : $admin->name }}" name="name" id="name" placeholder="Enter Name">
                            </div>

                            <div class="form-group">
                                <label for="image">Image</label>
                                <div class="custom-file">
                                    <input type="file" name="image" id="image" class="custom-file-input" onchange="readURL(this);" accept="image/*">
                                    <label class="custom-file-label" for="image" id="image_label">
                                        Choose Admin Image
                                    </label>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" value="{{ old('email') ? old('email') : $admin->email }}" name="email" id="email" placeholder="Enter Email">
                            </div>

                            {{-- <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" class="form-control" name="password" id="password" placeholder="Enter Password">
                            </div>

                            <div class="form-group">
                                <label for="password_confirmation">Confirm Password</label>
                                <input type="password" class="form-control" name="password_confirmation" id="password_confirmation" placeholder="Enter Password">
                            </div> --}}

                            <div class="form-group">
                                <label for="role_id">Role</label>

                                @foreach($roles as $key => $role)

                                @endforeach
                                {!! Form::select('role_id', ['' => 'Select Role'] + $roles, $admin->adminRoleId, ['id' => 'role_id', 'data-toggle' => 'tooltip', 'class' => 'form-control select2', 'data-placement' => 'top', 'title' => 'Select Role']) !!}
                            </div>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
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

    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#image_preview').attr('src', e.target.result)
                    .attr('width', '100%')
                    .attr('height', '100%');
            };
            reader.readAsDataURL(input.files[0]);
            $("#image_label").text(input.files[0].name);
        } else {
            $('#image_preview').attr('src', "{{ asset('/assets/images/image_preview.png') }}");
            $("#image_label").text('Choose Admin Image');
        }
    }

</script>
@endsection
