@extends('web.layouts.master')

@section('title', 'Tenders List')

@section('head')
<style>
    .btn-filter {
        float: right;
        margin-bottom: 10px;
    }

</style>
@endsection

@section('content')
<div class="container-fluid body remove-padding">

    <div class="container stie-map">
        <ul>
            <li><a href="{{ route('home') }}">Home</a></li>
            <li><span>/</span></li>
            <li>
                <p>Tenders List</p>
            </li>
        </ul>
    </div>

    <div class="container remove-padding Finish-tender all-Finish-tender margin-section">
        <div class="col-md-4 col-xs-12">
            <form id="tenders_filter_form" action="{{ route('tenders.filter') }}" method="POST">
                @csrf

                <aside class="filter-main">
                    <div class="col-xs-12 remove-padding filter-item">
                        <div class="col-xs-8">
                            <p>Filters</p>
                            <h5 id="filter_count_txt">{{ $filterCount }} Filter(s) Selected</h5>
                        </div>
                        <div class="col-xs-4">
                            <input type="button" value="Apply" id="apply_filter" class="btn btn-filter">
                        </div>
                    </div>

                    <div class="col-xs-12 remove-padding filter-item">
                        <p class="collapse-btn-main" data-toggle="collapse" data-target="#sort-div">Sort by </p>
                        <ul id="sort-div" class="collapse in">
                            <li>
                                <label class="checkbox-item">Recent Tenders
                                    <input type="checkbox" name="recent_filter" value="1">
                                    <span class="checkmark"></span>
                                </label>
                            </li>
                            {{-- <li>
                            <label class="checkbox-item">Nearest location
                                <input type="checkbox">
                                <span class="checkmark"></span>
                            </label>
                        </li> --}}
                            <li>
                                <label class="checkbox-item">Nearest Closing Date
                                    <input type="checkbox" name="closing_filter" value="1">
                                    <span class="checkmark"></span>
                                </label>
                            </li>
                        </ul>
                    </div>

                    <div class="col-xs-12 remove-padding filter-item">
                        <p class="collapse-btn-main" data-toggle="collapse" data-target="#category-div">Category</p>
                        <ul id="category-div" class="collapse in">
                            <div class="filter-search">
                                <i class="ri-search-line"></i>
                                <input type="text" placeholder="Search">
                            </div>

                            <li>
                                <label class="checkbox-item">All
                                    <input type="checkbox" id="category_filter_all" name="category_filter[]" class="category_filter" value="all" checked>
                                    <span class="checkmark"></span>
                                </label>
                            </li>

                            @foreach($categories as $categoryId => $category)
                            <li>
                                <label class="checkbox-item">{{ $category }}
                                    <input type="checkbox" name="category_filter[]" class="category_filter category_filter_custom" value="{{ $categoryId }}">
                                    <span class="checkmark"></span>
                                </label>
                            </li>
                            @endforeach

                            {{-- <div class="more-options-main">
                            <div class="more-options-cont collapse" id="Category-more">
                                <li>
                                    <label class="checkbox-item">Nearest Closing date
                                        <input type="checkbox">
                                        <span class="checkmark"></span>
                                    </label>
                                </li>
                            </div>
                            <h4 class="collapsed" data-toggle="collapse" data-target="#Category-more"></h4>
                        </div> --}}
                        </ul>
                    </div>

                    <div class="col-xs-12 remove-padding filter-item">
                        <p class="collapse-btn-main" data-toggle="collapse" data-target="#range-div">Contract Duration in Days</p>
                        <div id="range-div" class="collapse in range-days">
                            <div class="row">
                                <div class="col-xs-6">
                                    <input type="number" name="range_from" min="1" placeholder="From in Days">
                                </div>
                                <div class="col-xs-6">
                                    <input type="number" name="range_to" min="1" placeholder="To in Days">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xs-12 remove-padding filter-item">
                        <p class="collapse-btn-main" data-toggle="collapse" data-target="#location-div">Location</p>
                        <ul id="location-div" class="collapse in">
                            <div class="filter-search">
                                <i class="ri-search-line"></i>
                                <input type="text" placeholder="Search">
                            </div>

                            <li>
                                <label class="checkbox-item">All
                                    <input type="checkbox" id="country_filter_all" class="country_filter" name="country_filter[]" value="all" checked>
                                    <span class="checkmark"></span>
                                </label>
                            </li>

                            @foreach($countries as $countryId => $country)
                            <li>
                                <label class="checkbox-item">{{ $country }}
                                    <input type="checkbox" name="country_filter[]" class="country_filter country_filter_custom" value="{{ $countryId }}">
                                    <span class="checkmark"></span>
                                </label>
                            </li>
                            @endforeach

                            {{-- <div class="more-options-main">
                            <div class="more-options-cont collapse" id="Location-more">
                                <li>
                                    <label class="checkbox-item">Saudi arabia
                                        <input type="checkbox">
                                        <span class="checkmark"></span>
                                    </label>
                                </li>

                            </div>
                            <h4 class="collapsed" data-toggle="collapse" data-target="#Location-more"></h4>
                        </div> --}}
                        </ul>
                    </div>

                    <div class="col-xs-12 remove-padding filter-item">
                        <p class="collapse-btn-main collapsed" data-toggle="collapse" data-target="#activity-div">Activity Classification</p>
                        <ul id="activity-div" class="collapse">
                            <li>
                                <label class="checkbox-item">All
                                    <input type="checkbox" id="classification_filter_all" class="classification_filter" name="classification_filter[]" value="all" checked>
                                    <span class="checkmark"></span>
                                </label>
                            </li>
                            @foreach($classifications as $classificationId => $classification)
                            <li>
                                <label class="checkbox-item">{{ $classification }}
                                    <input type="checkbox" name="classification_filter[]" class="classification_filter classification_filter_custom" value="{{ $classificationId }}">
                                    <span class="checkmark"></span>
                                </label>
                            </li>
                            @endforeach
                        </ul>
                    </div>

                    <div class="col-xs-12 remove-padding filter-item">
                        <p class="collapse-btn-main collapsed" data-toggle="collapse" data-target="#user-type-div">User Type</p>
                        <ul id="user-type-div" class="collapse">
                            <li>
                                <label class="checkbox-item">All
                                    <input type="checkbox" id="user_type_filter_all" class="user_type_filter" name="user_type_filter[]" value="all" checked>
                                    <span class="checkmark"></span>
                                </label>
                            </li>

                            <li>
                                <label class="checkbox-item">Company
                                    <input type="checkbox" name="user_type_filter[]" class="user_type_filter user_type_filter_custom" value="company">
                                    <span class="checkmark"></span>
                                </label>
                            </li>

                            <li>
                                <label class="checkbox-item">Individual
                                    <input type="checkbox" name="user_type_filter[]" class="user_type_filter user_type_filter_custom" value="individual">
                                    <span class="checkmark"></span>
                                </label>
                            </li>

                        </ul>
                    </div>

                    <div class="col-xs-12 remove-padding filter-item">
                        <p class="collapse-btn-main collapsed" data-toggle="collapse" data-target="#account-type-div">Account Type</p>
                        <ul id="account-type-div" class="collapse">
                            <li>
                                <label class="checkbox-item">Verified accounts
                                    <input type="checkbox" name="account_type" value="1">
                                    <span class="checkmark"></span>
                                </label>
                            </li>
                        </ul>
                    </div>
                </aside>
                <span class="visible-xs visible-sm filter-btn-mob"></span>
            </form>
        </div>

        <div class="col-md-8 col-xs-12 filter-cont" id="tenders_div">
            @foreach($tenders as $tender)
            <div class="col-xs-12 Tender-item">
                <h4>{{ $tender->subject }}</h4>
                <span>{{ $tender->workCategoryClassification->translate('ar')->name }}</span>
                <h3> Contract duration :<span>{{ $tender->contract_duration }} days</span></h3>
                <div class="clearfix"></div>
                <ul class="col-xs-12 remove-padding">
                    <li>
                        <h5>Contract Start date : <span>{{ $tender->contract_start_date_text }}</span></h5>
                    </li>
                    <li>
                        <h5>Contract End date : <span>{{ $tender->contract_end_date_text }}</span></h5>
                    </li>
                </ul>
                <div class="clearfix"></div>
                <ul class="col-xs-12 remove-padding">
                    <li><i class="ri-map-pin-line"></i>
                        <h5>{{ $tender->city->translate('ar')->name }}, {{ $tender->country->translate('ar')->name }}</h5>
                    </li>
                    <li><i class="ri-function-line"></i>
                        <h5>{{ $tender->activityClassification->translate('ar')->name }}</h5>
                    </li>
                </ul>
                <div class="clearfix"></div>
                <p>{{ $tender->desc }}</p>
                <div class="col-xs-12 remove-padding">
                    <div class="Tender-progress">
                        <div style="width:50%;"></div>
                    </div>
                    <h6>Time remaining<span>{{ $tender->remaining_days }} day(s) before closing date </span></h6>
                </div>
                <div class="col-xs-12 remove-padding">
                    <div class="tender-img">
                        <img src="{{ asset('/assets/front/img/1.png') }}">
                        <p>{{ $tender->user->displayed_name }} <span>{{ $tender->user->user_type }}</span></p>
                    </div>
                    <a href="{{ route('tenders.show', ['tender' => $tender]) }}" class="tender-link">View details </a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection

