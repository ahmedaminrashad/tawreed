@extends('web.layouts.master')

@section('title', __('web.create_tender'))

@section('head')
<style>
    #map {
        height: 400px;
        width: 100%;
    }

    .input-item label {
        display: block;
        margin-bottom: 8px;
        font-weight: 500;
        color: #333;
    }

    .input-item.error label {
        color: #dc3545;
    }

    .input-item textarea + label {
        margin-top: 8px;
    }

    @media (max-width: 768px) {
        .input-item label {
            font-size: 14px;
        }
    }
</style>
@endsection

@section('content')

<div class="container-fluid body remove-padding">
    <div class="container stie-map">
        <ul>
            <li><a href="{{ route('home') }}">{{ __('web.home') }}</a></li>
            <li><span>/</span></li>
            <li>
                <p>{{ __('web.create_tender') }}</p>
            </li>
        </ul>
    </div>
    <div class="container remove-padding add-tender-main">
        <div class="col-xs-12">
            <h1>{{ __('web.create_new_tender_bid') }}</h1>
        </div>
        <div class="col-xs-12 tender-steps-head">
            <div class="col-md-4 active">
                <span>1</span>
                <h4>{{ __('web.general_info') }}</h4>
                <p>{{ __('web.add_info_about_tender') }}</p>
                <i class="ri-arrow-right-s-line"></i>
            </div>
            <div class="col-md-4">
                <span>2</span>
                <h4>{{ __('web.add_items') }}</h4>
                <p>{{ __('web.add_one_or_more_items') }}</p>
                <i class="ri-arrow-right-s-line"></i>
            </div>
            <div class="col-md-4">
                <span>3</span>
                <h4>{{ __('web.preview') }}</h4>
                <p>{{ __('web.review_tender_info_before_publish') }}</p>
                <i class="ri-arrow-right-s-line"></i>
            </div>
        </div>

        @if(session('success'))
        <div class="alert alert-success">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>

            {{ session('success') }}
        </div>
        @endif

        @if(session('error'))
        <div class="alert alert-danger">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>

            {{ session('error') }}
        </div>
        @endif


        <form id="store_tender_info" action="{{ route('tenders.store', ['tender' => $tender?->id]) }}" method="POST">
            @csrf

            <div class="col-xs-12 inputs-group">
                <h2>{{ __('web.main_info') }}</h2>

                <div class="col-md-6 col-xs-12 col-sm-12 input-item subject_div @if($errors->has('subject')) error @endif">
                    <label for="subject">{{ __('web.tender_subject_name') }}</label>
                    <input name="subject" id="subject" placeholder="{{ __('web.tender_subject_name') }}" value="{{ old('subject') ?? $tender?->subject }}">
                    @if($errors->has('subject'))
                    <p>{{ $errors->first('subject') }}</p>
                    @endif
                </div>
                <div class="col-md-6 col-xs-12 col-sm-12 input-item project_div @if($errors->has('project')) error @endif">
                    <label for="project">{{ __('web.tender_project_name_optional') }}</label>
                    <input name="project" id="project" placeholder="{{ __('web.tender_project_name_optional') }}" value="{{ old('project') ?? $tender?->project }}">
                    @if($errors->has('project'))
                    <p>{{ $errors->first('project') }}</p>
                    @endif
                </div>

                <div class="col-md-6 col-xs-12 col-sm-12 input-item country_id_div @if($errors->has('country_id')) error @endif">
                    <label for="country_id">{{ __('web.choose_country') }}</label>
                    <select class="list-select2-choose" name="country_id" id="country_id">
                        <option value="">{{ __('web.choose_country') }}</option>
                        @foreach($countries as $countryID => $country)
                        <option value="{{ $countryID }}" @selected((old('country_id') ?? $tender?->country_id)==$countryID)>{{ $country }}</option>
                        @endforeach
                    </select>
                    @if($errors->has('country_id'))
                    <p>{{ $errors->first('country_id') }}</p>
                    @endif
                </div>

                <div class="col-md-6 col-xs-12 col-sm-12 input-item city_id_div @if($errors->has('city_id')) error @endif">
                    <label for="city_id">{{ __('web.choose_city') }}</label>
                    <select class="list-select2-choose" name="city_id" id="city_id">
                        <option value="">{{ __('web.choose_city') }}</option>
                    </select>
                    @if($errors->has('city_id'))
                    <p>{{ $errors->first('city_id') }}</p>
                    @endif
                </div>

                <div class="col-md-6 col-xs-12 col-sm-12 input-item category_id_div @if($errors->has('category_id')) error @endif">
                    <label for="category_id">{{ __('web.choose_work_category') }}</label>
                    <select class="list-select2-choose" name="category_id" id="category_id">
                        <option value="">{{ __('web.choose_work_category') }}</option>
                        @foreach($workCategories as $categoryID => $category)
                        <option value="{{ $categoryID }}" @selected((old('category_id') ?? $tender?->category_id)==$categoryID)>{{ $category }}</option>
                        @endforeach
                    </select>
                    @if($errors->has('category_id'))
                    <p>{{ $errors->first('category_id') }}</p>
                    @endif
                </div>

                <div class="col-md-6 col-xs-12 col-sm-12 input-item activity_id_div @if($errors->has('activity_id')) error @endif">
                    <label for="activity_id">{{ __('web.choose_activity_classification') }}</label>
                    <select class="list-select2-choose" name="activity_id" id="activity_id">
                        <option value="">{{ __('web.choose_activity_classification') }}</option>

                    </select>
                    @if($errors->has('activity_id'))
                    <p>{{ $errors->first('activity_id') }}</p>
                    @endif
                </div>

                <div class="col-xs-12 input-item desc_div @if($errors->has('desc')) error_textarea @endif">
                    <label for="desc">{{ __('web.tender_description_optional') }}</label>
                    <textarea name="desc" id="desc" placeholder="{{ __('web.tender_description_optional') }}">{{ old('desc') ?? $tender?->desc }}</textarea>
                    @if($errors->has('desc'))
                    <p>{{ $errors->first('desc') }}</p>
                    @endif
                </div>
            </div>

            <div class="col-xs-12 inputs-group">
                <h2>{{ __('web.dates') }}</h2>
                <div class="col-md-6 col-xs-12 col-sm-12 input-item contract_duration_div @if($errors->has('contract_duration')) error @endif">
                    <label for="contract_duration">{{ __('web.tender_contract_duration_in_days') }}</label>
                    <input type="number" min="1" name="contract_duration" id="contract_duration" value="{{ old('contract_duration') ?? $tender?->contract_duration }}" placeholder="{{ __('web.tender_contract_duration_in_days') }}" autocomplete="off">
                    @if($errors->has('contract_duration'))
                    <p>{{ $errors->first('contract_duration') }}</p>
                    @endif
                </div>

                <div class="col-md-6 col-xs-12 col-sm-12 input-item datepicker-input contract_start_date_div @if($errors->has('contract_start_date')) error @endif">
                    <label for="contract_start_date">{{ __('web.tender_contract_start_date') }}</label>
                    <input type="text" name="contract_start_date" id="contract_start_date" value="{{ old('contract_start_date') ?? $tender?->contract_start_date }}" class="date-picker" placeholder="{{ __('web.tender_contract_start_date') }}" autocomplete="off">
                    <i class="ri-calendar-line"></i>
                    @if($errors->has('contract_start_date'))
                    <p>{{ $errors->first('contract_start_date') }}</p>
                    @endif
                </div>

                <div class="col-md-6 col-xs-12 col-sm-12 input-item datepicker-input contract_end_date_div @if($errors->has('contract_end_date')) error @endif">
                    <label for="contract_end_date">{{ __('web.tender_contract_end_date') }}</label>
                    <input type="text" name="contract_end_date" id="contract_end_date" value="{{ old('contract_end_date') ?? $tender?->contract_end_date }}" placeholder="{{ __('web.tender_contract_end_date') }}" readonly>
                    <i class="ri-calendar-line"></i>
                    @if($errors->has('contract_end_date'))
                    <p>{{ $errors->first('contract_end_date') }}</p>
                    @endif
                </div>

                <div class="col-md-6 col-xs-12 col-sm-12 input-item datepicker-input closing_date_div @if($errors->has('closing_date')) error @endif">
                    <label for="closing_date">{{ __('web.tender_closing_date') }}</label>
                    <input type="text" name="closing_date" id="closing_date" class="date-picker" value="{{ old('closing_date') ?? $tender?->closing_date }}" placeholder="{{ __('web.tender_closing_date') }}" autocomplete="off">
                    <i class="ri-calendar-line"></i>
                    @if($errors->has('closing_date'))
                    <p>{{ $errors->first('closing_date') }}</p>
                    @endif
                </div>

                <div class="col-md-6 col-xs-12 col-sm-12 input-item proposal_evaluation_duration_div @if($errors->has('proposal_evaluation_duration')) error @endif">
                    <label for="proposal_evaluation_duration">{{ __('web.tender_proposals_evaluation_duration_in_days') }}</label>
                    <input type="number" min="1" name="proposal_evaluation_duration" id="proposal_evaluation_duration" value="{{ old('proposal_evaluation_duration') ?? $tender?->proposal_evaluation_duration }}" placeholder="{{ __('web.tender_proposals_evaluation_duration_in_days') }}" autocomplete="off">
                    @if($errors->has('proposal_evaluation_duration'))
                    <p>{{ $errors->first('proposal_evaluation_duration') }}</p>
                    @endif
                </div>
            </div>

            <div class="col-xs-12 inputs-group" style="padding-bottom: 50px;">
                <h2>{{ __('web.address') }}</h2>
                <div class="col-xs-12 col-md-6 input-item remove-margin address_div @if($errors->has('address')) error_textarea @endif">
                    <label for="address">{{ __('web.write_address') }}</label>
                    <textarea name="address" id="address" placeholder="{{ __('web.write_address') }}">{{ old('address') ?? $tender?->address }}</textarea>
                    @if($errors->has('address'))
                    <p>{{ $errors->first('address') }}</p>
                    @endif
                </div>
                <!-- will change this with you  -->
                <div class="col-xs-12 col-md-6 input-item remove-margin location_div @if($errors->has('latitude') || $errors->has('longitude')) error_textarea @endif">
                    <input type="hidden" id="latitude" name="latitude">
                    <input type="hidden" id="longitude" name="longitude">
                    <div id="map"></div>
                    @if($errors->has('latitude') || $errors->has('longitude'))
                    <p style="padding-top: 10px;">{{ $errors->first('latitude') ?? $errors->has('longitude') }}</p>
                    @endif
                </div>
            </div>

            <div class="col-xs-12 remove-padding">
                <input type="hidden" name="step" value="1">
                <button type="submit">{{ __('web.next_preview_tender_before_publish') }}</button>
            </div>

        </form>
    </div>
