@extends('admin.layouts.master')

@section('title', 'Show Documentation - ' . $documentation->key)

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
                    <li class="breadcrumb-item active">Show Documentation - {{ $documentation->key }}</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title" style="margin-top: 3px">Show Documentation - {{ $documentation->key }}</h3>

                        <div class="card-tools">
                            @can('edit-documentations')
                            <div class="input-group input-group-sm">
                                <a href="{{ route('admin.documentations.edit',['documentation' => $documentation->id]) }}" class="btn btn-success float-right">
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
                                    <td>{{ $documentation->id }}</td>
                                </tr>

                                @foreach (config('langs') as $locale => $name)
                                <tr>
                                    <th class="txt-content">{{ $name }} Page</th>
                                    <td>{!! $documentation->translate($locale)->page !!}</td>
                                </tr>
                                @endforeach

                                <tr>
                                    <th class="txt-content">Created At</th>
                                    <td>{{ $documentation->created_date }}</td>
                                </tr>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('pagejs')

<script>
    $(function() {});

</script>
@endsection
