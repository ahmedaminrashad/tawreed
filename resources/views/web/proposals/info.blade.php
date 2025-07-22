@extends('web.layouts.master')

@section('title', __('web.create_proposal') . ' - ' . __('web.add_general_details'))

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
                <p>{{ __('web.create_proposal') }} - {{ __('web.add_general_details') }}</p>
            </li>
        </ul>
    </div>

    <div class="container remove-padding add-tender-main add-tender-review">
        <div class="col-xs-12">
            <h1>{{ __('web.send_proposal_to') }} <span>( {{ $tender->subject . ' . ' . $tender->tender_uuid }} )</span></h1>
        </div>
        <div class="col-xs-12 tender-steps-head">
            <div class="col-md-4 done">
                <span><i class="ri-check-line"></i></span>
                <h4>{{ __('web.item_price') }}</h4>
                <p>{{ __('web.unit_price_for_each_item') }}</p>
                <i class="ri-arrow-right-s-line"></i>
            </div>
            <div class="col-md-4 active">
                <span>2</span>
                <h4>{{ __('web.general_info') }}</h4>
                <p>{{ __('web.add_details_of_proposal') }}</p>
                <i class="ri-arrow-right-s-line"></i>
            </div>
            <div class="col-md-4 ">
                <span>3</span>
                <h4>{{ __('web.preview') }}</h4>
                <p>{{ __('web.review_proposal_info_before_publish') }}</p>
                <i class="ri-arrow-right-s-line"></i>
            </div>
        </div>

        <form id="add-item-form" action="{{ route('tenders.proposals.info.store', ['tender' => $tender, 'proposal' => $proposal]) }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="col-xs-12 inputs-group">
                <div class="col-md-6 col-xs-12 col-sm-12 input-item">
                    <label for="total">{{ __('web.proposal_total_price') }}</label>
                    <input type="text" name="total" id="total" value="{{ $proposal->total }}" readonly>
                </div>

                <div class="col-md-6 col-xs-12 col-sm-12 input-item datepicker-input">
                    <label for="proposal_end_date">{{ __('web.proposal_validity_period') }}</label>
                    <input type="text" name="proposal_end_date" id="proposal_end_date" class="date-picker" value="{{ old('proposal_end_date') ?? $proposal->proposal_end_date }}">
                    <i class="ri-calendar-line"></i>
                    @if($errors->has('proposal_end_date'))
                    <p>{{ $errors->first('proposal_end_date') }}</p>
                    @endif
                </div>

                <div class="col-md-6 col-xs-12 col-sm-12 input-item">
                    <label for="tender_contract_duration">{{ __('web.contract_duration_by_buyer') }}</label>
                    <input type="number" name="tender_contract_duration" id="tender_contract_duration" value="{{ $tender->contract_duration }}" min="1" readonly >
                </div>

                <div class="col-md-6 col-xs-12 col-sm-12 input-item">
                    <label for="contract_duration">{{ __('web.contract_duration_by_seller') }}</label>
                    <input type="number" name="contract_duration" id="contract_duration" value="{{  $proposal->contract_duration??$tender->contract_duration }}" min="1">
                </div>

                <div class="col-xs-12 input-item">
                    <label for="payment_terms">{{ __('web.payment_terms') }}</label>
                    <textarea id="payment_terms" name="payment_terms">{{ old('payment_terms') ?? $proposal->payment_terms }}</textarea>
                </div>

                <div class="col-xs-12 input-item">
                    <label for="proposal_desc">{{ __('web.proposal_description') }}</label>
                    <textarea id="proposal_desc" name="proposal_desc">{{ old('proposal_desc') ?? $proposal->proposal_desc }}</textarea>
                </div>

                <div class="col-xs-12 upload-main">
                    <label for="proposal_files">{{ __('web.illustrative_images_files') }}</label>
                    <input type="file" multiple class="demo" id="proposal_files" value="">
                </div>

                <div class="col-xs-12 add-prop-check">
                    <label class="checkbox-item">
                        {{ __('web.allow_announcement') }}
                        <input type="checkbox" id="allow_announcement" name="allow_announcement" value="1" {{ old('allow_announcement', $proposal->allow_announcement) == 1 ? 'checked' : '' }}>
                        <span class="checkmark"></span>
                    </label>
                </div>
            </div>

            <div class="col-xs-12 remove-padding">
                <button>{{ __('web.next_preview_before_submit') }}</button>
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
