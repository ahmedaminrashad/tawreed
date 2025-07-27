@extends('web.layouts.master')

@section('title', 'Show Proposal - ' . $proposal->tender->tender_uuid)

@section('head')
<style>
    .tender-details {
        border: none;
    }

    .tender-details:hover {
        background-color: transparent !important;
    }

</style>
@endsection

@section('content')
{{--
@if ($errors->any())
    <div class="alert alert-danger">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>

        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif --}}
<div class="container-fluid body remove-padding">
    <div class="container stie-map">
        <ul>
            <li><a href="{{ route('home') }}">{{__('web.home')}}</a></li>
            <li><span>/</span></li>
            <li><a href="{{ route('tenders.index') }}">{{__('web.tender_list')}}</a></li>
            <li><span>/</span></li>
            <li><a href="{{ route('tenders.show', ['tender' => $proposal->tender]) }}">{{ $proposal->tender->subject }}</a></li>
            <li><span>/</span></li>
            <li>
                <p>{{__('web.submitted_proposal')}}</p>
            </li>
        </ul>
    </div>

    <div class="container remove-padding">
        @if($proposal->media && $proposal->media->count())
            <div class="alert alert-info" style="margin-bottom: 20px;">
                <strong>{{ __('web.attachments') }}:</strong>
                <ul style="margin: 0 0 0 20px;">
                    @foreach($proposal->media as $media)
                        <li>
                            <a href="{{ asset('storage/' . $media->file) }}" target="_blank">{{ basename($media->file) }}</a>
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>

    <div class="container remove-padding proposal-container">
        <div class="col-xs-12 proposal-d-main tender-head my-tender-head-final">
            <h1>{{ $proposal->tender->subject }} - {{__('web.proposal_details')}}</h1>
            <div class="proposal-img-main col-xs-12 remove-padding">
                <img src="{{ asset('/assets/front/img/1.png') }}">
                <h4><b>{{ $proposal->user->displayed_name }}</b>  <a class="chat-tender-icon" href="{{ route('tenders.show', ['tender' => $proposal->tender]) }}"><i class="ri-wechat-2-line"></i></a> <span data-toggle="modal" data-target="#Reason" class="tag {{ $proposal->getStatusText() }}-tag">{{ $proposal->getStatusLabel() }}</span></h4>
                <a href="javascript:void(0);"><i class="ri-printer-line"></i></a>
                @if($proposal->isCreator())
                @if($proposal->isSampleRequested())
                <a href="javascript:void(0);" data-toggle="modal" data-target="#request-sent" class="Final-Accept-btn">{{__('web.sample_sent')}}</a>
                @endif
                @if(!$proposal->isWithdrawn())
                <a href="javascript:void(0);" data-toggle="modal" data-target="#withdraw-proposal" class="Final-Accept-btn">{{__('web.withdraw')}}</a>
                @endif
                @endif
                @if(!$proposal->tender->isAwarded())
                @if($proposal->isTenderCreator())
                @if(!$proposal->isWithdrawn() && !$proposal->isRejected())
                @if(!$proposal->isFinallyAccepted())
                <a href="javascript:void(0);" data-toggle="modal" data-target="#final-accept" class="Final-Accept-btn">{{__('web.final_acceptance')}}</a>
                @endif
                @if($proposal->isInitialAccept())
                <a href="javascript:void(0);" data-toggle="modal" data-target="#request-sample" class="Final-Accept-btn">{{__('web.request_a_sample')}}</a>
                @endif
                @if($proposal->isUnderReview())
                <a href="javascript:void(0);" data-toggle="modal" data-target="#initial-accept" class="Initial-accept-btn">{{__('web.initial_acceptance')}}</a>
                @endif
                @if(!$proposal->isFinallyAccepted())
                <a href="javascript:void(0);" data-toggle="modal" data-target="#del-proposal" class="Reject-btn">{{__('web.reject')}}</a>
                @endif
                @endif
                @endif
                @endif
            </div>
        </div>

        <div class="col-md-8">
            <div class="review-item col-xs-12 remove-padding">
                <div class="review-item-title col-xs-12">
                    <h4>{{__('web.description')}}</h4>
                </div>
                <div class="col-xs-12">
                    <p>
                        {{ $proposal->proposal_desc }}
                    </p>
                </div>
            </div>

            <div class="review-item col-xs-12 remove-padding">
                <div class="review-item-title col-xs-12">
                    <h4>{{__('web.items_list')}} <span>( {{ $proposal->items->count() }} {{__('web.item_s')}} )</span></h4>
                </div>

                @foreach($proposal->items as $key => $item)
                <div class="col-xs-12 table-item">
                    <table>
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>{{__('web.item_name')}}</th>
                                <th>{{__('web.unit')}}</th>
                                <th>{{__('web.price')}}</th>
                                <th>{{__('web.quantity')}}</th>
                                <th>{{__('web.total_price')}}</th>
                                <th>-</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td data-label="#">{{ $key + 1 }}</td>
                                <td data-label="{{__('web.item_name')}}">{{ $item->name }}</td>
                                <td data-label="{{__('web.unit')}}">{{ $item->unit->translate('ar')->name }}</td>
                                <td data-label="{{__('web.price')}}">{{ $item->price }}</td>
                                <td data-label="{{__('web.quantity')}}">{{ $item->quantity }}</td>
                                <td data-label="{{__('web.total_price')}}">{{ $item->quantity * $item->price }}</td>
                                <td data-label="-" class="collapsed toggle-collapse" data-toggle="collapse" data-target="#specs-{{ $item->id }}"></td>
                            </tr>
                        </tbody>
                    </table>
                    <p id="specs-{{ $item->id }}" class="collapse">
                        {{__('web.technical_specifications')}}<br>
                        {{ $item->item_specs }}
                    </p>
                </div>
                @endforeach

            </div>
        </div>

        <div class="col-md-4">
            <div class="review-item col-xs-12 proposal-side-item remove-padding">
                <div class="review-item-title col-xs-12">
                    <h4>{{__('web.tender_details')}}</h4>
                    <a class="tender-details" style="border: none;" href="{{ route('tenders.show', ['tender' => $proposal->tender]) }}">
                        <h2>{{ $proposal->tender->subject . ' . ' . $proposal->tender->tender_uuid }}</h2>
                    </a>
                    <div class="col-xs-12 remove-padding">
                        {{-- <a href="javascript:void(0);">Awarded</a>
                        <span><i class="ri-arrow-right-s-line"></i></span> --}}
                    </div>
                </div>
            </div>

            <div class="review-item Proposal-Overview  col-xs-12 remove-padding">
                <div class="review-item-title col-xs-12 ">
                    <h4>{{__('web.proposal_overview')}}</h4>
                </div>

                <div class="col-xs-6">
                    <img src="{{ asset('/assets/front/img/10.svg') }}">
                    <h5>{{__('web.contract_duration')}}</h5>
                    <h3>{{ $proposal->contract_duration }} {{__('web.days')}} </h3>
                </div>
                 <div class="col-xs-6">
                    <img src="{{ asset('/assets/front/img/42.svg') }}">
                    <h5>{{__('web.price_not_include_vat')}}</h5>
                    <h3>{{ $proposal->total }} {{__('web.sar')}}</h3>
                </div>
                <div class="col-xs-6">
                    <img src="{{ asset('/assets/front/img/42.svg') }}">
                    <h5>{{__('web.proposal_total_price')}}</h5>
                    <h3>{{ $proposal->total_with_vat }} {{__('web.sar')}}</h3>
                </div>

                <div class="col-xs-12">
                    <img src="{{ asset('/assets/front/img/44.svg') }}">
                    <h5>{{__('web.the_proposal_validity_period')}}</h5>
                    <h3>{{ $proposal->proposal_end_date_text }}</h3>
                </div>

                <div class="col-xs-12">
                    <img src="{{ asset('/assets/front/img/44.svg') }}">
                    <h5>{{__('web.payment_terms')}}</h5>
                    <h3>{{ $proposal->payment_terms }}</h3>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="final-accept" class="modal fade proposal-model" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="{{ route('proposals.final.accept', ['proposal' => $proposal]) }}">
                @csrf

                <h3>{{__('web.final_acceptance')}}</h3>
                <span class="close" data-dismiss="modal"><i class="ri-close-line"></i></span>
                <img src="{{ asset('/assets/front/img/13.svg') }}">
                <h2>{{__('web.are_you_sure_you_want_to_final_accept_this_proposal')}}</h2>
                <ul>
                    <li><button data-dismiss="modal">{{__('web.cancel')}}</button></li>
                    <li><input type="submit" value="{{__('web.final_acceptance')}}"></li>
                </ul>
            </form>
        </div>
    </div>