</div>
@endsection

@section('script')
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDsM_sgUSkhGcL4YWv1kKhxTSnF2oTnGhM&callback=initMap&libraries=marker" async defer></script>

<script type="text/javascript">
    $(document).ready(function() {
        $('.country-select').select2(
            {
                dir: "{{app()->getLocale() == 'ar'?'rtl':'ltr'}}"
            }
        );

        $('.country-select').select2({
            dropdownCssClass: "country-select",
            dir: "{{app()->getLocale() == 'ar'?'rtl':'ltr'}}"
        });

        $('.list-select2-choose').select2({
            dropdownCssClass: "country-select",
            dir: "{{app()->getLocale() == 'ar'?'rtl':'ltr'}}"
        });

        $(".date-picker").datepicker({
            changeMonth: true
            , changeYear: true
        , });

        getCityList($("#country_id").val());

        getActivityList($("#category_id").val());

        $("#country_id").on("change", function() {
            getCityList($(this).val());
        });

        $("#category_id").on("change", function() {
            getActivityList($(this).val());
            $(".activityOption").remove()
        });
    });

    function getCityList($country_id) {
        var listCitiesURL = '{{ route('country.list.cities', ['country_id' => '#id']) }}';

        var country_id = $("#country_id").val();
        var city_id = "{{ old('city_id') }}" ? "{{ old('city_id') }}" : "{{ $tender?->city_id }}";

        $("#city_id").find('option').not(':first').remove();

        if (country_id != '') {
            $.ajax({
                url: listCitiesURL.replace('#id', country_id)
                , dataType: 'json'
                , success: function(data) {
                    $.each(data, function(key, val) {
                        if (key == city_id) {
                            $("#city_id").append(`<option value="${key}" selected>${val}</option>`);
                        } else {
                            $("#city_id").append(`<option value="${key}">${val}</option>`);
                        }
                    });

                    $('#city_id').select2({
                        dropdownCssClass: "country-select",
                        dir: "{{app()->getLocale() == 'ar'?'rtl':'ltr'}}"
                    });
                }
            });
        }
    }
    function getActivityList() {
        var listCatUrl = '{{ route('category.list.activities', ['category_id' => '#id']) }}';

        var category_id = $("#category_id").val();
        var activity_id = "{{ old('activity_id') ? : $tender?->activity_id}}";

        $("#activity_id").find('option').not(':first').remove();

        if (category_id !== '') {
            $.ajax({
                url: listCatUrl.replace('#id', category_id)
                , dataType: 'json'
                , success: function(data) {
                    $.each(data, function(key, val) {
                        if (val?.id == activity_id) {
                            $("#activity_id").append(`<option value="${val.id}" class="activityOption" selected>${val.arabic_name}</option>`);
                        } else {
                            $("#activity_id").append(`<option class="activityOption" value="${val.id}">${val.arabic_name}</option>`);
                        }
                    });

                    $('#activity_id').select2({
                        dropdownCssClass: "country-select",
                        dir: "{{app()->getLocale() == 'ar'?'rtl':'ltr'}}"
                    });
                }
            });
        }
    }

    let map;
    let marker;

    function initMap() {
        const lat = "{{ old('latitude') }}" ? "{{ old('latitude') }}" : "{{ $tender?->latitude }}";
        const lng = "{{ old('longitude') }}" ? "{{ old('longitude') }}" : "{{ $tender?->longitude }}";

        const defaultLocation = {
            lat: lat ? parseFloat(lat) : 24.71
            , lng: lng ? parseFloat(lng) : 46.67
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

        if ("{{ $tender }}" || "{{ old('latitude') }}" || "{{ old('longitude') }}") {

            // Update form inputs
            document.getElementById('latitude').value = lat;
            document.getElementById('longitude').value = lng;

            new google.maps.marker.AdvancedMarkerElement({
                position: {
                    lat: parseFloat(lat)
                    , lng: parseFloat(lng)
                }
                , map: map
            });
        }
    }

    $("#contract_start_date").on("change", function() {
        calculateClosingDate();
    });

    $("#contract_duration").on("change", function() {
        if($("#contract_duration").val() <= 0) {
            $("#contract_duration").val(1);
        }
        calculateClosingDate();
    });

    function calculateClosingDate() {
        var startDate = $("#contract_start_date").val();
        var daysToAdd = parseInt($("#contract_duration").val(), 10);

        if (startDate && !isNaN(daysToAdd)) {
            var date = new Date(startDate);
            date.setDate(date.getDate() + daysToAdd);

            var formattedDate = (date.getMonth() + 1).toString().padStart(2, '0') + '/' +
                date.getDate().toString().padStart(2, '0') + '/' +
                date.getFullYear();

            var closingDate = formattedDate;

            $("#contract_end_date").val(closingDate);
        } else {
            $("#contract_end_date").val(""); // Clear the closing date if inputs are invalid
        }
    }
    function arabicToEnglishNumbers(input) {
    const arabic = ['٠','١','٢','٣','٤','٥','٦','٧','٨','٩'];
    const english = ['0','1','2','3','4','5','6','7','8','9'];
    let output = input;
    for (let i = 0; i < arabic.length; i++) {
        output = output.replace(new RegExp(arabic[i], 'g'), english[i]);
    }
    return output;
}

$("#contract_duration").on("change", function() {
    let val = $(this).val();
    let converted = arabicToEnglishNumbers(val);
    if (val !== converted) {
        $(this).val(converted);
    }
});
</script>

@endsection
