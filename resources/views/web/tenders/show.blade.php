@extends('web.layouts.master')

@section('title', 'Show Tender - ' . $tender->subject)

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
    <div class="container tender-d-main remove-padding">
        <div class="col-xs-12 proposal-d-main tender-head">
            <h1>{{ $tender->subject . ' . ' . $tender->tender_uuid }}</h1>
            <div class="proposal-img-main col-xs-12 remove-padding">
                <img src="{{ asset('/assets/front/img/1.png') }}">
                <h4><b>{{ $tender->user->displayed_name }} </b>. {{ $tender->user->user_type }}</h4>
                <a href="{{ route('tenders.proposals.items', ['tender' => $tender->id]) }}">Send Proposal</a>
                <a href="javascript:void(0);"><i class="ri-printer-line"></i></a>
                <a href="javascript:void(0);" data-toggle="modal" data-target="#edit-tender"><i class="ri-pencil-line"></i></a>
                <a href="javascript:void(0);" data-toggle="modal" data-target="#del-tender" class="cansel-btn"><i class="ri-close-fill"></i></a>
            </div>
        </div>
        <div class="col-xs-12">
            <ul class="proposal-tabs-first">
                <li class="active">
                    <a href="{{ route('tenders.show', ['tender' => $tender->id]) }}"><i class="ri-lightbulb-flash-line"></i> General Details</a>
                </li>
                <li>
                    <a href="{{ route('tenders.proposals.show', ['tender' => $tender->id]) }}"><i class="ri-article-line"></i> Proposal(s) Sent ( {{ $proposalsCount }} )</a>
                </li>
            </ul>
        </div>

        <div class="col-md-8 col-xs-12 proposal-main-cont Tenders-pro-main">
            <div class="review-item col-xs-12 remove-padding">
                <div class="review-item-title col-xs-12">
                    <h4>Description</h4>
                </div>
                <div class="col-xs-12">
                    <p>
                        {!! $tender->desc !!}
                    </p>
                </div>
            </div>

            <div class="review-item col-xs-12 remove-padding">
                <div class="review-item-title col-xs-12">
                    <h4>Items list <span>( {{ $tender->items()->count() }} item(s) )</span></h4>
                </div>

                <div class="col-xs-12 table-item">
                    @foreach($tender->items as $index => $item)
                    <table>
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Item Name</th>
                                <th>Units</th>
                                <th>Quantities</th>
                                <th>-</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td data-label="#">{{ ++$index }}</td>
                                <td data-label="item name">{{ $item->name }}</td>
                                <td data-label="Units">{{ $item->unit->translate('ar')->name }}</td>
                                <td data-label="Quantities">{{ $item->quantity }}</td>
                                <td data-label="-" class="collapsed toggle-collapse" data-toggle="collapse" data-target="#item_{{ $item->id }}"></td>
                            </tr>
                        </tbody>
                    </table>
                    <p id="item_{{ $item->id }}" class="collapse"><span>Technical Specifications</span>{{ $item->specs }}</p>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="col-md-4 col-xs-12">

            <div class="review-item col-xs-12 remove-padding">
                <div class="col-xs-12">
                    <div class="col-xs-12 remove-padding">
                        <div class="Tender-progress">
                            <div style="width:50%;"></div>
                        </div>
                        <h6>Time remaining<span> {{ $tender->remaining_days }} day(s) before Closing Date </span></h6>
                    </div>
                </div>
            </div>

            <div class="review-item col-xs-12 remove-padding">
                <div class="review-item-title col-xs-12">
                    <h4>Tender Overview </h4>
                </div>
                <div class="col-xs-6">
                    <img src="{{ asset('/assets/front/img/6.svg') }}">
                    <h5>location</h5>
                    <h3>{{ $tender->city->arabic_name }}, {{ $tender->country->arabic_name }}</h3>
                </div>
                <div class="col-xs-6">
                    <img src="{{ asset('/assets/front/img/7.svg') }}">
                    <h5>Category</h5>
                    <h3>{{ $tender->workCategoryClassification->arabic_name }}</h3>
                </div>

                <div class="col-xs-6">
                    <img src="{{ asset('/assets/front/img/8.svg') }}">
                    <h5>Contract Start Date</h5>
                    <h3>{{ $tender->contract_end_date_text }}</h3>
                </div>

                <div class="col-xs-6">
                    <img src="{{ asset('/assets/front/img/9.svg') }}">
                    <h5>Contract End Date</h5>
                    <h3>{{ $tender->contract_start_date_text }}</h3>
                </div>

                <div class="col-xs-6">
                    <img src="{{ asset('/assets/front/img/10.svg') }}">
                    <h5>Contract Duration</h5>
                    <h3>{{ $tender->contract_duration }}</h3>
                </div>

                <div class="col-xs-6">
                    <img src="{{ asset('/assets/front/img/11.svg') }}">
                    <h5>Classification</h5>
                    <h3>{{ $tender->activityClassification->arabic_name }}</h3>
                </div>


                <div class="col-xs-6">
                    <img src="{{ asset('/assets/front/img/12.svg') }}">
                    <h5>Project Name</h5>
                    <h3>{{ $tender->project }}</h3>
                </div>
            </div>

            <div class="review-item map-section col-xs-12 remove-padding">
                <div class="review-item-title col-xs-12">
                    <h4>Address</h4>
                </div>
                <div class="col-xs-12">
                    <div class="col-xs-12 remove-padding">
                        <p style="margin-bottom: 15px;"><span><i class="ri-map-pin-line"></i></span>{{ $tender->address }}</p>
                        <div id="map"></div>                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDsM_sgUSkhGcL4YWv1kKhxTSnF2oTnGhM&callback=initMap&libraries=marker" async defer></script>

<script type="text/javascript">
    let map;
    let marker;

    const lat = "{{ $tender->latitude }}";
    const lng = "{{ $tender->longitude }}";

    function initMap() {
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
