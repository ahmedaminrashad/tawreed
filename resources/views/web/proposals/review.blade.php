@extends('web.layouts.master')

@section('title', 'Create Proposal - Review Proposal')

@section('head')
<style>
</style>
@endsection

@section('content')
<div class="container-fluid body remove-padding">
    <div class="container stie-map">
        <ul>
            <li><a href="{{ route('home') }}">Home</a></li>
            <li><span>/</span></li>
            <li><a href="{{ route('tenders.index') }}">Tenders</a></li>
            <li><span>/</span></li>
            <li><a href="{{ route('tenders.show', ['tender' => $tender->id]) }}">Show Tender - {{ $tender->subject }}</a></li>
            <li><span>/</span></li>
            <li>
                <p>Create Proposal - Review Proposal</p>
            </li>
        </ul>
    </div>

    <div class="container remove-padding add-tender-main add-tender-review">
        <div class="col-xs-12">
            <h1>Send Proposal to <span>( {{ $tender->subject . ' . ' . $tender->tender_uuid }} )</span></h1>
        </div>
        <div class="col-xs-12 tender-steps-head">
            <div class="col-md-4 done">
                <span><i class="ri-check-line"></i></span>
                <h4>Item(s) Price</h4>
                <p>Unit Price for each Item</p>
                <i class="ri-arrow-right-s-line"></i>
            </div>
            <div class="col-md-4 done">
                <span><i class="ri-check-line"></i></span>
                <h4>General info</h4>
                <p>Add Details of your Proposal</p>
                <i class="ri-arrow-right-s-line"></i>
            </div>
            <div class="col-md-4 active">
                <span>3</span>
                <h4>Preview</h4>
                <p>Review your Proposal info before Publish</p>
                <i class="ri-arrow-right-s-line"></i>
            </div>
        </div>

        <div class="col-md-8">
            <div class="review-item col-xs-12 remove-padding">
                <div class="review-item-title col-xs-12">
                    <h4>Description</h4>
                    <a href="#">Edit <i class="ri-pencil-line"></i></a>
                </div>
                <div class="col-xs-12">
                    <p>{{ $proposal->proposal_desc }}</p>
                </div>
            </div>

            <div class="review-item col-xs-12 remove-padding">
                <div class="review-item-title col-xs-12">
                    <h4>Items list <span>( {{ $proposal->items()->count() }} items )</span></h4>
                    <a href="#">Edit <i class="ri-pencil-line"></i></a>
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
            <div class="review-item Proposal-Overview  col-xs-12 remove-padding">
                <div class="review-item-title col-xs-12 ">
                    <h4>Proposal Overview </h4>
                    <a href="#"><i class="ri-pencil-line"></i></a>
                </div>
                <div class="col-xs-6">
                    <img src="{{ asset('/assets/front/img/10.svg') }}">
                    <h5>Contract Duration</h5>
                    <h3>{{ $proposal->contract_duration }} Day(s)</h3>
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

                @if($proposal->payment_terms != 'NA')
                <div class="col-xs-12">
                    <img src="{{ asset('/assets/front/img/44.svg') }}">
                    <h5>Payment terms</h5>
                    <h3>{{ $proposal->payment_terms }}</h3>
                </div>
                @endif
            </div>
        </div>

        <div class="col-xs-12 tender-review-bottom">
            <ul>
                <li><a href="#" data-toggle="modal" data-target="#back-tender">Back</a></li>
                <li><a href="#" data-toggle="modal" data-target="#Pulish-tender">Publish</a></li>
            </ul>
        </div>
    </div>
</div>

<div id="Pulish-tender" class="modal fade tender-model" role="dialog">
    <div class="modal-dialog">
        <form action="{{ route('tenders.proposals.publish', ['tender' => $tender, 'proposal' => $proposal]) }}" method="POST">
            @csrf
        <div class="modal-content">
            <h4>Publish tender</h4>
            <span class="close" data-dismiss="modal"><i class="ri-close-line"></i></span>
            <div class="clearfix"></div>
            <img src="{{ asset('/assets/front/img/14.svg') }}">
            <h1>Are you sure you want to Submit this Proposal ?</h1>
            <h5>
                If you Submit your Proposal, you still have the option to edit or delete it till the closing date.
            </h5>
            <ul>
                <li><a href="#" data-dismiss="modal">cancel</a></li>
                <li><input type="submit" value="Publish"></li>
                {{-- <li><a href="#" data-dismiss="modal" data-toggle="modal" data-target="#done-tender">Submit</a></li> --}}
            </ul>
        </div>
        </form>
    </div>
</div>

<div id="back-tender" class="modal fade tender-model" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <span class="close" data-dismiss="modal"><i class="ri-close-line"></i></span>
            <img src="{{ asset('/assets/front/img/15.svg') }}">
            <h1>If you go back, you'll lose all the data you've inputted into the porpsal ?</h1>
            <h5>
                If you cancel the tender, all unsaved data will be lost. You have the option to either complete your proposal or lose all the data you've inputted into it
            </h5>
            <ul>
                <li><a href="#" data-dismiss="modal">Cancel proposal</a></li>
                <li><a href="#">Complete your proposal</a></li>
            </ul>
        </div>

    </div>
</div>

<div id="done-tender" class="modal fade tender-model" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <span class="close" data-dismiss="modal"><i class="ri-close-line"></i></span>
            <img src="{{ asset('/assets/front/img/16.svg') }}">
            <h1>Your proposal is Submitted successfully</h1>
            <h5>
                you still have the option to edit or delete it from my proposal
            </h5>
            <ul>
                <li><a href="#" data-dismiss="modal">Done</a></li>
            </ul>
        </div>

    </div>
</div>

@endsection

@section('script')

<script type="text/javascript">
</script>

@endsection
