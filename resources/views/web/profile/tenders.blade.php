@extends('web.layouts.master')

@section('title', __('web.my_tenders'))

@section('head')
<style>
</style>
@endsection

@section('content')
<div class="container-fluid body remove-padding">
    <div class="container profile-main remove-padding">
        @include('web.profile.aside', ['active' => "tenders"])

        @include('web.layouts.flash_msg')

        <div class="col-md-8 col-xs-12 proposal-main-cont Tenders-pro-main">
            <ul class="proposal-tabs-first">
                <li class="active">
                    <a href="#inprogress_div"><i class="ri-loader-2-line"></i> {{ __('web.in_progress') }}</a>
                </li>
                <li><a href="#awarded_div"><i class="ri-award-fill"></i> {{ __('web.awarded') }}</a></li>
                <li><a href="#cancelled_div"><i class="ri-close-fill"></i> {{ __('web.cancelled') }}</a></li>
            </ul>

            {{-- <div id="inprogress_div" class="proposal-empty col-xs-12 text-center remove-padding"> --}}
                @forelse($tenders as $tender)
                <div class="col-xs-12 Tender-item">
                    <h4>{{ $tender->subject . ' . ' . $tender->tender_uuid }}</h4>
                    <div class="dropdown">
                        <button class="dropdown-toggle" type="button" data-toggle="dropdown">
                            <i class="ri-more-line"></i>
                        </button>
                        <ul class="dropdown-menu">
                            <li><a href="#">{{ __('web.edit') }}</a></li>
                            <li><a href="#" data-toggle="modal" data-target="#Cancel">{{ __('web.cancel') }}</a></li>
                            <li><a href="#">{{ __('web.print') }}</a></li>
                        </ul>
                    </div>
                    <span>{{ $tender->workCategoryClassification->translate('ar')->name }}</span>
                    <h3>{{ __('web.contract_duration') }} :<span>{{ $tender->contract_duration }} {{ __('web.days') }}</span></h3>
                    <div class="clearfix"></div>
                    <ul class="col-xs-12 remove-padding">
                        <li>
                            <h5>{{ __('web.contract_start_date') }} : <span>{{ $tender->contract_start_date_text }}</span></h5>
                        </li>
                        <li>
                            <h5>{{ __('web.contract_end_date') }} : <span>{{ $tender->contract_end_date_text }}</span></h5>
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
                    <p>{{ __('web.no_tenders') }}</p>
                    <div class="col-xs-12 remove-padding">
                        <div class="Tender-progress">
                            <div style="width:50%;"></div>
                        </div>
                        <h6>{{ __('web.time_remaining') }}<span>{{ $tender->remaining_days }} {{ __('web.days') }} {{ __('web.before_closing_date') }}</span></h6>
                    </div>
                    <div class="col-xs-12 remove-padding">
                        <h2>
                            <span>{{ __('web.number_of_submitted_proposals') }}</span>
                            <br>
                            {{ $tender->proposals()->count() }} {{ __('web.proposals') }}
                        </h2>
                        <a href="{{ route('tenders.show', ['tender' => $tender]) }}" class="tender-link">{{ __('web.view_details') }}</a>
                    </div>
                </div>
                @empty
                <img src="{{ asset('/assets/front/img/47.svg') }}" />
                <p>{{__('web.there_is_no_tender')}}</p>
                @endforelse
            {{-- </div> --}}

            {{-- <div id="awarded_div" class="proposal-empty col-xs-12 text-center remove-padding">
                <img src="{{ asset('/assets/front/img/47.svg') }}" />
            <p>The is No Tenders Created for you Yet</p>
        </div>

        <div id="cancelled_div" class="proposal-empty col-xs-12 text-center remove-padding">
            <img src="{{ asset('/assets/front/img/47.svg') }}" />
            <p>The is No Tenders Created for you Yet</p>
        </div> --}}
    </div>
</div>
</div>

@endsection

@section('script')
<script src="{{ asset('/assets/front/js/profile.js') }}"></script>

<script type="text/javascript">
    $(document).ready(function() {});

</script>

@endsection
