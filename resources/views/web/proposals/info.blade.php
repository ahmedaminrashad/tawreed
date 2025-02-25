@extends('web.layouts.master')

@section('title', 'Create Proposal - Add General Details')

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
                <p>Create Proposal - Add General Details</p>
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
            <div class="col-md-4 active">
                <span>2</span>
                <h4>General info</h4>
                <p>Add Details of your Proposal</p>
                <i class="ri-arrow-right-s-line"></i>
            </div>
            <div class="col-md-4 ">
                <span>3</span>
                <h4>Preview</h4>
                <p>Review your Proposal info before Publish</p>
                <i class="ri-arrow-right-s-line"></i>
            </div>
        </div>

        <form id="add-item-form" action="{{ route('tenders.proposals.info.store', ['tender' => $tender, 'proposal' => $proposal]) }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="col-xs-12 inputs-group">
                <div class="col-md-6 col-xs-12 col-sm-12 input-item">
                    <input type="text" name="total" id="total" placeholder="Proposal total price ( sum of all items )" value="{{ $proposal->total }}" readonly>
                </div>

                <div class="col-md-6 col-xs-12 col-sm-12 input-item datepicker-input">
                    <input type="text" name="proposal_end_date" id="proposal_end_date" class="date-picker" value="{{ old('proposal_end_date') ?? $proposal->proposal_end_date }}" placeholder="The Proposal Validity Period">
                    <i class="ri-calendar-line"></i>
                    @if($errors->has('proposal_end_date'))
                    <p>{{ $errors->first('proposal_end_date') }}</p>
                    @endif
                </div>

                <div class="col-md-6 col-xs-12 col-sm-12 input-item">
                    <input type="number" name="contract_duration" id="contract_duration" placeholder="Contract Duration By Buyer" value="{{ old('contract_duration') ?? $proposal->contract_duration }}" min="1">
                </div>

                <div class="col-md-6 col-xs-12 col-sm-12 input-item">
                    <input type="number" name="tender_contract_duration" id="tender_contract_duration" placeholder="Contract Duration By Buyer" value="{{ $tender->contract_duration }}" min="1" readonly >
                </div>

                <div class="col-xs-12 input-item">
                    <textarea id="payment_terms" name="payment_terms" placeholder="Payment Terms ( “NA” if there is no Payment Terms ).">{{ old('payment_terms') ?? $proposal->payment_terms }}</textarea>
                </div>

                <div class="col-xs-12 input-item">
                    <textarea id="proposal_desc" name="proposal_desc" placeholder="Proposal Description">{{ old('proposal_desc') ?? $proposal->proposal_desc }}</textarea>
                </div>

                <div class="col-xs-12 upload-main">
                    <p>Illustrative Images and files Max 50 MB for all files( optional) </p>
                    <input type="file" multiple class="demo" value="">
                </div>

                <div class="col-xs-12 add-prop-check">
                    <label class="checkbox-item">
                        Allow Announcement by check this it display the tender bid results in the Announcement section in the homepage if it's
                        awarded to this seller.
                        <input type="checkbox" id="allow_announcement" name="allow_announcement" value="1" {{ old('allow_announcement', $proposal->allow_announcement) == 1 ? 'checked' : '' }}>
                        <span class="checkmark"></span>
                    </label>
                </div>
            </div>

            <div class="col-xs-12 remove-padding">
                <button>Next / Preview before submit</button>
            </div>
        </form>
    </div>
</div>

@endsection

@section('script')

<script type="text/javascript">
    $(document).ready(function() {
        $(".date-picker").datepicker({
            changeMonth: true
            , changeYear: true
            , minDate: 1
        , });
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

    $(".demo").uploader({
        multiple: true
        , ajaxConfig: ajaxConfig
        , autoUpload: false
    });

</script>

@endsection
