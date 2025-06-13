@extends('web.layouts.master')

@section('title', __('web.create_tender_add_items'))

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
            <li><a href="{{ route('home') }}">{{ __('web.home') }}</a></li>
            <li><span>/</span></li>
            <li>
                <p>{{ __('web.create_tender_add_items') }}</p>
            </li>
        </ul>
    </div>
    <div class="container remove-padding add-tender-main">
        <div class="col-xs-12">
            <h1>{{ __('web.create_new_tender_bid_add_items') }}</h1>
        </div>

        <div class="col-xs-12 tender-steps-head">
            <div class="col-md-4 done">
                <span><i class="ri-check-line"></i></span>
                <h4>{{ __('web.general_info') }}</h4>
                <p>{{ __('web.add_info_about_tender') }}</p>
                <i class="ri-arrow-right-s-line"></i>
            </div>
            <div class="col-md-4 active">
                <span>2</span>
                <h4>{{ __('web.add_items') }}</h4>
                <p>{{ __('web.add_one_or_more_items') }}</p>
                <i class="ri-arrow-right-s-line"></i>
            </div>
            <div class="col-md-4 ">
                <span>3</span>
                <h4>{{ __('web.preview') }}</h4>
                <p>{{ __('web.review_tender_info_before_publish') }}</p>
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

        <form id="add-item-form" action="{{ route('tenders.items.store', ['tender' => $tender]) }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div id="items_div">
                @forelse($tender->items as $key => $item)
                @php
                $count = $key + 1;
                @endphp
                <div id="item_div_{{ $count }}" class="col-xs-12 inputs-group">
                    @if($count == 1)
                    <h2>
                        {{ __('web.item') }} {{ $count }}
                    </h2>
                    @else
                    <h2>
                        {{ __('web.item') }} {{ $count }}
                        <a href="javascript:void(0);" onclick="deleteDiv({{ $count }});"><i class="ri-delete-bin-line"></i></a>
                    </h2>
                    @endif
                    <div class="col-md-6 col-xs-12 col-sm-12 input-item">
                        <input type="text" name="item[{{ $count }}][name]" id="item[{{ $count }}][name]" placeholder="{{ __('web.item_name') }}" value="{{ $item->name }}">
                    </div>

                    <div class="col-md-6 col-xs-12 col-sm-12 input-item unit_div  @if($errors->has('unit_id')) error @endif">
                        <select class=" Choose-country" name="item[{{ $count }}][unit_id]" id="item[{{ $count }}][unit_id]">
                            <option value="">{{ __('web.choose_measurement_unit') }}</option>
                            @foreach($units as $unitID => $unit)
                            <option value="{{ $unitID }}" @selected($item->unit_id == $unitID)>{{ $unit }}</option>
                            @endforeach
                        </select>
                        @if($errors->has('unit_id'))
                        <p>{{ $errors->first('unit_id') }}</p>
                        @endif
                    </div>

                    <div class="col-md-6 col-xs-12 col-sm-12 input-item">
                        <input type="number" min="1" name="item[{{ $count }}][quantity]" id="item[{{ $count }}][quantity]" placeholder="{{ __('web.item_quantity') }}" value="{{ $item->quantity }}">
                    </div>

                    <div class="col-xs-12 input-item">
                        <textarea name="item[{{ $count }}][specs]" id="item[{{ $count }}][specs]" placeholder="{{ __('web.technical_specifications_optional') }}">{{ $item->specs }}</textarea>
                    </div>

                    <div class="col-xs-12 upload-main">
                        <p>{{ __('web.illustrative_images_and_files') }}</p>
                        <input type="file" multiple name="item[{{ $count }}][media][]" id="item[{{ $count }}][media]" class="demo1">
                    </div>

                </div>
                @empty
                <div id="item_div_1" class="col-xs-12 inputs-group">
                    <h2>{{ __('web.item') }} 1</h2>
                    <div class="col-md-6 col-xs-12 col-sm-12 input-item">
                        <input type="text" name="item[1][name]" id="item[1][name]" placeholder="{{ __('web.item_name') }}">
                    </div>

                    <div class="col-md-6 col-xs-12 col-sm-12 input-item unit_div  @if($errors->has('unit_id')) error @endif"">
                    <select class=" Choose-country" name="item[1][unit_id]" id="item[1][unit_id]">
                        <option value="">{{ __('web.choose_measurement_unit') }}</option>
                        @foreach($units as $unitID => $unit)
                        <option value="{{ $unitID }}" @selected(old('item.1.unit_id')==$unitID)>{{ $unit }}</option>
                        @endforeach
                        </select>
                        @if($errors->has('unit_id'))
                        <p>{{ $errors->first('unit_id') }}</p>
                        @endif
                    </div>

                    <div class="col-md-6 col-xs-12 col-sm-12 input-item">
                        <input type="number" min="1" name="item[1][quantity]" id="item[1][quantity]" placeholder="{{ __('web.item_quantity') }}">
                    </div>

                    <div class="col-xs-12 input-item">
                        <textarea name="item[1][specs]" id="item[1][specs]" placeholder="{{ __('web.technical_specifications_optional') }}"></textarea>
                    </div>

                    <div class="col-xs-12 upload-main">
                        <p>{{ __('web.illustrative_images_and_files') }}</p>
                        <input type="file" multiple name="item[1][media][]" id="item[1][media]" class="demo1">
                    </div>

                </div>
                @endforelse
            </div>

            <div class="col-xs-12 remove-padding">
                <a class="add-item-btn link-style"><i class="ri-add-circle-line"></i> {{ __('web.add_new_item') }}</a>
            </div>

            <div class="col-xs-12 remove-padding">
                <button type="submit">{{ __('web.next_preview_tender_before_publish') }}</button>
                <a href="{{ route('tenders.create', ['tender' => $tender]) }}" class="back-btn">{{ __('web.back') }}</a>
            </div>
        </form>
    </div>
