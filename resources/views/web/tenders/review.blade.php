@php use App\Enums\TenderStatus; @endphp
@extends('web.layouts.master')

@section('title', 'Create Tender - Review')

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
                <li><a href="{{ route('home') }}">Home</a></li>
                <li><span>/</span></li>
                <li>
                    <p>Create tender - Review</p>
                </li>
            </ul>
        </div>

        <div class="container remove-padding add-tender-main add-tender-review">
            <div class="col-xs-12">
                <h1>Create New Tender bid - Review</h1>
            </div>
            <div class="col-xs-12 tender-steps-head">
                <div class="col-md-4 done">
                    <span><i class="ri-check-line"></i></span>
                    <h4>General info</h4>
                    <p>Add info about your Tender</p>
                    <i class="ri-arrow-right-s-line"></i>
                </div>
                <div class="col-md-4 done">
                    <span><i class="ri-check-line"></i></span>
                    <h4>Add Item(s)</h4>
                    <p>Add one Item or more with details</p>
                    <i class="ri-arrow-right-s-line"></i>
                </div>
                <div class="col-md-4 active">
                    <span>3</span>
                    <h4>Preview</h4>
                    <p>Review your Tender info before publish</p>
                    <i class="ri-arrow-right-s-line"></i>
                </div>
            </div>

            <form id="add-item-form" action="{{ route('tenders.publish', ['tender' => $tender]) }}" method="POST"
                  enctype="multipart/form-data">
                @csrf
                <div class="col-md-8">
                    <div class="review-item col-xs-12 remove-padding">
                        <div class="review-item-title col-xs-12">
                            <h4>Description</h4>
                            <a href="{{ route('tenders.create', ['tender' => $tender->id]) }}">Edit <i
                                    class="ri-pencil-line"></i></a>
                        </div>
                        <div class="col-xs-12">
                            <p>
                                {{ $tender->desc }}
                            </p>
                        </div>
                    </div>

                    <div class="review-item col-xs-12 remove-padding">
                        <div class="review-item-title col-xs-12">
                            <h4>Items list <span>( {{ $tender->items()->count() }} item(s) )</span></h4>
                            <a href="{{ route('tenders.items.form', ['tender' => $tender->id]) }}">Edit <i
                                    class="ri-pencil-line"></i></a>
                        </div>


                        <div class="col-xs-12 table-item">
                            @foreach($tender->items as $key => $item)
                                <div class="col-xs-12 table-item">
                                    <table>
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>ITEM NAME</th>
                                            <th>UNITS</th>
                                            <th>QUANTITIES</th>
                                            <th></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td data-label="#">{{ ++$key }}</td>
                                            <td data-label="item name">{{ $item->name }}</td>
                                            <td data-label="Units">{{ $item->unit->translate('ar')->name }}</td>
                                            <td data-label="Quantities">{{ $item->quantity }}</td>
                                            <td class="collapsed toggle-collapse" data-toggle="collapse"
                                                data-target="#specs_{{ $key }}"></td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <p id="specs_{{ $key }}" class="collapse">
                                        <span>Technical Specifications</span>
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
                            <a href="{{ route('tenders.create', ['tender' => $tender->id]) }}">Edit <i
                                    class="ri-pencil-line"></i></a>
                        </div>
                        <div class="col-xs-12">
                            <div class="col-xs-12 remove-padding">
                                <div class="Tender-progress">
                                    <div style="width:50%;"></div>
                                </div>
                                <h6>Time remaining<span>{{ $tender->remaining_days }} day(s) before closing date </span>
                                </h6>
                            </div>
                        </div>
                    </div>

                    <div class="review-item col-xs-12 remove-padding">
                        <div class="review-item-title col-xs-12">
                            <h4>Tender Overview </h4>
                            <a href="{{ route('tenders.create', ['tender' => $tender->id]) }}">Edit <i
                                    class="ri-pencil-line"></i></a>
                        </div>
                        <div class="col-xs-6">
                            <img src="{{ asset('/assets/front/img/6.svg') }}">
                            <h5>Location</h5>
                            <h3>{{ $tender->city->translate('ar')->name }}
                                , {{ $tender->country->translate('ar')->name }}</h3>
                        </div>
                        <div class="col-xs-6">
                            <img src="{{ asset('/assets/front/img/7.svg') }}">
                            <h5>Category</h5>
                            <h3>{{ $tender->workCategoryClassification->translate('ar')->name }}</h3>
                        </div>

                        <div class="col-xs-6">
                            <img src="{{ asset('/assets/front/img/8.svg') }}">
                            <h5>Contract Start Date</h5>
                            <h3>{{ $tender->contract_start_date_text }}</h3>
                        </div>

                        <div class="col-xs-6">
                            <img src="{{ asset('/assets/front/img/9.svg') }}">
                            <h5>Contract End Date</h5>
                            <h3>{{ $tender->contract_end_date_text }}</h3>
                        </div>

                        <div class="col-xs-6">
                            <img src="{{ asset('/assets/front/img/10.svg') }}">
                            <h5>Contract Duration</h5>
                            <h3>{{ $tender->contract_duration }} Day(s)</h3>
                        </div>

                        <div class="col-xs-6">
                            <img src="{{ asset('/assets/front/img/11.svg') }}">
                            <h5>Activity Classification</h5>
                            <h3>{{ $tender->activityClassification->translate('ar')->name }}</h3>
                        </div>

                        @if($tender->status==TenderStatus::AWARDED->value)
                            <div class="col-xs-6">
                                <img src="{{ asset('/assets/front/img/11.svg') }}">
                                <h5>Activity Classification</h5>
                                <h3>Awarded</h3>
                                <a href="#awarded_div"><i class="ri-award-fill"></i> Awarded </a>

                            </div>
                        @endif
                        <div class="col-xs-6">
                            <img src="{{ asset('/assets/front/img/12.svg') }}">
                            <h5>Project Name</h5>
                            <h3>{{ $tender->project }}</h3>
                        </div>


                    </div>

                    <div class="review-item map-section col-xs-12 remove-padding">
                        <div class="review-item-title col-xs-12">
                            <h4>Address</h4>
                            <a style="float: right;" href="{{ route('tenders.create', ['tender' => $tender->id]) }}">Edit
                                <i class="ri-pencil-line"></i></a>
                        </div>
                        <div class="col-xs-12">
                            <div class="col-xs-12 remove-padding">
                                <p><span><i class="ri-map-pin-line"></i></span>{{ $tender->address }} . <a href="#">Get
                                        Direction</a></p>
                                <div id="map"></div>
                            </div>
                        </div>
                    </div>

                </div>


                <div class="col-xs-12 tender-review-bottom">
                    <button type="submit">Publish</button>
                    <a href="{{ route('tenders.items.form', ['tender' => $tender]) }}" class="back-btn">Back</a>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('script')
    <script
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDsM_sgUSkhGcL4YWv1kKhxTSnF2oTnGhM&callback=initMap&libraries=marker"
        async defer></script>

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

        $(document).ready(function () {
        });

    </script>

@endsection
