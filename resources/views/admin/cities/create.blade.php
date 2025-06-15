@extends('admin.layouts.master')

@section('title', $pageTitle)

@section('head')
@endsection

@section('breadcrumb')
<li class="nav-item d-none d-sm-inline-block">
    <a href="{{ route('admin.home') }}" class="nav-link">Home</a>
</li>

<li class="nav-item d-none d-sm-inline-block">
    <a href="{{ route('admin.cities.index') }}" class="nav-link">Countries</a>
</li>

<li class="nav-item d-none d-sm-inline-block">
    <a href="javascript::void(0);" class="nav-link">Create City</a>
</li>
@endsection

@section('content')

<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Countries</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.cities.index') }}">Countries</a></li>
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
        <form method="post" action="{{ route('admin.cities.store') }}">
            @csrf
            <div class="row">
                <div class="col-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">{{ $formTitle }}</h3>
                        </div>

                        @include('admin.layouts.flash_msg')

                        <div class="card-body">
                            <div class="form-group">
                                <label for="country_id">Country</label>
                                <select name="country_id" id="country_id" class="form-control select2" style="width: 100%;">
                                    <option value="">Please select</option>
                                    @foreach($countries as $id => $country)
                                    <option @selected(old('country_id')==$id) value="{{ $id }}">{{ $country }}</option>
                                    @endforeach
                                </select>
                            </div>

                            @foreach (config('langs') as $locale => $name)
                            <div class="form-group">
                                <label for="{{ $locale }}_name">Name in {{ $name }}</label>
                                <input type="text" class="form-control" value="{{ old($locale . '_name') }}" name="{{ $locale }}_name" id="{{ $locale }}_name" placeholder="Enter Name in {{ $name }}">
                            </div>
                            @endforeach
                        </div>

                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary float-right">Submit</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>
@endsection

@section('pagejs')

<!-- Page specific script -->
<script>
    $(function() {
        $('.select2').select2({
            dir: "{{app()->getLocale() == 'ar'?'rtl':'ltr'}}"
        });
    });

</script>
@endsection
