@extends('web.layouts.master')

@section('title', 'Terms & Conditions')

@section('content')
<div class="container-fluid body remove-padding">

    <div class="container stie-map">
        <ul>
            <li><a href="{{ route('contact') }}">Home</a></li>
            <li><span>/</span></li>
            <li>
                <p>Terms & Conditions</p>
            </li>
        </ul>
    </div>

    <div class="container remove-padding about-main">
        <div class="col-xs-12 contact-section">

            <h1>Terms & Conditions</h1>
            
            {!! $terms_conditions !!}
        </div>
    </div>
</div>
@endsection

@section('script')

<script type="text/javascript">
    $(document).ready(function() {});

</script>

@endsection
