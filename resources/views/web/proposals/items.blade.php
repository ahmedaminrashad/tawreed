@extends('web.layouts.master')

@section('title', 'Create Proposal - Add Items')

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
                <p>Create Proposal - Add Items</p>
            </li>
        </ul>
    </div>

    <div class="container remove-padding add-tender-main add-tender-review">
        <div class="col-xs-12">
            <h1>Send Proposal to <span>( {{ $tender->subject . ' . ' . $tender->tender_uuid }} )</span></h1>
        </div>
        <div class="col-xs-12 tender-steps-head">
            <div class="col-md-4 active">
                <span>1</span>
                <h4>Item(s) Price</h4>
                <p>Unit Price for each Item</p>
                <i class="ri-arrow-right-s-line"></i>
            </div>

            <div class="col-md-4">
                <span>2</span>
                <h4>General info</h4>
                <p>Add Details of your Proposal</p>
                <i class="ri-arrow-right-s-line"></i>
            </div>

            <div class="col-md-4">
                <span>3</span>
                <h4>Preview</h4>
                <p>Review your Proposal info before Publish</p>
                <i class="ri-arrow-right-s-line"></i>
            </div>
        </div>

        @if(session('error'))
        <div class="alert alert-danger">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>

            {{ session('error') }}
        </div>
        @endif

        @if ($errors->any())
        <div class="col-xs-12 error" style="margin-top: 15px">
            <p style="color: red;">Error in Adding Tender Item(s)</p>
        </div>
        @endif

        <form id="add-item-form" action="{{ route('tenders.proposals.items.store', ['tender' => $tender, 'proposal' => $proposal]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="col-md-12 col-xs-12">

                <div class="review-item col-xs-12 remove-padding">
                    <div class="review-item-title col-xs-12">
                        <h4>Items list <span>( {{ $tender->items()->count() }} items )</span></h4>
                    </div>

                    @foreach($tender->items as $key => $item)
                    <div class="col-xs-12 table-item">

                        <table>
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Item Name</th>
                                    <th>Unit</th>
                                    <th>Quantity</th>
                                    <th>-</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td data-label="#">{{ $key + 1 }}</td>
                                    <td data-label="item name">{{ $item->name }}</td>
                                    <td data-label="Units">{{ $item->unit->translate('ar')->name }}</td>
                                    <td data-label="Quantities">{{ $item->quantity }}</td>
                                    <td data-label="-" class="collapsed toggle-collapse" data-toggle="collapse" data-target="#specs_{{ $item->id }}"></td>
                                </tr>
                            </tbody>
                        </table>

                        <div class="row proposal-input-main">
                            <div class="col-xs-12 col-md-6">
                                <input class="item_price" data-quantity="{{ $item->quantity }}" data-itemid="{{ $item->id }}" placeholder="Unit Price for each Item (USD)" type="number" min="1" 
                                id="items[{{ $item->id }}][unit_price]" name="items[{{ $item->id }}][unit_price]" 
                                value="{{ old('items.'.$item->id.'.unit_price') ?? $proposal?->items()->where('item_id', $item->id)->first()->price }}" 
                                onchange="return calculateTotal(this, '{{ $item->quantity }}', '{{ $item->id }}');">
                            </div>

                            <div class="col-xs-12 col-md-6">
                                <input placeholder="Total Item Price (USD)" type="text" id="unit_total_price_{{ $item->id }}" readonly>
                            </div>
                        </div>

                        <div class="collapse" id="specs_{{ $item->id }}">
                            <div class="row proposal-input-main col-xs-12 input-item">
                                <textarea name="items[{{ $item->id }}][seller_item_specs]" id="items[{{ $item->id }}][seller_item_specs]" placeholder="Technical Specifications By Seller (Optional)"></textarea>
                            </div>
                            <label>Technical Specifications</label><br>
                            {{ $item->specs }}
                        </div>

                    </div>
                    @endforeach
                </div>
            </div>

            <div class="col-xs-12 remove-padding">
                <button type="submit">Next / Add General Details</button>
            </div>
        </form>
    </div>
</div>

@endsection

@section('script')

<script type="text/javascript">
    $(document).ready(function() {
        $(".item_price").each(function() {
            var val = $(this);
            var quantity = $(this).data("quantity");
            var itemId = $(this).data("itemid");
            if (val.val() >= 1) {
                calculateTotal(val, quantity, itemId);
            }
        });
    });

    function calculateTotal(unitPrice, quantity, item) {
        var price = parseInt(unitPrice.value, 10);
        var total = price * quantity;
        $('#unit_total_price_' + item).val(total);
    }

</script>

@endsection
