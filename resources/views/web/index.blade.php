@extends('web.layouts.master')

@section('title', __('web.tenders'))

@section('content')
<div class="container-fluid intor-main">
    <img src="{{ asset('/assets/front/img/1.png') }}">
    <div class="container">
        <h1>@lang('web.search_placeholder2')</h1>
        <p>@lang('web.search_placeholder3')</p>
        <p>@lang('web.footer_description')</p>
        <ul class="intor-links">
            @if(!auth('web')->check())
            <li><a class="link-style" data-toggle="modal" data-target="#signUp">{{ __('web.register') }}</a></li>
            @endif
            <li><a class="link-style">{{ __('web.premium') }}</a></li>
        </ul>
        <div class="col-xs-12 col-md-8 col-md-offset-2 serch-bar remove-padding">
            <form>
                <div class="col-md-6">
                    <i></i>
                    <input type="text" placeholder="{{ __('web.search_placeholder') }}">
                </div>
                <div class="col-md-3">
                    <select data-minimum-results-for-search="Infinity" class="js-example-basic-single" name="state">
                        <option value="1">{{ __('web.categories') }}</option>
                        <option value="2">{{ __('web.category_1') }}</option>
                        <option value="3">{{ __('web.category_2') }}</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <button>{{ __('web.tenders') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>

@if(auth('api')->check())
<div class="container users-tenders remove-padding">
    <div class="col-md-6 col-xs-12 col-sm-12">
        <div class="col-xs-12 users-tenders-item">
            <h1>{{ __('web.my_tenders_title') }}</h1>
            <p>{{ __('web.my_tenders_subtitle') }}</p>
            <a href="#">{{ __('web.view_all') }}</a>
            <img src="{{ asset('/assets/front/img/4.svg') }}">
        </div>
    </div>

    <div class="col-md-6 col-xs-12 col-sm-12">
        <div class="col-xs-12 users-tenders-item">
            <h1>{{ __('web.my_proposals_title') }}</h1>
            <p>{{ __('web.my_tenders_subtitle') }}</p>
            <a href="#">{{ __('web.view_all') }}</a>
            <div class="balance-main">
                <h6>{{ __('web.remaining_balance') }}<span><br>340 $ <i title="{{ __('web.payment_area') }}" class="ri-information-fill"></i></span></h6>
                <a href="#">{{ __('web.pay_now') }}</a>
            </div>
            <img src="{{ asset('/assets/front/img/5.svg') }}">
        </div>
    </div>
</div>
@endif

<div class="container remove-padding categories-main">
    <div class="col-xs-12 title">
        <h1>{{ __('web.explore_by_category') }}</h1>
        <a href="{{ route('categories.index') }}">{{ __('web.tenders') }} <i class="ri-arrow-right-line"></i></a>
    </div>
    @foreach($workCategories as $categoryID => $categoryName)
    <div class="col-md-4 col-sm-6 col-xs-12">
        <div class="col-xs-12 category-item">
            <img src="{{ asset('/assets/front/img/1.png') }}">
            <a href="#">{{ $categoryName }}</a>
            <p>357 {{ __('web.open_tenders') }}</p>
        </div>
    </div>
    @endforeach
</div>

<div class="container remove-padding Tender-home Finish-tender">
    <div class="col-xs-12 title">
        <h1>{{ __('web.latest_tenders') }}</h1>
        <a href="#">{{ __('web.view_all') }} <i class="ri-arrow-right-line"></i></a>
    </div>
    <div class="col-md-6 col-xs-12">
        <div class="col-xs-12 Tender-item">
            <h4>{{ __('web.chlorine_removal_agents') }}. 2024010305</h4>
            <span>{{ __('web.home_appliances') }}</span>
            <h3>{{ __('web.contract_duration_in_days') }}: <span>4 {{ __('web.from_in_days') }}</span></h3>
            <div class="clearfix"></div>
            <ul class="col-xs-12 remove-padding">
                <li>
                    <h5>{{ __('web.contract_start_date') }}: <span>01/08/2024</span></h5>
                </li>
                <li>
                    <h5>{{ __('web.contract_end_date') }}: <span>20/08/2024</span></h5>
                </li>
            </ul>
            <div class="clearfix"></div>
            <ul class="col-xs-12 remove-padding">
                <li><i class="ri-map-pin-line"></i>
                    <h5>{{ __('web.location') }}: دكا، بنغلاديش</h5>
                </li>
                <li><i class="ri-function-line"></i>
                    <h5>{{ __('web.supply_implementation') }}</h5>
                </li>
            </ul>
            <div class="clearfix"></div>
            <p>موليت في لابوروم تيمبور لوريم إنسيديدونت إيرور. أوتي إيو إكس أد سونت. بارياتور سينت كولبا دو إنسيديدونت إيوسمود إيوسمود كولبا. لابوروم تيمبور لوريم إنسيديدونت.</p>
            <div class="col-xs-12 remove-padding">
                <div class="Tender-progress">
                    <div style="width:50%;"></div>
                </div>
                <h6>{{ __('web.time_remaining') }}<span>2 {{ __('web.days_before_closing') }}</span></h6>
            </div>
            <div class="col-xs-12 remove-padding">
                <div class="tender-img">
                    <img src="{{ asset('/assets/front/img/1.png') }}">
                    <p>{{ __('web.buyer_name') }} <span>{{ __('web.company_type') }}</span></p>
                </div>
                <a href="#" class="tender-link">{{ __('web.login_to_view_details') }} <i class="ri-lock-line"></i></a>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xs-12">
        <div class="col-xs-12 Tender-item">
            <h4>{{ __('web.chlorine_removal_agents') }}. 2024010305</h4>
            <span>{{ __('web.home_appliances') }}</span>
            <h3>{{ __('web.contract_duration_in_days') }}: <span>4 {{ __('web.from_in_days') }}</span></h3>
            <div class="clearfix"></div>
            <ul class="col-xs-12 remove-padding">
                <li>
                    <h5>{{ __('web.contract_start_date') }}: <span>01/08/2024</span></h5>
                </li>
                <li>
                    <h5>{{ __('web.contract_end_date') }}: <span>20/08/2024</span></h5>
                </li>
            </ul>
            <div class="clearfix"></div>
            <ul class="col-xs-12 remove-padding">
                <li><i class="ri-map-pin-line"></i>
                    <h5>{{ __('web.location') }}: دكا، بنغلاديش</h5>
                </li>
                <li><i class="ri-function-line"></i>
                    <h5>{{ __('web.supply_implementation') }}</h5>
                </li>
            </ul>
            <div class="clearfix"></div>
            <p>موليت في لابوروم تيمبور لوريم إنسيديدونت إيرور. أوتي إيو إكس أد سونت. بارياتور سينت كولبا دو إنسيديدونت إيوسمود إيوسمود كولبا. لابوروم تيمبور لوريم إنسيديدونت.</p>
            <div class="col-xs-12 remove-padding">
                <div class="Tender-progress">
                    <div style="width:50%;"></div>
                </div>
                <h6>{{ __('web.time_remaining') }}<span>2 {{ __('web.days_before_closing') }}</span></h6>
            </div>
            <div class="col-xs-12 remove-padding">
                <div class="tender-img">
                    <img src="{{ asset('/assets/front/img/1.png') }}">
                    <p>{{ __('web.buyer_name') }} <span>{{ __('web.company_type') }}</span></p>
                </div>
                <a href="#" class="tender-link">{{ __('web.login_to_view_details') }} <i class="ri-lock-line"></i></a>
            </div>
        </div>
    </div>
</div>

<div class="container remove-padding Finish-tender">
    <div class="col-xs-12 title">
        <h1>{{ __('web.finished_tenders') }}</h1>
        <a href="#">{{ __('web.view_all') }} <i class="ri-arrow-right-line"></i></a>
    </div>
    <div class="col-md-6 col-xs-12">
        <div class="col-xs-12 Tender-item Finish-tender-item">
            <h4>{{ __('web.chlorine_removal_agents') }}. 2024010305</h4>
            <span>{{ __('web.home_appliances') }}</span>
            <h3>{{ __('web.contract_duration_in_days') }}: <span>4 {{ __('web.from_in_days') }}</span></h3>
            <div class="clearfix"></div>
            <ul class="col-xs-12 remove-padding">
                <li><i class="ri-map-pin-line"></i>
                    <h5>{{ __('web.location') }}: دكا، بنغلاديش</h5>
                </li>
                <li><i class="ri-function-line"></i>
                    <h5>{{ __('web.supply_implementation') }}</h5>
                </li>
            </ul>
            <div class="col-xs-12 remove-padding">
                <div class="row">
                    <div class="col-md-6 col-xs-12">
                        <h2>{{ __('web.seller_name_winner') }}</h2>
                        <div class="tender-img has-rate">
                            <img src="{{ asset('/assets/front/img/1.png') }}">
                            <p>ليزلي ألكسندر</p>
                            <h4>4.8 <i class="ri-star-fill"></i><span>(653)</span></h4>
                        </div>
                    </div>

                    <div class="col-md-6 col-xs-12">
                        <h2>{{ __('web.buyer_name') }}</h2>
                        <div class="tender-img">
                            <img src="{{ asset('/assets/front/img/1.png') }}">
                            <p>{{ __('web.company_type') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-xs-12">
        <div class="col-xs-12 Tender-item Finish-tender-item">
            <h4>{{ __('web.chlorine_removal_agents') }}. 2024010305</h4>
            <span>{{ __('web.home_appliances') }}</span>
            <h3>{{ __('web.contract_duration_in_days') }}: <span>4 {{ __('web.from_in_days') }}</span></h3>
            <div class="clearfix"></div>
            <ul class="col-xs-12 remove-padding">
                <li><i class="ri-map-pin-line"></i>
                    <h5>{{ __('web.location') }}: دكا، بنغلاديش</h5>
                </li>
                <li><i class="ri-function-line"></i>
                    <h5>{{ __('web.supply_implementation') }}</h5>
                </li>
            </ul>
            <div class="col-xs-12 remove-padding">
                <div class="row">
                    <div class="col-md-6 col-xs-12">
                        <h2>{{ __('web.seller_name_winner') }}</h2>
                        <div class="tender-img has-rate">
                            <img src="{{ asset('/assets/front/img/1.png') }}">
                            <p>ليزلي ألكسندر</p>
                            <h4>4.8 <i class="ri-star-fill"></i><span>(653)</span></h4>
                        </div>
                    </div>

                    <div class="col-md-6 col-xs-12">
                        <h2>{{ __('web.buyer_name') }}</h2>
                        <div class="tender-img">
                            <img src="{{ asset('/assets/front/img/1.png') }}">
                            <p>{{ __('web.company_type') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@if((auth('api')->check() && auth('api')->user()->isCompany()) || (!auth('api')->check()))
<div class="container">
    <div class="col-xs-12 quoTech-premium">
        <div class="col-xs-12 remove-padding">
            <h4>حزمة المؤسسات</h4>
            <h1>كيو تيك Premium</h1>
            <p>يرجى التأكد من التحقق من ملفك الشخصي للاشتراك في كيو تيك بريميوم. تقديم مجموعة لا مثيل لها من العروض المتزامنة للمناقصات! خطوة إلى عالم حيث الفرص وفيرة، وخيارات العطاءات غير محدودة. لقد قمنا بتوسيع وتحسين اقتراح المناقصة.</p>
            <h2>$ 99/شهريًا<span>يتم الفوترة سنويًا</span></h2>
            <a href="#">ترقية</a>
        </div>
        <img src="{{ asset('/assets/front/img/2.png') }}">
    </div>
</div>
@endif
@endsection

@section('script')

<script type="text/javascript">
    $(document).ready(function() {});

</script>

@endsection
