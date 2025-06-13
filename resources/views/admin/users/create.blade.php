@extends('admin.layouts.master')

@section('title', 'Create User')

@section('head')
<!-- Select2 -->
<link rel="stylesheet" href="{{ asset('/assets/adminlte/plugins/select2/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('/assets/adminlte/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
@endsection

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Create User</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}">Users</a></li>
                    <li class="breadcrumb-item active">Create User</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Create User</h3>
                    </div>
                    <form action="{{ route('admin.users.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="type">User Type</label>
                                        <select name="type" id="type" class="form-control select2" required>
                                            <option value="individual">Individual</option>
                                            <option value="company">Company</option>
                                        </select>
                                    </div>

                                    <div class="form-group individual-fields">
                                        <label for="full_name">Full Name</label>
                                        <input type="text" class="form-control" id="full_name" name="full_name" value="{{ old('full_name') }}">
                                    </div>

                                    <div class="form-group company-fields" style="display: none;">
                                        <label for="company_name">Company Name</label>
                                        <input type="text" class="form-control" id="company_name" name="company_name" value="{{ old('company_name') }}">
                                    </div>

                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="password">Password</label>
                                        <input type="password" class="form-control" id="password" name="password" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="country_code">Country Code</label>
                                        <input type="text" class="form-control" id="country_code" name="country_code" value="{{ old('country_code') }}">
                                    </div>

                                    <div class="form-group">
                                        <label for="phone">Phone</label>
                                        <input type="text" class="form-control" id="phone" name="phone" value="{{ old('phone') }}">
                                    </div>

                                    <div class="form-group">
                                        <label for="country_id">Country</label>
                                        <select name="country_id" id="country_id" class="form-control select2">
                                            <option value="">Select Country</option>
                                            @foreach($countries as $country)
                                                <option value="{{ $country->id }}" {{ old('country_id') == $country->id ? 'selected' : '' }}>
                                                    {{ $country->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="image">Profile Image</label>
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="image" name="image">
                                            <label class="custom-file-label" for="image">Choose file</label>
                                        </div>
                                    </div>

                                    <div class="form-group company-fields" style="display: none;">
                                        <label for="commercial_registration_number">Commercial Registration Number</label>
                                        <input type="text" class="form-control" id="commercial_registration_number" 
                                               name="commercial_registration_number" 
                                               value="{{ old('commercial_registration_number') }}">
                                    </div>

                                    <div class="form-group company-fields" style="display: none;">
                                        <label for="company_desc">Company Description</label>
                                        <textarea class="form-control" id="company_desc" name="company_desc" rows="3">{{ old('company_desc') }}</textarea>
                                    </div>

                                    <div class="form-group">
                                        <label for="address">Address</label>
                                        <input type="text" class="form-control" id="address" name="address" value="{{ old('address') }}">
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="latitude">Latitude</label>
                                                <input type="text" class="form-control" id="latitude" name="latitude" value="{{ old('latitude') }}">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="longitude">Longitude</label>
                                                <input type="text" class="form-control" id="longitude" name="longitude" value="{{ old('longitude') }}">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group company-fields" style="display: none;">
                                        <label for="tax_card_number">Tax Card Number</label>
                                        <input type="text" class="form-control" id="tax_card_number" name="tax_card_number" value="{{ old('tax_card_number') }}">
                                    </div>

                                    <div class="form-group">
                                        <div class="custom-control custom-switch">
                                            <input type="checkbox" class="custom-control-input" id="email_notify" name="email_notify" value="1" {{ old('email_notify') ? 'checked' : '' }}>
                                            <label class="custom-control-label" for="email_notify">Email Notifications</label>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="custom-control custom-switch">
                                            <input type="checkbox" class="custom-control-input" id="push_notify" name="push_notify" value="1" {{ old('push_notify') ? 'checked' : '' }}>
                                            <label class="custom-control-label" for="push_notify">Push Notifications</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row company-fields" style="display: none;">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="commercial_registration_file">Commercial Registration File</label>
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="commercial_registration_file" name="commercial_registration_file">
                                            <label class="custom-file-label" for="commercial_registration_file">Choose file</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="company_profile">Company Profile</label>
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="company_profile" name="company_profile">
                                            <label class="custom-file-label" for="company_profile">Choose file</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="tax_card_file">Tax Card File</label>
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="tax_card_file" name="tax_card_file">
                                            <label class="custom-file-label" for="tax_card_file">Choose file</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="iban_file">IBAN File</label>
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="iban_file" name="iban_file">
                                            <label class="custom-file-label" for="iban_file">Choose file</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Create User</button>
                            <a href="{{ route('admin.users.index') }}" class="btn btn-default">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('pagejs')
<!-- Select2 -->
<script src="{{ asset('/assets/adminlte/plugins/select2/js/select2.full.min.js') }}"></script>
<!-- bs-custom-file-input -->
<script src="{{ asset('/assets/adminlte/plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>

<script>
    $(function() {
        // Initialize Select2
        $('.select2').select2();

        // Initialize custom file input
        bsCustomFileInput.init();

        // Handle user type change
        $('#type').change(function() {
            var type = $(this).val();
            if (type === 'individual') {
                $('.individual-fields').show();
                $('.company-fields').hide();
            } else {
                $('.individual-fields').hide();
                $('.company-fields').show();
            }
        });
    });
</script>
@endsection 