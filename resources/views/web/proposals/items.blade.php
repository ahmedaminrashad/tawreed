@extends('web.layouts.master')

@section('title', __('web.create_proposal') . ' - ' . __('web.add_items'))

@section('head')
<style>
</style>
@endsection

@section('content')
<div class="container-fluid body remove-padding">
    <div class="container stie-map">
        <ul>
            <li><a href="{{ route('home') }}">{{ __('web.tenders') }}</a></li>
            <li><span>/</span></li>
            <li><a href="{{ route('tenders.index') }}">{{ __('web.tenders') }}</a></li>
            <li><span>/</span></li>
            <li><a href="{{ route('tenders.show', ['tender' => $tender->id]) }}">{{ __('web.show_tender') }} - {{ $tender->subject }}</a></li>
            <li><span>/</span></li>
            <li>
                <p>{{ __('web.create_proposal') }} - {{ __('web.add_items') }}</p>
            </li>
        </ul>
    </div>

    <div class="container remove-padding add-tender-main add-tender-review">
        <div class="col-xs-12">
            <h1>{{ __('web.send_proposal_to') }} <span>( {{ $tender->subject . ' . ' . $tender->tender_uuid }} )</span></h1>
        </div>
        <div class="col-xs-12 tender-steps-head">
            <div class="col-md-4 active">
                <span>1</span>
                <h4>{{ __('web.item_price') }}</h4>
                <p>{{ __('web.unit_price_for_each_item') }}</p>
                <i class="ri-arrow-right-s-line"></i>
            </div>

            <div class="col-md-4">
                <span>2</span>
                <h4>{{ __('web.general_info') }}</h4>
                <p>{{ __('web.add_details_of_proposal') }}</p>
                <i class="ri-arrow-right-s-line"></i>
            </div>

            <div class="col-md-4">
                <span>3</span>
                <h4>{{ __('web.preview') }}</h4>
                <p>{{ __('web.review_proposal_info_before_publish') }}</p>
                <i class="ri-arrow-right-s-line"></i>
            </div>
        </div>

        @include('web.layouts.flash_msg')

        @if ($errors->any())
        
        <div class="col-xs-12 error" style="margin-top: 15px">
            <p style="color: red;">{{ __('web.error_adding_tender_items') }}</p>
        </div>
        @endif

        <form id="add-item-form" action="{{ route('tenders.proposals.items.store', ['tender' => $tender, 'proposal' => $proposal]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="col-md-12 col-xs-12">

                <div class="review-item col-xs-12 remove-padding">
                    <div class="review-item-title col-xs-12">
                        <h4>{{ __('web.items_list') }} <span>( {{ $tender->items()->count() }} {{ __('web.items') }} )</span></h4>
                    </div>

                    @foreach($tender->items as $key => $item)
                    <div class="col-xs-12 table-item">

                        <table>
                            <thead>
                                <tr>
                                    <th>{{ __('web.number_sign') }}</th>
                                    <th>{{ __('web.item_name') }}</th>
                                    <th>{{ __('web.unit') }}</th>
                                    <th>{{ __('web.quantity') }}</th>
                                    <th>{{ __('web.dash') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td data-label="{{ __('web.number_sign') }}">{{ $key + 1 }}</td>
                                    <td data-label="{{ __('web.item_name') }}">{{ $item->name }}</td>
                                    <td data-label="{{ __('web.unit') }}">{{ $item->unit->translate('ar')->name }}</td>
                                    <td data-label="{{ __('web.quantity') }}">{{ $item->quantity }}</td>
                                    <td data-label="{{ __('web.dash') }}" class="collapsed toggle-collapse" data-toggle="collapse" data-target="#specs_{{ $item->id }}"></td>
                                </tr>
                            </tbody>
                        </table>

                        <div class="row proposal-input-main">
                            <div class="col-xs-12 col-md-6">
                                <label for="items[{{ $item->id }}][unit_price]">{{ __('web.unit_price_for_each_item_usd') }}</label>
                                <input class="item_price" step="0.01" data-quantity="{{ $item->quantity }}" data-itemid="{{ $item->id }}"  type="number" min="1" 
                                id="items[{{ $item->id }}][unit_price]" name="items[{{ $item->id }}][unit_price]" 
                                value="{{ old('items.'.$item->id.'.unit_price') ?? $proposal?->items()->where('item_id', $item->id)->first()->price }}" 
                                onchange="return calculateTotal(this, '{{ $item->quantity }}', '{{ $item->id }}');">
                            </div>

                            <div class="col-xs-12 col-md-6">
                                <label for="unit_total_price_{{ $item->id }}">{{ __('web.total_item_price_usd') }}</label>
                                <input  type="text" id="unit_total_price_{{ $item->id }}" readonly>
                            </div>
                        </div>

                        <div class="collapse" id="specs_{{ $item->id }}">
                            <div class="row proposal-input-main col-xs-12 input-item">
                                <label for="items[{{ $item->id }}][seller_item_specs]">{{ __('web.technical_specs_by_seller_optional') }}</label>
                                <textarea name="items[{{ $item->id }}][seller_item_specs]" id="items[{{ $item->id }}][seller_item_specs]"></textarea>
                            </div>
                            <label>{{ __('web.technical_specifications') }}</label><br>
                            {{ $item->specs }}
                        </div>

                    </div>
                    @endforeach
                </div>
            </div>

            <div class="col-xs-12 remove-padding">
                <button type="submit">{{ __('web.next_add_general_details') }}</button>
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
        var price = parseFloat(unitPrice.value, 10);
        var total = price * quantity;
        $('#unit_total_price_' + item).val(total);
    }

</script>

@endsection
