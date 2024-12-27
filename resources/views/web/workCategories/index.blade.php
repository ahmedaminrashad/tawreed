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
            <h1>Category</h1>
        </div>

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
