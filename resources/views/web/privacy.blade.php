@extends('web.layouts.master')

@section('title', 'Privacy Policy')

@section('content')
<div class="container-fluid body remove-padding">

    <div class="container stie-map">
        <ul>
            <li><a href="{{ route('contact') }}">Home</a></li>
            <li><span>/</span></li>
            <li>
                <p>Privacy Policy</p>
            </li>
        </ul>
    </div>

    <div class="container remove-padding about-main">
        <div class="col-xs-12 contact-section">

            <h1>سياسة الخصوصية</h1>

            <p>موليت في لابوروم تيمبور لوريم إنسيديدونت إيرور. أوتي إيو إكس أد سونت. بارياتور سينت كولبا دو إنسيديدونت إيوسمود إيوسمود كولبا. لابوروم تيمبور لوريم إنسيديدونت.</p>

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
