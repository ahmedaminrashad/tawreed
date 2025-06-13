@extends('web.layouts.master')

@section('title', __('web.categories'))

@section('content')
<div class="container-fluid body remove-padding">

    <div class="container stie-map">
        <ul>
            <li><a href="{{ route('home') }}">{{ __('web.tenders') }}</a></li>
            <li><span>/</span></li>
            <li>
                <p>{{ __('web.explore_by_category') }}</p>
            </li>
        </ul>
    </div>

    <div class="container remove-padding categories-main margin-section all-categories">
        <div class="col-xs-12 title">
            <h1>{{ __('web.categories') }}</h1>
        </div>

        <p>{{ __('web.footer_description') }}</p>

        @foreach($workCategories as $categoryID => $categoryName)
        <div class="col-md-4 col-sm-6 col-xs-12">
            <div class="col-xs-12 category-item">
                <img src="{{ asset('/assets/front/img/1.png') }}">
                <a class="link-style">{{ $categoryName }}</a>
                <p>357 {{ __('web.tenders') }}</p>
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
