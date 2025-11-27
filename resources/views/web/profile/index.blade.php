@extends('web.layouts.master')

@section('title', __('web.profile'))

@section('head')
<style>
    #map {
        height: 300px;
        width: 100%;
        margin-top: 10px;
    }

</style>
@endsection

@section('content')
<div class="container-fluid body remove-padding">
    <div class="container profile-main remove-padding">
        @include('web.profile.aside', ['active' => "profile"])

        @include('web.layouts.flash_msg')

        <div class="col-md-8 profile-main-cont">
            <div class="col-xs-12 profile-header">
                <img src="{{ asset('/assets/front/img/3.png') }}">
                <h2>{{ $user->isCompany() ? $user->company_name : $user->full_name }}</h2>
                <a class="rate-link" href="javascript:void(0);">
                    <p>4.8</p><i class="ri-star-fill"></i><span>(221)</span>
                </a>
                <h6>{{ $user->user_type }}</h6>
                <a class="edit-btn" href="{{ route('profile.edit') }}">{{ __('web.edit_profile') }}</a>
                <div class="clearfix"></div>
                <ul>
                    <li class="follow-btn" data-toggle="modal" data-target="#follow-list">
                        <p>375</p>
                        <h5>Following</h5>
                    </li>
                    <li class="follow-btn" data-toggle="modal" data-target="#Followes-list">
                        <p>238</p>
                        <h5>Followes</h5>
                    </li>
                    <li>
                        <p>238</p>
                        <h5>Submitted proposal</h5>
                    </li>
                    <li>
                        <p>101</p>
                        <h5>Created Tenders</h5>
                    </li>
                </ul>
            </div>

            <div class="col-xs-12 user-main-info">
                <h3>{{ __('web.main_info') }}</h3>
                <div class="col-xs-12 remove-padding user-main-info-item">
                    <h5>{{ __('web.email') }}</h5>
                    <p>{{ $user->email ?? __('web.no_email_added') }}</p>
                </div>
                <div class="col-xs-12 remove-padding user-main-info-item">
                    <h5>{{ __('web.phone_number') }}</h5>
                    <p>{{ $user->phone ? $user->phone_number : __('web.no_phone_number_added') }}</p>
                </div>
                <div class="col-xs-12 remove-padding user-main-info-item">
                    <h5>{{ __('web.country') }}</h5>
                    <p>{{ $user->country?->translate('ar')->name ?? __('web.no_country_added') }}</p>
                </div>
                @if($user->isCompany())
                <div class="col-xs-12 remove-padding user-main-info-item">
                    <h5>{{ __('web.commercial_registration_number') }}</h5>
                    <p>{{ $user->commercial_registration_number ?? __('web.no_commercial_registration_number_added') }}</p>
                </div>
                @endif
                <div class="col-xs-12 remove-padding user-main-info-item">
                    <h5>{{ __('web.work_category') }}</h5>
                    @if($user->userCategories()->count() > 0)
                    <ul>
                        @foreach($user->userCategoriesName() as $category)
                        <li><span>{{ $category }}</span></li>
                        @endforeach
                    </ul>
                    @else
                    <p>{{ __('web.no_work_category_added') }}</p>
                    @endif
                </div>

                @if($user->address)
                <div class="col-xs-12 remove-padding user-main-info-item">
                    <h5>Address</h5>
                    <p><i class="ri-map-pin-fill"></i> {{ $user->address ?? 'No Address Added' }}</p>
                    @if($user->latitude && $user->longitude)
                    <div id="map"></div>
                    @endif
                </div>
                @endif
            </div>

            <div class="row">
                @if($user->address)
                <div class="col-xs-12 col-md-6">
                    <div class="col-xs-12 user-main-info">
                        <h3>Address</h3>
                        <div class="no-address">
                            <img src="{{ asset('/assets/front/img/33.svg') }}">
                            <h5>You haven't added any addresses yet.
                                Start by adding your first address .</h5>
                        </div>
                    </div>
                </div>
                @endif

                <div class="col-xs-12 col-md-6 qr-option-main">
                    <div class="col-xs-12 user-main-info">
                        <h3>QR Code</h3>
                        <ul class="qr-option">
                            <li><a href="javascript:void(0);"><i class="ri-share-fill"></i></a></li>
                            <li><a href="javascript:void(0);"><i class="ri-download-line"></i></a></li>
                        </ul>
                        <img src="{{ asset('/assets/front/img/6.png') }}">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="follow-list" class="modal fade follow-users-list" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <h3>Following List</h3>
            <span class="close" data-dismiss="modal"><i class="ri-close-line"></i></span>

            <div class="col-xs-12 follow-search remove-padding">
                <i class="ri-search-line"></i>
                <input type="text" placeholder="Search">
            </div>
            <ul class="col-xs-12 remove-padding">
                <li class="col-xs-12 remove-padding">
                    <img src="{{ asset('/assets/front/img/1.png') }}">
                    <a class="name-link" href="javascript:void(0);">Devon Lane <i class="ri-shield-check-fill"></i> <i class="ri-vip-crown-fill"></i></a>
                    <p>Individual</p>
                    <a class="follow-btn" href="javascript:void(0);">Unfollow</a>
                </li>
                <li class="col-xs-12 remove-padding has-rate">
                    <img src="{{ asset('/assets/front/img/1.png') }}">
                    <a class="name-link" href="javascript:void(0);">Devon Lane <i class="ri-shield-check-fill"></i> <i class="ri-vip-crown-fill"></i></a>
                    <div class="col-xs-12 remove-padding">
                        <h5>4.8</h5><i class="ri-star-fill"></i><span>(221)</span>
                    </div>
                    <p>Individual</p>
                    <a class="follow-btn" href="javascript:void(0);">Unfollow</a>
                </li>
                <li class="col-xs-12 remove-padding">
                    <img src="{{ asset('/assets/front/img/1.png') }}">
                    <a class="name-link" href="javascript:void(0);">Devon Lane <i class="ri-shield-check-fill"></i> <i class="ri-vip-crown-fill"></i></a>
                    <p>Individual</p>
                    <a class="follow-btn" href="javascript:void(0);">Unfollow</a>
                </li>
                <li class="col-xs-12 remove-padding">
                    <img src="{{ asset('/assets/front/img/1.png') }}">
                    <a class="name-link" href="javascript:void(0);">Devon Lane <i class="ri-shield-check-fill"></i> <i class="ri-vip-crown-fill"></i></a>
                    <p>Individual</p>
                    <a class="follow-btn" href="javascript:void(0);">Unfollow</a>
                </li>
                <li class="col-xs-12 remove-padding">
                    <img src="{{ asset('/assets/front/img/1.png') }}">
                    <a class="name-link" href="javascript:void(0);">Devon Lane <i class="ri-shield-check-fill"></i> <i class="ri-vip-crown-fill"></i></a>
                    <p>Individual</p>
                    <a class="follow-btn" href="javascript:void(0);">Unfollow</a>
                </li>
                <li class="col-xs-12 remove-padding">
                    <img src="{{ asset('/assets/front/img/1.png') }}">
                    <a class="name-link" href="javascript:void(0);">Devon Lane <i class="ri-shield-check-fill"></i> <i class="ri-vip-crown-fill"></i></a>
                    <p>Individual</p>
                    <a class="follow-btn" href="javascript:void(0);">Unfollow</a>
                </li>
                <li class="col-xs-12 remove-padding">
                    <img src="{{ asset('/assets/front/img/1.png') }}">
                    <a class="name-link" href="javascript:void(0);">Devon Lane <i class="ri-shield-check-fill"></i> <i class="ri-vip-crown-fill"></i></a>
                    <p>Individual</p>
                    <a class="follow-btn" href="javascript:void(0);">Unfollow</a>
                </li>
                <li class="col-xs-12 remove-padding">
                    <img src="{{ asset('/assets/front/img/1.png') }}">
                    <a class="name-link" href="javascript:void(0);">Devon Lane <i class="ri-shield-check-fill"></i> <i class="ri-vip-crown-fill"></i></a>
                    <p>Individual</p>
                    <a class="follow-btn" href="javascript:void(0);">Unfollow</a>
                </li>
                <li class="col-xs-12 remove-padding">
                    <img src="{{ asset('/assets/front/img/1.png') }}">
                    <a class="name-link" href="javascript:void(0);">Devon Lane <i class="ri-shield-check-fill"></i> <i class="ri-vip-crown-fill"></i></a>
                    <p>Individual</p>
                    <a class="follow-btn" href="javascript:void(0);">Unfollow</a>
                </li>
            </ul>
        </div>
    </div>
