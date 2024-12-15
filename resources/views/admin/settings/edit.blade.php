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
                <div class="col-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">{{ $formTitle }}</h3>
                        </div>
                        <!-- /.card-header -->

                        @include('admin.layouts.flash_msg')

                        <div class="card-body">

                            <div class="form-group">
                                @if($setting->key == 'commission')
                                <label for="value">{{ ucfirst($setting->key) }}</label>
                                <div class="input-group mb-3">
                                    <input type="number" class="form-control" value="{{ $setting->value ?? old('value') }}" name="value" id="value" min="0" max="100">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">%</span>
                                    </div>
                                </div>
                                @elseif($setting->key == 'vat')
                                <label for="value">VAT</label>
                                <div class="input-group mb-3">
                                    <input type="number" class="form-control" value="{{ $setting->value ?? old('value') }}" name="value" id="value" min="0" max="100">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">%</span>
                                    </div>
                                </div>
                                @elseif($setting->key == 'email')
                                <label for="value">Email</label>
                                <div class="input-group mb-3">
                                    <input type="email" class="form-control" value="{{ $setting->value ?? old('value') }}" name="value" id="value">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">@</span>
                                    </div>
                                </div>
                                @elseif($setting->key == 'phone')
                                <label for="value">Phone</label>
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" value="{{ $setting->value ?? old('value') }}" name="value" id="value">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">@</span>
                                    </div>
                                </div>
                                @elseif($setting->key == 'review')
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="value" id="value" value="1" {{ $setting->value ? 'checked' : '' }}>
                                    <label class="form-check-label">{{ ucfirst($setting->key) }}</label>
                                </div>
                                @elseif(str_contains($setting->key, 'link'))
                                <label for="value">{{ ucfirst(str_replace("_link", "", $setting->key)) }}</label>
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" value="{{ $setting->value ?? old('value') }}" name="value" id="value">
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-footer">
                <button type="submit" class="btn btn-primary float-right">Submit</button>
            </div>
        </form>
    </div>
</section>
@endsection

@section('pagejs')

<!-- Page specific script -->
<script>
    $(function() {});

</script>
@endsection
