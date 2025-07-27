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
                        <label for="item[{{ $count }}][name]">{{ __('web.item_name') }}</label>
                        <input type="text" name="item[{{ $count }}][name]" id="item[{{ $count }}][name]" value="{{ $item->name }}">
                    </div>

                    <div class="col-md-6 col-xs-12 col-sm-12 input-item unit_div  @if($errors->has('unit_id')) error @endif">
                        <label for="item[{{ $count }}][unit_id]">{{ __('web.choose_measurement_unit') }}</label>
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
                        <label for="item[{{ $count }}][quantity]">{{ __('web.item_quantity') }}</label>
                        <input type="number" min="1" name="item[{{ $count }}][quantity]" id="item[{{ $count }}][quantity]" value="{{ $item->quantity }}">
                    </div>

                    <div class="col-xs-12 input-item">
                        <label for="item[{{ $count }}][specs]">{{ __('web.technical_specifications_optional') }}</label>
                        <textarea name="item[{{ $count }}][specs]" id="item[{{ $count }}][specs]">{{ $item->specs }}</textarea>
                    </div>

                    <div class="col-xs-12 upload-main">
                        <label for="item[{{ $count }}][media]">{{ __('web.illustrative_images_and_files') }}</label>
                        <input type="file" multiple name="item[{{ $count }}][media][]" id="item[{{ $count }}][media]" class="demo1">
                    </div>

                </div>
                @empty
                <div id="item_div_1" class="col-xs-12 inputs-group">
                    <h2>
                        {{ __('web.item') }} 1
                    </h2>
                    <div class="col-md-6 col-xs-12 col-sm-12 input-item">
                        <label for="item[1][name]">{{ __('web.item_name') }}</label>
                        <input type="text" name="item[1][name]" id="item[1][name]">
                    </div>

                    <div class="col-md-6 col-xs-12 col-sm-12 input-item unit_div  @if($errors->has('unit_id')) error @endif">
                        <label for="item[1][unit_id]">{{ __('web.choose_measurement_unit') }}</label>
                        <select class="Choose-country" name="item[1][unit_id]" id="item[1][unit_id]">
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
                        <label for="item[1][quantity]">{{ __('web.item_quantity') }}</label>
                        <input type="number" min="1" name="item[1][quantity]" id="item[1][quantity]">
                    </div>

                    <div class="col-xs-12 input-item">
                        <label for="item[1][specs]">{{ __('web.technical_specifications_optional') }}</label>
                        <textarea name="item[1][specs]" id="item[1][specs]"></textarea>
                    </div>

                    <div class="col-xs-12 upload-main">
                        <label for="item[1][media]">{{ __('web.illustrative_images_and_files') }}</label>
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
            dropdownCssClass: "country-select",
            dir: "{{app()->getLocale() == 'ar'?'rtl':'ltr'}}"
        });




            $(`.demo1`).uploader({
                ajaxConfig: {
                    url:  "{{route('tenders.items.store.file')}}",
                    method: "post",
                    paramsBuilder: function (uploaderFile) {
                        let form = new FormData();
                        form.append("file", uploaderFile.file)
                        form.append("_token", "{{csrf_token()}}")
                        return form
                    },
                    ajaxRequester: function (config, uploaderFile, progressCallback, successCallback, errorCallback) {
                        $.ajax({
                            url: config.url,
                            contentType: false,
                            processData: false,
                            method: config.method,
                            data: config.paramsBuilder(uploaderFile),
                            success: function (response) {
                                console.info('call success')
                                console.info(response)
                                successCallback(response)
                            },
                            error: function (response) {
                                console.error("Error", response)
                                errorCallback("Error")
                            },
                            xhr: function () {
                                let xhr = new XMLHttpRequest();
                                xhr.upload.addEventListener('progress', function (e) {
                                    let progressRate = (e.loaded / e.total) * 100;
                                    progressCallback(progressRate)
                                })
                                return xhr;
                            }
                        })
                    },
                    responseConverter: function (uploaderFile, response) {
                        return {
                            url: response?.data?.link, //make sure to return the image url
                            name: null,
                        }
                    },
                },
                multiple: true,
            }).on("file-remove",function(_,file) {
                console.log(file.url)
                var data = new FormData();
                data.append( 'url', file.url);
                data.append( 'tender', {{$tender->id}});
                $.ajax({
                    url: "{{route('tenders.items.store.file')}}",
                    contentType: false,
                    processData: false,
                    method: 'post',
                    data: data,
                    success: function (response) {
                        console.info('call success')
                        console.info(response)
                    }}
                );
            })



    });

    $(".add-item-btn").click(function() {
        let itemNumber = count + 1;
        let item = `<div id="item_div_${itemNumber}" class="col-xs-12 inputs-group">
           <h2>
                    {{ __('web.item') }} ${itemNumber}
                    <a href="javascript:void(0);" onclick="deleteDiv(${itemNumber});"><i class="ri-delete-bin-line"></i></a>
                </h2>
            <div class="col-md-6 col-xs-12 col-sm-12 input-item">
                <label for="item[${itemNumber}][name]">{{ __('web.item_name') }}</label>
                <input type="text" name="item[${itemNumber}][name]" id="item[${itemNumber}][name]">
            </div>
            <div class="col-md-6 col-xs-12 col-sm-12 input-item unit_div">
                <label for="item[${itemNumber}][unit_id]">{{ __('web.choose_measurement_unit') }}</label>
                <select class="Choose-country" name="item[${itemNumber}][unit_id]" id="item[${itemNumber}][unit_id]">
                    <option value="">{{ __('web.choose_measurement_unit') }}</option>
                    @foreach($units as $unitID => $unit)
                    <option value="{{ $unitID }}">{{ $unit }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6 col-xs-12 col-sm-12 input-item">
                <label for="item[${itemNumber}][quantity]">{{ __('web.item_quantity') }}</label>
                <input type="number" min="1" name="item[${itemNumber}][quantity]" id="item[${itemNumber}][quantity]">
            </div>
            <div class="col-xs-12 input-item">
                <label for="item[${itemNumber}][specs]">{{ __('web.technical_specifications_optional') }}</label>
                <textarea name="item[${itemNumber}][specs]" id="item[${itemNumber}][specs]"></textarea>
            </div>
            <div class="col-xs-12 upload-main">
                <label for="item[${itemNumber}][media]">{{ __('web.illustrative_images_and_files') }}</label>
                <input type="file" multiple name="item[${itemNumber}][media][]" id="item[${itemNumber}][media]" class="demo1">
            </div>
        </div>`;
        count = itemNumber;
        $('#items_div').append(item);

        $('.Choose-country').select2({
            dropdownCssClass: "country-select",
            dir: "{{app()->getLocale() == 'ar'?'rtl':'ltr'}}"
        });


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
