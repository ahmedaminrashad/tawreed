@extends('web.layouts.master')

@section('title', 'All Categories')

@section('content')
<div class="container-fluid body remove-padding">

    <div class="container stie-map">
        <ul>
            <li><a href="{{ route('home') }}">Home</a></li>
            <li><span>/</span></li>
            <li>
                <p>Explorer by Category</p>
            </li>
        </ul>
    </div>

    <div class="container remove-padding categories-main margin-section all-categories">
        <div class="col-xs-12 title">
            <h1>التصنيفات</h1>
        </div>

        <p>موليت في لابوروم تيمبور لوريم إنسيديدونت إيرور. أوتي إيو إكس أد سونت. بارياتور سينت كولبا دو إنسيديدونت إيوسمود إيوسمود كولبا. لابوروم تيمبور لوريم إنسيديدونت.</p>

        @foreach($workCategories as $categoryID => $categoryName)
        <div class="col-md-4 col-sm-6 col-xs-12">
            <div class="col-xs-12 category-item">
                <img src="{{ asset('/assets/front/img/1.png') }}">
                <a class="link-style">{{ $categoryName }}</a>
                <p>357 Open Tender</p>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection

@section('script')

<script type="text/javascript">
    $(document).ready(function() {});

</script>

@endsection