</div>

<div id="Followes-list" class="modal fade follow-users-list" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <h3>Following List</h3>
            <span class="close" data-dismiss="modal"><i class="ri-close-line"></i></span>

            <div class="col-xs-12 follow-search remove-padding">
                <i class="ri-search-line"></i>
                <input type="text" placeholder="Search">
            </div>
            <ul class="col-xs-12 remove-padding">
                <li class="col-xs-12 remove-padding">
                    <img src="{{ asset('/assets/front/img/1.png') }}">
                    <a class="name-link" href="javascript:void(0);">Devon Lane <i class="ri-shield-check-fill"></i> <i class="ri-vip-crown-fill"></i></a>
                    <p>Individual</p>
                    <a class="follow-btn follow-btn-active" href="javascript:void(0);">follow</a>
                </li>
                <li class="col-xs-12 remove-padding has-rate">
                    <img src="{{ asset('/assets/front/img/1.png') }}">
                    <a class="name-link" href="javascript:void(0);">Devon Lane <i class="ri-shield-check-fill"></i> <i class="ri-vip-crown-fill"></i></a>
                    <div class="col-xs-12 remove-padding">
                        <h5>4.8</h5><i class="ri-star-fill"></i><span>(221)</span>
                    </div>
                    <p>Individual</p>
                    <a class="follow-btn" href="javascript:void(0);">Unfollow</a>
                </li>
                <li class="col-xs-12 remove-padding">
                    <img src="{{ asset('/assets/front/img/1.png') }}">
                    <a class="name-link" href="javascript:void(0);">Devon Lane <i class="ri-shield-check-fill"></i> <i class="ri-vip-crown-fill"></i></a>
                    <p>Individual</p>
                    <a class="follow-btn" href="javascript:void(0);">Unfollow</a>
                </li>
                <li class="col-xs-12 remove-padding">
                    <img src="{{ asset('/assets/front/img/1.png') }}">
                    <a class="name-link" href="javascript:void(0);">Devon Lane <i class="ri-shield-check-fill"></i> <i class="ri-vip-crown-fill"></i></a>
                    <p>Individual</p>
                    <a class="follow-btn" href="javascript:void(0);">Unfollow</a>
                </li>
                <li class="col-xs-12 remove-padding">
                    <img src="{{ asset('/assets/front/img/1.png') }}">
                    <a class="name-link" href="javascript:void(0);">Devon Lane <i class="ri-shield-check-fill"></i> <i class="ri-vip-crown-fill"></i></a>
                    <p>Individual</p>
                    <a class="follow-btn" href="javascript:void(0);">Unfollow</a>
                </li>

                <li class="col-xs-12 remove-padding">
                    <img src="{{ asset('/assets/front/img/1.png') }}">
                    <a class="name-link" href="javascript:void(0);">Devon Lane <i class="ri-shield-check-fill"></i> <i class="ri-vip-crown-fill"></i></a>
                    <p>Individual</p>
                    <a class="follow-btn" href="javascript:void(0);">Unfollow</a>
                </li>
                <li class="col-xs-12 remove-padding">
                    <img src="{{ asset('/assets/front/img/1.png') }}">
                    <a class="name-link" href="javascript:void(0);">Devon Lane <i class="ri-shield-check-fill"></i> <i class="ri-vip-crown-fill"></i></a>
                    <p>Individual</p>
                    <a class="follow-btn" href="javascript:void(0);">Unfollow</a>
                </li>

                <li class="col-xs-12 remove-padding">
                    <img src="{{ asset('/assets/front/img/1.png') }}">
                    <a class="name-link" href="javascript:void(0);">Devon Lane <i class="ri-shield-check-fill"></i> <i class="ri-vip-crown-fill"></i></a>
                    <p>Individual</p>
                    <a class="follow-btn" href="javascript:void(0);">Unfollow</a>
                </li>
                <li class="col-xs-12 remove-padding">
                    <img src="{{ asset('/assets/front/img/1.png') }}">
                    <a class="name-link" href="javascript:void(0);">Devon Lane <i class="ri-shield-check-fill"></i> <i class="ri-vip-crown-fill"></i></a>
                    <p>Individual</p>
                    <a class="follow-btn" href="javascript:void(0);">Unfollow</a>
                </li>
            </ul>
        </div>
    </div>
</div>

@endsection

@section('script')
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDsM_sgUSkhGcL4YWv1kKhxTSnF2oTnGhM&callback=initMap&libraries=marker" async defer></script>
<script src="{{ asset('/assets/front/js/profile.js') }}"></script>

<script type="text/javascript">
    $(document).ready(function() {});

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
