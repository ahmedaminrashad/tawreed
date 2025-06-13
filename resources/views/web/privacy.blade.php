@extends('web.layouts.master')

@section('title', __('web.privacy_policy'))

@section('content')
<div class="container-fluid body remove-padding">

    <div class="container stie-map">
        <ul>
            <li><a href="{{ route('contact') }}">@lang('web.tenders')</a></li>
            <li><span>/</span></li>
            <li>
                <p>@lang('web.privacy_policy')</p>
            </li>
        </ul>
    </div>

    <div class="container remove-padding about-main">
        <div class="col-xs-12 contact-section">

            <h1>@lang('web.privacy_policy')</h1>

            <p>@lang('web.privacy_policy_content')</p>

            {!! $privacy_policy !!}
        </div>
    </div>
</div>
@endsection

@section('script')

<script type="text/javascript">
    $(document).ready(function() {});

</script>

@endsection
