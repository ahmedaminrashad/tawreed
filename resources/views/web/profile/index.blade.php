@extends('web.layouts.master')

@section('title', 'Profile')

@section('head')
<style>
    #map {
        height: 400px;
        width: 100%;
        margin-top: 10px;
    }

</style>
@endsection

@section('content')
<div class="container-fluid body remove-padding">
    <div class="container profile-main remove-padding">
        @include('web.profile.aside', ['active' => "profile"])

        @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @endif

        <div class="col-md-8 profile-main-cont">
            <div class="col-xs-12 profile-header">
                <img src="{{ asset('/assets/front/img/3.png') }}">
                <h2>{{ $user->isCompany() ? $user->company_name : $user->full_name }}</h2>
                <a class="rate-link" href="javascript:void(0);">
                    <p>4.8</p><i class="ri-star-fill"></i><span>(221)</span>
                </a>
                <h6>{{ $user->user_type }}</h6>
                <a class="edit-btn" href="{{ route('profile.edit') }}">Edit Profile</a>
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
                <h3>Main info</h3>
                <div class="col-xs-12 remove-padding user-main-info-item">
                    <h5>Email</h5>
                    <p>{{ $user->email ?? 'No Email Added' }}</p>
                </div>
                <div class="col-xs-12 remove-padding user-main-info-item">
                    <h5>Phone Number</h5>
                    <p>{{ $user->phone ? $user->phone_number : 'No Phone Number Added' }}</p>
                </div>
                <div class="col-xs-12 remove-padding user-main-info-item">
                    <h5>Country</h5>
                    <p>{{ $user->country?->translate('ar')->name ?? 'No Country Added' }}</p>
                </div>
                <div class="col-xs-12 remove-padding user-main-info-item">
                    <h5>Commerical Registration Number</h5>
                    <p>{{ $user->commercial_registration_number ?? 'No Commerical Registration Number Added' }}</p>
                </div>
                <div class="col-xs-12 remove-padding user-main-info-item">
                    <h5>Work Category</h5>
                    <p>{{ $user->userCategories()->count() > 0 ? $user->userCategoriesNameForShow() : 'No Work Category Added' }}</p>
                </div>

                <div class="col-xs-12 remove-padding user-main-info-item">
                    <h5>Address</h5>
                    <p><i class="ri-map-pin-fill"></i> {{ $user->address ?? 'No Address Added' }}</p>
                    @if($user->latitude && $user->longitude)
                    <div id="map"></div>
                    @endif
                </div>
            </div>

            <div class="row">
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
