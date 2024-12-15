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
                <h1 class="m-0">Documentations</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.documentations.index') }}">Documentations</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.documentations.show', ['documentation' => $documentation]) }}">Documentation - {{ $documentation->key }}</a></li>
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
        <form method="post" action="{{ route('admin.documentations.update', ['documentation' => $documentation]) }}">
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
                            @foreach (config('langs') as $locale => $name)
                            <label for="{{ $locale }}_name">Page in {{ $name }}</label>
                            <div class="form-group">
                                
                                <textarea name="{{ $locale }}_page" id="{{ $locale }}_name" class="page" cols="100" rows="10">{{old($locale . '_page') ?? $documentation->translate('ar')?->page }}</textarea>
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

<script>
    $(function() {
        // Summernote
        $('.page').summernote()
    });

</script>
@endsection
