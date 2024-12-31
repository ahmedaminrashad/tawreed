@extends('web.layouts.master')

@section('title', 'Create Tender - Add Item(s)')

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
            <li>
                <p>Create Tender - Add Item(s)</p>
            </li>
        </ul>
    </div>
    <div class="container remove-padding add-tender-main">
        <div class="col-xs-12">
            <h1>Create New Tender Bid - Add Item(s)</h1>
        </div>
        <div class="col-xs-12 tender-steps-head">
            <div class="col-md-4 done">
                <span><i class="ri-check-line"></i></span>
                <h4>General info</h4>
                <p>Add info about your Tender</p>
                <i class="ri-arrow-right-s-line"></i>
            </div>
            <div class="col-md-4 active">
                <span>2</span>
                <h4>Add Item(s)</h4>
                <p>Add one Item or more with details</p>
                <i class="ri-arrow-right-s-line"></i>
            </div>
            <div class="col-md-4 ">
                <span>3</span>
                <h4>Preview</h4>
                <p>Review your Tender info before publish</p>
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

        <form id="add-item-form" action="{{ route('tenders.items.store', ['tender' => $tender]) }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div id="items_div">
                <div class="col-xs-12 inputs-group">
                    <h2>Item 1</h2>
                    <div class="col-md-6 col-xs-12 col-sm-12 input-item">
                        <input type="text" name="item[1][name]" id="item[1][name]" placeholder="Item name">
                    </div>

                    <div class="col-md-6 col-xs-12 col-sm-12 input-item unit_div  @if($errors->has('unit_id')) error @endif"">
                    <select class=" Choose-country" name="item[1][unit_id]" id="item[1][unit_id]">
                        <option value="">Choose Measurement Unit</option>
                        @foreach($units as $unitID => $unit)
                        <option value="{{ $unitID }}" @selected(old('item.1.unit_id')==$unitID)>{{ $unit }}</option>
                        @endforeach
                        </select>
                        @if($errors->has('unit_id'))
                        <p>{{ $errors->first('unit_id') }}</p>
                        @endif
                    </div>

                    <div class="col-md-6 col-xs-12 col-sm-12 input-item">
                        <input type="number" min="1" name="item[1][quantity]" id="item[1][quantity]" placeholder="Item Quantity">
                    </div>

                    <div class="col-xs-12 input-item">
                        <textarea name="item[1][specs]" id="item[1][specs]" placeholder="Technical Specifications (Optional)"></textarea>
                    </div>

                    <div class="col-xs-12 upload-main">
                        <p>Illustrative Images and files Max 50 MB for all files( optional) </p>
                        <input type="text" name="item[1][media][]" id="item[1][media]" class="demo1">
                    </div>

                </div>
            </div>

            <div class="col-xs-12 remove-padding">
                <a class="add-item-btn"><i class="ri-add-circle-line"></i> Add New Item</a>
            </div>

            <div class="col-xs-12 remove-padding">
                <button type="submit">Next / Preview Tender before Publish</button>
                <a href="{{ route('tenders.create', ['tender' => $tender]) }}" class="back-btn">Back</a>
            </div>
        </form>
    </div>
</div>
@endsection

@section('script')

<script type="text/javascript">
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
        let itemNumber = $(".inputs-group").length + 1;
        let item = `
            <div class="col-xs-12 inputs-group">
                <h2>Item ${itemNumber}</h2>
                <div class="col-md-6 col-xs-12 col-sm-12 input-item">
                    <input type="text" name="item[${itemNumber}][name]" id="item[${itemNumber}][name]" placeholder="Item name">
                </div>

                <div class="col-md-6 col-xs-12 col-sm-12 input-item unit_div">
                    <select class="Choose-country" name="item[${itemNumber}][unit_id]" id="item[${itemNumber}][unit_id]">
                        <option value="">Choose Measurement Unit</option>
                        @foreach($units as $unitID => $unit)
                        <option value="{{ $unitID }}">{{ $unit }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-6 col-xs-12 col-sm-12 input-item">
                    <input type="number" min="1" name="item[${itemNumber}][quantity]" id="item[${itemNumber}][quantity]" placeholder="Item Quantity">
                </div>

                <div class="col-xs-12 input-item">
                    <textarea name="item[${itemNumber}][specs]" id="item[${itemNumber}][specs]" placeholder="Technical Specifications (Optional)"></textarea>
                </div>

                <div class="col-xs-12 upload-main">
                    <p>Illustrative Images and files Max 50 MB for all files( optional) </p>
                    <input type="text" name="item[${itemNumber}][media][]" id="item[${itemNumber}][media]" class="demo1">
                </div>
            </div>
        `;

        // $(".remove-padding").before(item);
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

</script>

@endsection
