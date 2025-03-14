@extends('web.layouts.master')

@section('title', 'Show Proposal - ' . $proposal->tender->tender_uuid)

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
            <li><a href="{{ route('tenders.index') }}">Tender list</a></li>
            <li><span>/</span></li>
            <li><a href="{{ route('tenders.show', ['tender' => $proposal->tender]) }}">{{ $proposal->tender->subject }}</a></li>
            <li><span>/</span></li>
            <li>
                <p>Sent Proposal</p>
            </li>
        </ul>
    </div>

    <div class="container remove-padding proposal-container">
        <div class="col-xs-12 proposal-d-main">
            <h1>Proposal Details</h1>
            <div class="proposal-img-main with-rate col-xs-12 remove-padding">
                <img src="{{ asset('/assets/front/img/1.png') }}">
                <h4>
                    <b>Proposal Details </b> . {{ $proposal->user->user_type }}
                    <span>{{ $proposal->status }}</span>
                </h4>
                <a class="rate-link" data-toggle="modal" data-target="#rate" href="javascript:void(0);">
                    <p>4.8</p><i class="ri-star-fill"></i><span>(221)</span>
                </a>
                <a href="javascript:void(0);"><i class="ri-printer-line"></i></a>
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
                    <h4>Items list <span>( {{ $proposal->tender->items->count() }} Item(s) )</span></h4>
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
                    <h2>{{ $proposal->tender->subject . ' . ' . $proposal->tender->tender_uuid }}</h2>
                    <div class="col-xs-12 remove-padding">
                        <a href="javascript:void(0);">Awarded</a>
                        <span><i class="ri-arrow-right-s-line"></i></span>
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
@endsection

@section('script')

<script type="text/javascript">
    $(document).ready(function() {});

</script>

@endsection
