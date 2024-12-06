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
                <h1 class="m-0">General Settings</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.settings.index') }}">General Settings</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.settings.show', ['setting' => $setting]) }}">Setting - {{ $setting->key }}</a></li>
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
        <form method="post" action="{{ route('admin.settings.update', ['setting' => $setting]) }}">
            @csrf
            @method('put')

            <div class="row">
                <div class="col-6">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">{{ $formTitle }}</h3>
                        </div>
                        <!-- /.card-header -->

                        @include('admin.layouts.flash_msg')

                        <div class="card-body">
                            {{-- <div class="form-group">
                                <label for="group">Group</label>
                                <span class="form-control" id="group">{{ $setting->group }}</span>
                            </div>

                            <div class="form-group">
                                <label for="key">Key</label>
                                <span class="form-control" id="key">{{ $setting->key }}</span>
                            </div> --}}

                            <div class="form-group">
                                <label for="value">{{ $setting->key }}</label>
                                <input type="{{ $setting->key ? 'email' : 'text' }}" class="form-control" value="{{ $setting->value ?? old('value') }}" name="value" id="value" placeholder="Enter Value">
                            </div>

                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
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
