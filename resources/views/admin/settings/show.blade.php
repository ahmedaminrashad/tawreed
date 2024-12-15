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
            </div>
        </div>
    </div>
</div>

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

                                <tr>
                                    <th class="txt-content">{{ ucfirst($setting->key) }}</th>
                                    <td>
                                        @if($setting->key == 'commission' || $setting->key == 'vat')
                                        {{ $setting->value }} %
                                        @elseif($setting->key == 'email')
                                        <a href="mailto::{{ $setting->value }}">{{ $setting->value }}</a>
                                        @elseif($setting->key == 'phone')
                                        <a href="tel::{{ $setting->value }}">{{ $setting->value }}</a>
                                        @elseif($setting->key == 'review')
                                        @if($setting->value)
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" disabled checked>
                                            <label class="form-check-label">Yes</label>
                                        </div>
                                        @else
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" disabled>
                                            <label class="form-check-label">No</label>
                                        </div>
                                        @endif
                                        @elseif(str_contains($setting->key, 'link'))
                                        <a href="tel::{{ $setting->value }}" target="blanked">{{ $setting->value }}</a>
                                        @endif
                                    </td>
                                </tr>

                                <tr>
                                    <th class="txt-content">Created At</th>
                                    <td>{{ $setting->created_date }}</td>
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
