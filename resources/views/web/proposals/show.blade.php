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
            <li><a href="{{ route('home') }}">Home</a></li>
            <li><span>/</span></li>
            <li><a href="{{ route('tenders.index') }}">Tender list</a></li>
            <li><span>/</span></li>
            <li><a href="{{ route('tenders.show', ['tender' => $proposal->tender]) }}">{{ $proposal->tender->subject }}</a></li>
            <li><span>/</span></li>
            <li>
                <p>Submitted Proposal</p>
            </li>
        </ul>
    </div>

    <div class="container remove-padding proposal-container">
        <div class="col-xs-12 proposal-d-main tender-head my-tender-head-final">
            <h1>Proposal Details</h1>
            <div class="proposal-img-main col-xs-12 remove-padding">
                <img src="{{ asset('/assets/front/img/1.png') }}">
                <h4><b>{{ $proposal->tender->subject }}</b>. {{ $proposal->status }} <a class="chat-tender-icon" href="{{ route('tenders.show', ['tender' => $proposal->tender]) }}"><i class="ri-wechat-2-line"></i></a> <span data-toggle="modal" data-target="#Reason" class="tag {{ $proposal->getStatusText() }}-tag">{{ $proposal->checkStatus() }}</span></h4>
                <a href="javascript:void(0);"><i class="ri-printer-line"></i></a>
                @if($proposal->isCreator())
                @if($proposal->isSampleRequested())
                <a href="javascript:void(0);" data-toggle="modal" data-target="#request-sent" class="Final-Accept-btn">Sample Sent</a>
                @endif
                @if(!$proposal->isWithdrawn())
                <a href="javascript:void(0);" data-toggle="modal" data-target="#withdraw-proposal" class="Final-Accept-btn">Withdraw</a>
                @endif
                @endif

                @if($proposal->isTenderCreator())
                @if(!$proposal->isWithdrawn() && !$proposal->isRejected())
                @if(!$proposal->isFinallyAccepted())
                <a href="javascript:void(0);" data-toggle="modal" data-target="#final-accept" class="Final-Accept-btn">Final Acceptance</a>
                @endif
                @if($proposal->isInitialAccept())
                <a href="javascript:void(0);" data-toggle="modal" data-target="#request-sample" class="Final-Accept-btn">Request a Sample</a>
                @endif
                @if($proposal->isUnderReview())
                <a href="javascript:void(0);" data-toggle="modal" data-target="#initial-accept" class="Initial-accept-btn">Initial Accept</a>
                @endif
                @if(!$proposal->isFinallyAccepted())
                <a href="javascript:void(0);" data-toggle="modal" data-target="#del-proposal" class="Reject-btn">Reject</a>
                @endif
                @endif
                @endif
            </div>
        </div>

        <div class="col-md-8">
            <div class="review-item col-xs-12 remove-padding">
                <div class="review-item-title col-xs-12">
                    <h4>Description</h4>
                </div>
                <div class="col-xs-12">
                    <p>
                        {{ $proposal->proposal_desc }}
                    </p>
                </div>
            </div>

            <div class="review-item col-xs-12 remove-padding">
                <div class="review-item-title col-xs-12">
                    <h4>Items list <span>( {{ $proposal->items->count() }} Item(s) )</span></h4>
                </div>

                @foreach($proposal->items as $key => $item)
                <div class="col-xs-12 table-item">
                    <table>
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Item Name</th>
                                <th>Unit</th>
                                <th>Quantity</th>
                                <th>Total Price</th>
                                <th>-</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td data-label="#">{{ $key + 1 }}</td>
                                <td data-label="item name">{{ $item->name }}</td>
                                <td data-label="Units">{{ $item->unit->translate('ar')->name }}</td>
                                <td data-label="Quantities">{{ $item->quantity }}</td>
                                <td data-label="total_price">{{ $item->quantity * $item->price }}</td>
                                <td data-label="-" class="collapsed toggle-collapse" data-toggle="collapse" data-target="#specs-{{ $item->id }}"></td>
                            </tr>
                        </tbody>
                    </table>
                    <p id="specs-{{ $item->id }}" class="collapse">
                        Technical Specifications<br>
                        {{ $item->item_specs }}
                    </p>
                </div>
                @endforeach

            </div>
        </div>

        <div class="col-md-4">
            <div class="review-item col-xs-12 proposal-side-item remove-padding">
                <div class="review-item-title col-xs-12">
                    <h4>Tender details</h4>
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
                    <h4>Proposal Overview</h4>
                </div>

                <div class="col-xs-6">
                    <img src="{{ asset('/assets/front/img/10.svg') }}">
                    <h5>Contract Duration</h5>
                    <h3>{{ $proposal->contract_duration }} Day(s) </h3>
                </div>

                <div class="col-xs-6">
                    <img src="{{ asset('/assets/front/img/42.svg') }}">
                    <h5>Proposal Total Price</h5>
                    <h3>{{ $proposal->total }} USD</h3>
                </div>

                <div class="col-xs-12">
                    <img src="{{ asset('/assets/front/img/44.svg') }}">
                    <h5>The Proposal Validity Period</h5>
                    <h3>{{ $proposal->proposal_end_date_text }}</h3>
                </div>

                <div class="col-xs-12">
                    <img src="{{ asset('/assets/front/img/44.svg') }}">
                    <h5>Payment Terms</h5>
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

                <h3>Final Acceptance</h3>
                <span class="close" data-dismiss="modal"><i class="ri-close-line"></i></span>
                <img src="{{ asset('/assets/front/img/13.svg') }}">
                <h2>Are you sure you want to final accept this Proposal ?</h2>
                <ul>
                    <li><button data-dismiss="modal">Cancel</button></li>
                    <li><input type="submit" value="Final Accept"></li>
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

                <h3>Sample Request</h3>
                <span class="close" data-dismiss="modal"><i class="ri-close-line"></i></span>
                <h2>Request a sample from seller ? </h2>
                <textarea placeholder="Enter Sample Request" name="sample_request"></textarea>
                <ul>
                    <li><button data-dismiss="modal">Cancel</button></li>
                    <li><input type="submit" value="Request Sample"></li>
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

                <h3>Sample Request Sent</h3>
                <span class="close" data-dismiss="modal"><i class="ri-close-line"></i></span>
                <img src="{{ asset('/assets/front/img/13.svg') }}">
                <h2>Are you sure you want to confirm that you sent Proposal Sample Request ?</h2>
                <ul>
                    <li><button data-dismiss="modal">Cancel</button></li>
                    <li><input type="submit" value="Submit"></li>
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

                <h3>Initial Accept</h3>
                <span class="close" data-dismiss="modal"><i class="ri-close-line"></i></span>
                <img src="{{ asset('/assets/front/img/13.svg') }}">
                <h2>Are you sure you want to initial accept this Proposal ?</h2>
                <p>After you initial accept this proposal you can chat with seller and request a sample from it</p>
                <ul>
                    <li><button data-dismiss="modal">Cancel</button></li>
                    <li><input type="submit" value="Initial Accept"></li>
                </ul>
            </form>
        </div>
    </div>