</div>

<div id="request-sample" class="modal fade proposal-model" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="{{ route('proposals.request.sample', ['proposal' => $proposal]) }}">
                @csrf

                <h3>{{__('web.sample_request')}}</h3>
                <span class="close" data-dismiss="modal"><i class="ri-close-line"></i></span>
                <textarea placeholder="{{__('web.enter_sample_request')}}" name="sample_request"></textarea>
                <ul>
                    <li><button data-dismiss="modal">{{__('web.cancel')}}</button></li>
                    <li><input type="submit" value="{{__('web.request_sample')}}"></li>
                </ul>
            </form>
        </div>
    </div>
</div>

<div id="request-sent" class="modal proposal-model fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="{{ route('proposals.sample.sent', ['proposal' => $proposal]) }}">
                @csrf

                <h3>{{__('web.sample_request_sent')}}</h3>
                <span class="close" data-dismiss="modal"><i class="ri-close-line"></i></span>
                <img src="{{ asset('/assets/front/img/13.svg') }}">
                <h2>{{__('web.are_you_sure_you_want_to_confirm_that_you_sent_proposal_sample_request')}}</h2>
                <ul>
                    <li><button data-dismiss="modal">{{__('web.cancel')}}</button></li>
                    <li><input type="submit" value="{{__('web.submit')}}"></li>
                </ul>

                <input type="hidden" name="status" value="initial acceptance (sample sent)">
            </form>
        </div>
    </div>
