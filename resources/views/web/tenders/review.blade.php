@extends('web.layouts.master')

@section('title', __('web.create_tender_review'))

@section('head')
<style>
    #map {
        height: 400px;
        width: 100%;
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
                <p>{{ __('web.create_tender_review') }}</p>
            </li>
        </ul>
    </div>

    <div class="container remove-padding add-tender-main add-tender-review">
        <div class="col-xs-12">
            <h1>{{ __('web.create_new_tender_bid_review') }}</h1>
        </div>
        <div class="col-xs-12 tender-steps-head">
            <div class="col-md-4 done">
                <span><i class="ri-check-line"></i></span>
                <h4>{{ __('web.general_info') }}</h4>
                <p>{{ __('web.add_info_about_tender') }}</p>
                <i class="ri-arrow-right-s-line"></i>
            </div>
            <div class="col-md-4 done">
                <span><i class="ri-check-line"></i></span>
                <h4>{{ __('web.add_items') }}</h4>
                <p>{{ __('web.add_one_or_more_items') }}</p>
                <i class="ri-arrow-right-s-line"></i>
            </div>
            <div class="col-md-4 active">
                <span>3</span>
                <h4>{{ __('web.preview') }}</h4>
                <p>{{ __('web.review_tender_info_before_publish') }}</p>
                <i class="ri-arrow-right-s-line"></i>
            </div>
        </div>

        <form id="add-item-form" action="{{ route('tenders.publish', ['tender' => $tender]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="col-md-8">
                <div class="review-item col-xs-12 remove-padding">
                    <div class="review-item-title col-xs-12">
                        <h4>{{ __('web.description') }}</h4>
                        <a href="{{ route('tenders.create', ['tender' => $tender->id]) }}">{{ __('web.edit') }} <i class="ri-pencil-line"></i></a>
                    </div>
                    <div class="col-xs-12">
                        <p>
                            {{ $tender->desc }}
                        </p>
                    </div>
                </div>

                <div class="review-item col-xs-12 remove-padding">
                    <div class="review-item-title col-xs-12">
                        <h4>{{ __('web.items_list') }} <span>({{ $tender->items()->count() }} {{ __('web.items') }})</span></h4>
                        <a href="{{ route('tenders.items.form', ['tender' => $tender->id]) }}">{{ __('web.edit') }} <i class="ri-pencil-line"></i></a>
                    </div>


                    <div class="col-xs-12 table-item">
                        @foreach($tender->items as $key => $item)
                        <div class="col-xs-12 table-item">
                            <table>
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>{{__('web.item_name')}}</th>
                                        <th>{{__('web.unit')}}</th>
                                        <th>{{__('web.quantity')}}</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td data-label="#">{{ ++$key }}</td>
                                        <td data-label="{{__('web.item_name')}}">{{ $item->name }}</td>
                                        <td data-label="{{__('web.unit')}}">{{ $item->unit->translate('ar')->name }}</td>
                                        <td data-label="{{__('web.quantity')}}">{{ $item->quantity }}</td>
                                        <td class="collapsed toggle-collapse" data-toggle="collapse" data-target="#specs_{{ $key }}"></td>
                                    </tr>
                                </tbody>
                            </table>
                            <p id="specs_{{ $key }}" class="collapse">
                                <span>{{ __('web.technical_specifications') }}</span>
                                {{ $item->specs }}
                            </p>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>


            <div class="col-md-4">

                <div class="review-item col-xs-12 remove-padding">
                    <div class="review-item-title col-xs-12">
                        <a href="{{ route('tenders.create', ['tender' => $tender->id]) }}">{{ __('web.edit') }} <i class="ri-pencil-line"></i></a>
                    </div>
                    <div class="col-xs-12">
                        <div class="col-xs-12 remove-padding">
                            <div class="Tender-progress">
                                <div style="width:50%;"></div>
                            </div>
                            <h6>{{ __('web.time_remaining') }}<span>{{ $tender->remaining_days }} {{ __('web.days') }} {{ __('web.before_closing_date') }}</span></h6>
                        </div>
                    </div>
                </div>

                <div class="review-item col-xs-12 remove-padding">
                    <div class="review-item-title col-xs-12">
                        <h4>{{ __('web.tender_overview') }}</h4>
                        <a href="{{ route('tenders.create', ['tender' => $tender->id]) }}">{{ __('web.edit') }} <i class="ri-pencil-line"></i></a>
                    </div>
                    <div class="col-xs-6">
                        <img src="{{ asset('/assets/front/img/6.svg') }}">
                        <h5>{{ __('web.location') }}</h5>
                        <h3>{{ $tender->city->translate('ar')->name }}, {{ $tender->country->translate('ar')->name }}</h3>
                    </div>
                    <div class="col-xs-6">
                        <img src="{{ asset('/assets/front/img/7.svg') }}">
                        <h5>{{ __('web.category') }}</h5>
                        <h3>{{ $tender->workCategoryClassification->translate('ar')->name }}</h3>
                    </div>

                    <div class="col-xs-6">
                        <img src="{{ asset('/assets/front/img/8.svg') }}">
                        <h5>{{ __('web.contract_start_date') }}</h5>
                        <h3>{{ $tender->contract_start_date_text }}</h3>
                    </div>

                    <div class="col-xs-6">
                        <img src="{{ asset('/assets/front/img/9.svg') }}">
                        <h5>{{ __('web.contract_end_date') }}</h5>
                        <h3>{{ $tender->contract_end_date_text }}</h3>
                    </div>

                    <div class="col-xs-6">
                        <img src="{{ asset('/assets/front/img/10.svg') }}">
                        <h5>{{ __('web.contract_duration') }}</h5>
                        <h3>{{ $tender->contract_duration }} {{__('web.days')}}</h3>
                    </div>

                    <div class="col-xs-6">
                        <img src="{{ asset('/assets/front/img/11.svg') }}">
                        <h5>{{ __('web.activity_classification') }}</h5>
                        <h3>{{ $tender->activityClassification->translate('ar')->name }}</h3>
                    </div>

                    <div class="col-xs-6">
                        <img src="{{ asset('/assets/front/img/12.svg') }}">
                        <h5>{{ __('web.project_name') }}</h5>
                        <h3>{{ $tender->project }}</h3>
                    </div>


                </div>

                <div class="review-item map-section col-xs-12 remove-padding">
                    <div class="review-item-title col-xs-12">
                        <h4>{{ __('web.address') }}</h4>
                        <a style="float: right;" href="{{ route('tenders.create', ['tender' => $tender->id]) }}">{{ __('web.edit') }} <i class="ri-pencil-line"></i></a>
                    </div>
                    <div class="col-xs-12">
                        <div class="col-xs-12 remove-padding">
                            <p><span><i class="ri-map-pin-line"></i></span>{{ $tender->address }} . <a href="#">{{ __('web.get_direction') }}</a></p>
                            <div id="map"></div>
                        </div>
                    </div>
                </div>

            </div>


            <div class="col-xs-12 tender-review-bottom">
                <button type="submit">{{ __('web.publish') }}</button>
                <a href="{{ route('tenders.items.form', ['tender' => $tender]) }}" class="back-btn">{{ __('web.back') }}</a>
            </div>
        </form>
    </div>
</div>
@endsection

@section('script')
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDsM_sgUSkhGcL4YWv1kKhxTSnF2oTnGhM&callback=initMap&libraries=marker" async defer></script>

<script type="text/javascript">
    let map;
    let marker;

    function initMap() {
        const lat = "{{ $tender->latitude }}";
        const lng = "{{ $tender->longitude }}";

        const defaultLocation = {
            lat: parseFloat(lat) ?? 24.71
            , lng: parseFloat(lng) ?? 46.67
        }; // Default location

        map = new google.maps.Map(document.getElementById('map'), {
            center: defaultLocation
            , zoom: 13
            , mapId: 'DEMO_MAP_ID'
        });

        new google.maps.marker.AdvancedMarkerElement({
            position: {
                lat: parseFloat(lat)
                , lng: parseFloat(lng)
            }
            , map: map
        });
    }

    $(document).ready(function() {});

</script>

@endsection