@section('script')
<script type="text/javascript">
    $('.category_filter').on('click', function() {
        var val = this.checked ? this.value : '';
        if (val != 'all') {
            $("#category_filter_all").prop('checked', false);
        } else {
            $(".category_filter_custom").prop('checked', false);
        }
    });

    $('.country_filter').on('click', function() {
        var val = this.checked ? this.value : '';
        if (val != 'all') {
            $("#country_filter_all").prop('checked', false);
        } else {
            $(".country_filter_custom").prop('checked', false);
        }
    });

    $('.classification_filter').on('click', function() {
        var val = this.checked ? this.value : '';
        if (val != 'all') {
            $("#classification_filter_all").prop('checked', false);
        } else {
            $(".classification_filter_custom").prop('checked', false);
        }
    });

    $('.user_type_filter').on('click', function() {
        var val = this.checked ? this.value : '';
        if (val != 'all') {
            $("#user_type_filter_all").prop('checked', false);
        } else {
            $(".user_type_filter_custom").prop('checked', false);
        }
    });

    $(document).ready(function() {
        $("#apply_filter").click(function() {
            $('#tenders_filter_form').submit();
        });

        $('#tenders_filter_form').on("submit", function(e) {
            e.preventDefault();

            $.ajax({
                type: $('#tenders_filter_form').attr('method')
                , url: $('#tenders_filter_form').attr('action')
                , data: $('#tenders_filter_form').serialize()
                , success: function(result) {
                    // console.log(result);
                    // return false;
                    $("#tenders_div").empty();
                    $("#filter_count_txt").text(`${result.data.filterCount} Filter(s) selected`);
                    $.each(result.data.tenders, function(index, tender) {
                        $("#tenders_div").append(`
                    <div class="col-xs-12 Tender-item">
                <h4>${tender.subject}</h4>
                <span>${tender.work_category_classification.arabic_name}</span>
                <h3> Contract duration :<span>${tender.contract_duration} days</span></h3>
                <div class="clearfix"></div>
                <ul class="col-xs-12 remove-padding">
                    <li>
                        <h5>Contract Start date : <span>${tender.contract_start_date_text}</span></h5>
                    </li>
                    <li>
                        <h5>Contract End date : <span>${tender.contract_end_date_text}</span></h5>
                    </li>
                </ul>
                <div class="clearfix"></div>
                <ul class="col-xs-12 remove-padding">
                    <li><i class="ri-map-pin-line"></i>
                        <h5>${tender.city.arabic_name} , ${tender.country.arabic_name}</h5>
                    </li>
                    <li><i class="ri-function-line"></i>
                        <h5>${tender.activity_classification.arabic_name}</h5>
                    </li>
                </ul>
                <div class="clearfix"></div>
                <p>${tender.desc}</p>
                <div class="col-xs-12 remove-padding">
                    <div class="Tender-progress">
                        <div style="width:50%;"></div>
                    </div>
                    <h6>Time remaining<span>${tender.remaining_days} day(s) before closing date </span></h6>
                </div>
                <div class="col-xs-12 remove-padding">
                    <div class="tender-img">
                        <img src="{{ asset('/assets/front/img/1.png') }}">
                        <p>${tender.user.displayed_name} <span>${tender.user.user_type}</span></p>
                    </div>
                    <a href="javascript:void(0);" class="tender-link">View details </a>
                </div>
            </div>
                    `);
                    });
                }
                , error: function(error) {
                    if (typeof(error.responseJSON) != "undefined" && error.responseJSON !== null) {
                        if (error.responseJSON.messages) {
                            var errors = error.responseJSON.messages;
                            $.each(errors, function(index, messageArr) {
                                $("#" + index + "_div").addClass('error');
                                $.each(messageArr, function(key, message) {
                                    $("#" + index + "_div").append(`<h6 class='error_text'>${message}</h6>`);
                                });
                            });
                        } else {
                            alert(error.responseJSON.data.error);
                        }
                    } else {
                        alert(error.statusText);
                    }
                    return false;
                }
            });
        });
    });

</script>

@endsection