</div>

<div id="initial-accept" class="modal proposal-model fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="{{ route('proposals.initial.accept', ['proposal' => $proposal]) }}">
                @csrf

                <h3>{{__('web.initial_acceptance')}}</h3>
                <span class="close" data-dismiss="modal"><i class="ri-close-line"></i></span>
                <img src="{{ asset('/assets/front/img/13.svg') }}">
                <h2>{{__('web.are_you_sure_you_want_to_initial_accept_this_proposal')}}</h2>
                <p>{{__('web.after_you_initial_accept_this_proposal_you_can_chat_with_seller_and_request_a_sample_from_it')}}</p>
                <ul>
                    <li><button data-dismiss="modal">{{__('web.cancel')}}</button></li>
                    <li><input type="submit" value="{{__('web.initial_acceptance')}}"></li>
                </ul>
            </form>
        </div>
    </div>
</div>

<div id="del-proposal" class="modal fade proposal-model cancel-model-tender" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <h3>{{__('web.cancel_tender_bid')}}</h3>
            <span class="close" data-dismiss="modal"><i class="ri-close-line"></i></span>
            <img src="{{ asset('/assets/front/img/45.svg') }}">
            <h2>{{__('web.before_reject_proposal_tender_bid_select_cancelation_reason')}}</h2>

            <form method="POST" action="{{ route('proposals.reject', ['proposal' => $proposal]) }}">
                @csrf

                <label class="container-radio">{{__('web.proposals_prices_are_too_high')}}
                    <input type="radio" name="reject_reason" value="1">
                    <span class="checkmark-radio"></span>
                </label>

                <label class="container-radio">{{__('web.non_compliance_with_technical_specification')}}
                    <input type="radio" name="reject_reason" value="2">
                    <span class="checkmark-radio"></span>
                </label>

                <label class="container-radio">{{__('web.dont_need_it_anymore')}}
                    <input type="radio" name="reject_reason" value="3">
                    <span class="checkmark-radio"></span>
                </label>

                <label class="container-radio">{{__('web.other_option')}}
                    <input type="radio" name="reject_reason" value="4">
                    <span class="checkmark-radio"></span>
                </label>

                <div class="add-note-main">
                    <textarea placeholder="{{__('web.add_reason')}}" name="custom_reject_reason"></textarea>
                </div>

                <ul>
                    <li><a data-dismiss="modal" href="javascript:void(0);">{{__('web.back')}}</a></li>
                    <li><input type="submit" value="{{__('web.reject')}}"></li>
                </ul>

            </form>
        </div>
    </div>
</div>

<div id="withdraw-proposal" class="modal fade del-model" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="{{ route('proposals.withdraw', ['proposal' => $proposal]) }}">
                @csrf

                <h3>{{__('web.proposal_withdraw')}}</h3>
                <span class="close" data-dismiss="modal"><i class="ri-close-line"></i></span>
                <img src="{{ asset('/assets/front/img/45.svg') }}">
                <h1>{{__('web.are_you_sure_you_want_to_withdraw_this_proposal')}}</h1>
                <ul>
                    <li><a data-dismiss="modal" href="javascript:void(0);">{{__('web.cancel')}}</a></li>
                    <li><input type="submit" value="{{__('web.withdraw')}}"></li>
                </ul>
            </form>
        </div>
    </div>
</div>
@endsection

@section('script')

<script type="text/javascript">
    $(document).ready(function() {});

    $('.cancel-model-tender input[type="radio"]').click(function() {
        if ($(this).attr("value") == "4") {
            $(".add-note-main").slideDown();
        } else {
            $('.add-note-main').slideUp();

        }
    });

</script>

@endsection