</div>

<div id="del-proposal" class="modal fade proposal-model cancel-model-tender" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <h3>Cancel tender bid </h3>
            <span class="close" data-dismiss="modal"><i class="ri-close-line"></i></span>
            <img src="{{ asset('/assets/front/img/45.svg') }}">
            <h2>Before reject Proposal Tender Bid Select cancelation reason</h2>

            <form method="POST" action="{{ route('proposals.reject', ['proposal' => $proposal]) }}">
                @csrf
                
                <label class="container-radio">Proposals Prices are too high
                    <input type="radio" name="reject_reason" value="1">
                    <span class="checkmark-radio"></span>
                </label>

                <label class="container-radio">Non-Compliance with Technical Specification
                    <input type="radio" name="reject_reason" value="2">
                    <span class="checkmark-radio"></span>
                </label>

                <label class="container-radio">Don’t need it anymore
                    <input type="radio" name="reject_reason" value="3">
                    <span class="checkmark-radio"></span>
                </label>

                <label class="container-radio">other option
                    <input type="radio" name="reject_reason" value="4">
                    <span class="checkmark-radio"></span>
                </label>

                <div class="add-note-main">
                    <textarea placeholder="add Reason" name="custom_reject_reason"></textarea>
                </div>

                <ul>
                    <li><a data-dismiss="modal" href="javascript:void(0);">back</a></li>
                    <li><input type="submit" value="Reject"></li>
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

                <h3>Proposal Withdraw</h3>
                <span class="close" data-dismiss="modal"><i class="ri-close-line"></i></span>
                <img src="{{ asset('/assets/front/img/45.svg') }}">
                <h1>Are you sure you want to withdraw this Proposal ?</h1>
                <ul>
                    <li><a data-dismiss="modal" href="javascript:void(0);">Cancel</a></li>
                    <li><input type="submit" value="Withdraw"></li>
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
