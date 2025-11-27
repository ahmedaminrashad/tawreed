@extends('web.layouts.master')

@section('title', 'Edit Profile')

@section('head')
<style>
    .file-preview img {
        width: 100px;
        height: 100px;
    }

    #map {
        height: 400px;
        width: 100%;
    }

</style>
@endsection

@section('content')
<div class="container-fluid body remove-padding">
    <div class="container profile-main remove-padding">
        <div class="container edit-profile-main remove-padding">
            @include('web.profile.aside', ['active' => "profile"])

            <div class="col-md-8 col-xs-12">
                <h1>{{ __('web.edit_profile') }}</h1>
                <div class="edit-profile-cont col-xs-12 remove-padding">
                    @if ($errors->any())
                    @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                    @endforeach
                    @endif

                    @include('web.layouts.flash_msg')
                    <form action="{{ route('profile.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="col-xs-12 input-item upload-main">
                            <h3>{{ __('web.image') }}</h3>
                            <input type="file" id="image" name="image" class="demo1">
                        </div>

                        <div class="col-xs-12 input-item">
                            <p>{{ $user->isCompany() ? __('web.company_name') : __('web.full_name') }}</p>
                            @if($user->isCompany())
                            <input type="text" name="company_name" id="company_name" value="{{ old('company_name') ?? $user->company_name }}" autocomplete="off">
                            @else
                            <input type="text" name="full_name" id="full_name" value="{{ old('full_name') ?? $user->full_name }}" autocomplete="off">
                            @endif
                        </div>

                        @if($user->isCompany())
                        <div class="col-xs-12 input-item">
                            <p>{{ __('web.commercial_registration_number') }}</p>
                            <input type="text" name="commercial_registration_number" id="commercial_registration_number" value="{{ old('commercial_registration_number') ?? $user->commercial_registration_number }}" autocomplete="off">
                        </div>

                        <div class="col-xs-12 input-item">
                            <p>{{ __('web.tax_card_number') }}</p>
                            <input type="text" name="tax_card_number" id="tax_card_number" value="{{ old('tax_card_number') ?? $user->tax_card_number }}" autocomplete="off">
                        </div>
                        @endif

                        <div class="col-xs-12 input-item">
                            <div class="row">
                                <div class="col-xs-12">
                                    <p>{{ __('web.phone_number') }}</p>
                                </div>
                                <div class="col-md-4 col-xs-4">
                                    <select class="js-example-phone" name="country_code" id="country_code">
                                        <option value="">Select Country Code</option>
                                        @foreach($countries_codes as $id => $code)
                                        <option value="{{ $id }}" @selected(str_contains($code, $user->country_code))>{{ $code }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-8 col-xs-8">
                                    <input type="text" name="phone" id="phone" value="{{ old('phone') ?? $user->phone }}" autocomplete="off">
                                </div>
                            </div>
                        </div>

                        <div class="col-xs-12 input-item">
                            <p>{{ __('web.country') }}</p>
                            <select id="country_id" name="country_id">
                                <option value="">{{ __('web.select_country') }}</option>
                                @foreach($countries as $id => $name)
                                <option value="{{ $id }}" @selected($id==$user->country_id)>{{ $name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-xs-12 input-item">
                            <p>{{ __('web.work_category') }}</p>
                            <select class="js-example-basic-multiple" id="category_id" name="category_id[]" multiple="multiple">
                                @foreach($categories as $id => $name)
                                <option value="{{ $id }}" @selected(in_array($id, $userCategories))>{{ $name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-xs-12 input-item">
                            <p>{{ __('web.address') }}</p>
                            <textarea name="address" id="address">{{ old('address') ?? $user->address }}</textarea>
                        </div>

                        <div class="col-xs-12 input-item">
                            <p>{{ __('web.pin_your_location_on_map') }}</p>
                            <input type="hidden" id="latitude" name="latitude" value="{{ $user->latitude }}">
                            <input type="hidden" id="longitude" name="longitude" value="{{ $user->longitude }}">
                            <div id="map"></div>
                        </div>
                        <ul class="col-xs-12">
                            <li><button>{{ __('web.cancel') }}</button></li>
                            <li><button>{{ __('web.save') }}</button></li>
                        </ul>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDsM_sgUSkhGcL4YWv1kKhxTSnF2oTnGhM&callback=initMap&libraries=marker" async defer></script>
<script src="{{ asset('/assets/front/js/profile.js') }}"></script>

<script type="text/javascript">
    $(document).ready(function() {});

    $("#country_id").select2({
        dropdownCssClass: "country-select",
        dir: "{{app()->getLocale() == 'ar'?'rtl':'ltr'}}"
    });

    $('.js-example-phone').select2({
        dropdownCssClass: "phone-select",
        dir: "{{app()->getLocale() == 'ar'?'rtl':'ltr'}}"
    });

    $('.js-example-basic-multiple').select2({
        dropdownCssClass: "multiple-select",
        dir: "{{app()->getLocale() == 'ar'?'rtl':'ltr'}}"
    });

    let ajaxConfig = {
        ajaxRequester: function(config, uploadFile, pCall, sCall, eCall) {
            let progress = 0
            let interval = setInterval(() => {
                progress += 10;
                pCall(progress)
                if (progress >= 100) {
                    clearInterval(interval)
                    const windowURL = window.URL || window.webkitURL;
                    sCall({
                        data: windowURL.createObjectURL(uploadFile.file)
                    })
                }
            }, 300)
        }
    }

    $("#image").uploader({
        ajaxConfig: ajaxConfig
    });

    let map;
    let marker;

    function initMap() {
        const defaultLocation = {
            lat: 24.71
            , lng: 46.67
        }; // Default location

        map = new google.maps.Map(document.getElementById('map'), {
            center: defaultLocation
            , zoom: 13
            , mapId: 'DEMO_MAP_ID'
        });

        // Add click listener to place a marker
        map.addListener('click', (event) => {
            const final_lat = event.latLng.lat();
            const final_lng = event.latLng.lng();

            // Update form inputs
            document.getElementById('latitude').value = final_lat;
            document.getElementById('longitude').value = final_lng;

            // Place or move the marker
            if (marker) {
                marker.setPosition(event.latLng);
            } else {
                marker = new google.maps.Marker({
                    position: event.latLng
                    , map: map
                });
            }
        });

        if ("{{ $user->latitude }}" && "{{ $user->longitude }}") {
            const lat = "{{ $user->latitude }}";
            const lng = "{{ $user->longitude }}";

            new google.maps.marker.AdvancedMarkerElement({
                position: {
                    lat: parseFloat(lat)
                    , lng: parseFloat(lng)
                }
                , map: map
            });
        }
    }

</script>

@endsection