</div>
@endsection

@section('script')

<script type="text/javascript">
    var count = parseInt("{{ $tender->items()->count() }}") != 0 ? parseInt("{{ $tender->items()->count() }}") : 1;

    $(document).ready(function() {

        $(".close-btn").click(function() {
            $(".dropdown.open").removeClass("open");
            $('.mobile-menu-btn').removeClass('hide');
        });

        $('.Choose-country').select2({
            dropdownCssClass: "country-select"
        });

        let ajaxConfig = {
            ajaxRequester: function(config, uploadFile, pCall, sCall, eCall) {
                let progress = 0
                let interval = setInterval(() => {
                    progress += 10;
                    pCall(progress)
                    if (progress >= 100) {
                        clearInterval(interval)
                        const windowURL = window.URL || window.webkitURL;
                        sCall({
                            data: windowURL.createObjectURL(uploadFile.file)
                        })
                    }
                }, 300)
            }
        }

        $(".demo1").uploader({
            multiple: true
            , ajaxConfig: ajaxConfig
            , autoUpload: false
        })
    });

    $(".add-item-btn").click(function() {
        let itemNumber = count + 1;
        let item = `
            <div id="item_div_${itemNumber}" class="col-xs-12 inputs-group">
                <h2>
                    {{ __('web.item') }} ${itemNumber}
                    <a href="javascript:void(0);" onclick="deleteDiv(${itemNumber});"><i class="ri-delete-bin-line"></i></a>
                </h2>
                <div class="col-md-6 col-xs-12 col-sm-12 input-item">
                    <input type="text" name="item[${itemNumber}][name]" id="item[${itemNumber}][name]" placeholder="{{ __('web.item_name') }}">
                </div>

                <div class="col-md-6 col-xs-12 col-sm-12 input-item unit_div">
                    <select class="Choose-country" name="item[${itemNumber}][unit_id]" id="item[${itemNumber}][unit_id]">
                        <option value="">{{ __('web.choose_measurement_unit') }}</option>
                        @foreach($units as $unitID => $unit)
                        <option value="{{ $unitID }}">{{ $unit }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-6 col-xs-12 col-sm-12 input-item">
                    <input type="number" min="1" name="item[${itemNumber}][quantity]" id="item[${itemNumber}][quantity]" placeholder="{{ __('web.item_quantity') }}">
                </div>

                <div class="col-xs-12 input-item">
                    <textarea name="item[${itemNumber}][specs]" id="item[${itemNumber}][specs]" placeholder="{{ __('web.technical_specifications_optional') }}"></textarea>
                </div>

                <div class="col-xs-12 upload-main">
                    <p>{{ __('web.illustrative_images_and_files') }}</p>
                    <input type="file" multiple name="item[${itemNumber}][media][]" id="item[${itemNumber}][media]" class="demo1">
                </div>
            </div>
        `;

        count = itemNumber;

        $("#items_div").append(item);

        $('.Choose-country').select2({
            dropdownCssClass: "country-select"
        });

        let ajaxConfig = {
            ajaxRequester: function(config, uploadFile, pCall, sCall, eCall) {
                let progress = 0
                let interval = setInterval(() => {
                    progress += 10;
                    pCall(progress)
                    if (progress >= 100) {
                        clearInterval(interval)
                        const windowURL = window.URL || window.webkitURL;
                        sCall({
                            data: windowURL.createObjectURL(uploadFile.file)
                        })
                    }
                }, 300)
            }
        }

        $(".demo1").uploader({
            multiple: true
            , ajaxConfig: ajaxConfig
            , autoUpload: false
        })
    });

    function deleteDiv(count)
    {
        $("#item_div_" + count).remove();
    }

</script>

@endsection
