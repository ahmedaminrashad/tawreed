@php use App\Enums\ProposalStatus; @endphp
@extends('web.layouts.master')

@section('title', 'Show Tender Proposals - ' . $tender->subject)

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
        <div class="container profile-main tender-d-main remove-padding">
            <div class="col-xs-12 proposal-d-main tender-head">
                <h1>{{ $tender->subject . ' . ' . $tender->tender_uuid }}</h1>
                <div class="proposal-img-main col-xs-12 remove-padding">
                    <img src="{{ asset('/assets/front/img/1.png') }}">
                    <h4><b>{{ $tender->user->displayed_name }} </b>. {{ $tender->user->user_type }}</h4>
                    @if($tender->user_id != auth()->id() && !in_array(auth()->id(), $tender->proposals()->pluck('user_id')->toArray()))
                        <a href="{{ route('tenders.proposals.items', ['tender' => $tender->id]) }}">{{ __('web.submit_proposal') }}</a>
                    @endif
                    @if($tender->user_id == auth()->id())
                        <a href="javascript:void(0);"><i class="ri-printer-line"></i></a>
                        <a href="javascript:void(0);" data-toggle="modal" data-target="#edit-tender"><i
                                class="ri-pencil-line"></i></a>
                        <a href="javascript:void(0);" data-toggle="modal" data-target="#del-tender"
                           class="cansel-btn"><i class="ri-close-fill"></i></a>
                    @endif
                </div>
            </div>

            <div class="col-xs-12">
                <ul class="proposal-tabs-first">
                    <li>
                        <a href="{{ route('tenders.show', ['tender' => $tender->id]) }}"><i
                                class="ri-lightbulb-flash-line"></i> {{ __('web.general_details') }}</a>
                    </li>
                    <li class="active">
                        <a href="{{ route('tenders.proposals.show', ['tender' => $tender->id]) }}"><i
                                class="ri-article-line"></i> {{ __('web.proposals_sent') }} ( {{ $proposalsCount }}
                            )</a>
                    </li>

                    <div class="dropdown sort-dropdown">
                        <button class="dropdown-toggle" type="button" data-toggle="dropdown">
                            <b> {{__('web.sort_by')}}:</b> {{__('web.date_newest_to_oldest')}}<span><i
                                    class="ri-arrow-down-s-fill"></i></span>
                        </button>
                        <ul class="dropdown-menu">
                            <li><a href="#">{{__('web.date_newest_to_oldest')}}</a></li>
                            <li><a href="#">{{__('web.date_oldest_to_newest')}}</a></li>
                            <li><a href="#">{{__('web.total_price_high_to_low')}}</a></li>
                            <li><a href="#">{{__('web.total_price_low_to_high')}}</a></li>
                        </ul>
                    </div>
                </ul>
            </div>

            <div class="col-xs-12 proposal-main-cont Tenders-pro-main">
                <ul class="proposal-tabs" role="tablist">
                    <li class="active"><a id="tabAll" href="javascript:void(0);">{{__('web.all')}}</a></li>
                    @foreach($statuses as $key => $status)
                        <li>
                            <a href="#{{ $key }}" role="tab" data-toggle="tab">
                                {{ $status }}
                            </a>
                        </li>
                    @endforeach
                </ul>

                <div class="row">
                    <div class="tab-content">
                        @foreach($statuses as $key => $status)
                            @if(count($proposals[$key]) > 0)
                                @foreach($proposals[$key] as $proposal)
                                    @if(Auth::user()->id!=$proposal->user_id && Auth::user()->id !=$proposal->tender->user_id && in_array($proposal->status,[ProposalStatus::CREATED->value,ProposalStatus::DRAFT->value] ))
                                        @continue
                                    @endif
                                    <div class="tab-pane fade active in" id="{{ $key }}">
                                        <div class="col-md-6 col-xs-12">
                                            <div class="col-xs-12 remove-padding propoal-item">
                                                <div class="dropdown">
                                                    <button class="dropdown-toggle" type="button"
                                                            data-toggle="dropdown">
                                                        <i class="ri-more-line"></i>
                                                    </button>
                                                    <ul class="dropdown-menu">
                                                        <li><a href="javascript:void(0);">{{__('web.edit')}}</a></li>
                                                        <li><a href="javascript:void(0);">{{__('web.withdraw')}}</a>
                                                        </li>
                                                        <li><a href="javascript:void(0);">{{__('web.sample_sent')}}</a>
                                                        </li>
                                                        <li><a href="javascript:void(0);">{{__('web.print')}}</a></li>
                                                    </ul>
                                                </div>
                                                <p>{{ $proposal->tender->subject . ' . ' . $proposal->tender->tender_uuid }}
                                                    <span>{{ $proposal->getStatusLabel() }}</span></p>
                                                <h4>{{__('web.proposal_validity_period')}} :
                                                    <b>{{ $proposal->proposal_end_date }}</b></h4>
                                                <h3><span
                                                        class="tag {{ $status }}-tag">{{ $proposal->getStatusLabel() }}</span>{{__('web.contract_duration_by_seller')}}
                                                    : <b> {{ $proposal->contract_duration }} {{__('web.days')}}</b></h3>
                                                <div class="col-xs-12 remove-padding propoal-img">
                                                    <img src="{{ asset('/assets/front/img/1.png') }}">
                                                    <h6>{{ $proposal->tender->user->displayed_name }}
                                                        <span>{{ $proposal->tender->user->user_type }}</span></h6>
                                                </div>
                                                <h5>
                                                    <span>{{__('web.total_price')}} </span><br>
                                                    <b>{{ $proposal->total }} {{__('web.sar')}}</b>
                                                </h5>
                                                <a href="{{ route('proposals.show', ['proposal' => $proposal]) }}"
                                                   class="details">{{__('web.view_details')}}</a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="tab-pane fade active in" id="{{ $key }}">
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script type="text/javascript">
        $(document).ready(function () {
            $('#tabAll').on('click', function () {
                $('#tabAll').parent().addClass('active');
                $('.tab-pane').addClass('active in');
                $('[data-toggle="tab"]').parent().removeClass('active');
            });
        });

    </script>

@endsection
