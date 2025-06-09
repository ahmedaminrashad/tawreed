@extends('web.layouts.master')

@section('title', 'Home')

@section('content')
<div class="container-fluid intor-main">
    <img src="{{ asset('/assets/front/img/1.png') }}">
    <div class="container">
        <h1>ابحث عن المناقصات التي تناسب<br>عملك</h1>
        <p>انس القواعد القديمة. يمكنك الحصول على أفضل<br>الأشخاص. الآن. هنا.</p>
        <ul class="intor-links">
            @if(!auth('web')->check())
            <li><a class="link-style" data-toggle="modal" data-target="#signUp">تسجيل</a></li>
            @endif
            <li><a class="link-style">كيو تيك Premium</a></li>
        </ul>
        <div class="col-xs-12 col-md-8 col-md-offset-2 serch-bar remove-padding">
            <form>
                <div class="col-md-6">
                    <i></i>
                    <input type="text" placeholder="موضوع المناقصة، اسم الشركة">
                </div>
                <div class="col-md-3">
                    <select data-minimum-results-for-search="Infinity" class="js-example-basic-single" name="state">
                        <option value="1">التصنيفات</option>
                        <option value="2">التصنيف 1</option>
                        <option value="3">التصنيف 2</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <button>البحث عن المناقصات</button>
                </div>
            </form>
        </div>
    </div>
</div>

@if(auth('api')->check())
<div class="container users-tenders remove-padding">
    <div class="col-md-6 col-xs-12 col-sm-12">
        <div class="col-xs-12 users-tenders-item">
            <h1>مناقصاتي</h1>
            <p>يمكن أن يكون التغلب على الصعوبات أمرًا سهلاً</p>
            <a href="#">عرض الكل</a>
            <img src="{{ asset('/assets/front/img/4.svg') }}">
        </div>
    </div>

    <div class="col-md-6 col-xs-12 col-sm-12">
        <div class="col-xs-12 users-tenders-item">
            <h1>اقتراحي</h1>
            <p>يمكن أن يكون التغلب على الصعوبات أمرًا سهلاً</p>
            <a href="#">عرض الكل</a>
            <div class="balance-main">
                <h6>رصيدك المتبقي<span><br>340 $ <i title="منطقة الدفع" class="ri-information-fill"></i></span></h6>
                <a href="#">ادفع الآن</a>
            </div>
            <img src="{{ asset('/assets/front/img/5.svg') }}">
        </div>
    </div>
</div>
@endif

<div class="container remove-padding categories-main">
    <div class="col-xs-12 title">
        <h1>استكشف حسب التصنيف</h1>
        <a href="{{ route('categories.index') }}">عرض الكل <i class="ri-arrow-right-line"></i></a>
    </div>
    @foreach($workCategories as $categoryID => $categoryName)
    <div class="col-md-4 col-sm-6 col-xs-12">
        <div class="col-xs-12 category-item">
            <img src="{{ asset('/assets/front/img/1.png') }}">
            <a href="#">{{ $categoryName }}</a>
            <p>357 Open Tender</p>
        </div>
    </div>    
    @endforeach
</div>

<div class="container remove-padding Tender-home Finish-tender">
    <div class="col-xs-12 title">
        <h1>المناقصات الأخيرة</h1>
        <a href="#">عرض الكل <i class="ri-arrow-right-line"></i></a>
    </div>
    <div class="col-md-6 col-xs-12">
        <div class="col-xs-12 Tender-item">
            <h4>شراء عوامل إزالة الكلور. 2024010305</h4>
            <span>الأجهزة المنزلية</span>
            <h3>مدة العقد: <span>4 أيام</span></h3>
            <div class="clearfix"></div>
            <ul class="col-xs-12 remove-padding">
                <li>
                    <h5>تاريخ بدء العقد: <span>01/08/2024</span></h5>
                </li>
                <li>
                    <h5>تاريخ انتهاء العقد: <span>20/08/2024</span></h5>
                </li>
            </ul>
            <div class="clearfix"></div>
            <ul class="col-xs-12 remove-padding">
                <li><i class="ri-map-pin-line"></i>
                    <h5>دكا، بنغلاديش</h5>
                </li>
                <li><i class="ri-function-line"></i>
                    <h5>التوريد والتنفيذ</h5>
                </li>
            </ul>
            <div class="clearfix"></div>
            <p>موليت في لابوروم تيمبور لوريم إنسيديدونت إيرور. أوتي إيو إكس أد سونت. بارياتور سينت كولبا دو إنسيديدونت إيوسمود إيوسمود كولبا. لابوروم تيمبور لوريم إنسيديدونت.</p>
            <div class="col-xs-12 remove-padding">
                <div class="Tender-progress">
                    <div style="width:50%;"></div>
                </div>
                <h6>الوقت المتبقي<span>2 أيام قبل تاريخ الإغلاق</span></h6>
            </div>
            <div class="col-xs-12 remove-padding">
                <div class="tender-img">
                    <img src="{{ asset('/assets/front/img/1.png') }}">
                    <p>اسم المشتري <span>شركة</span></p>
                </div>
                <a href="#" class="tender-link">تسجيل الدخول لعرض التفاصيل <i class="ri-lock-line"></i></a>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xs-12">
        <div class="col-xs-12 Tender-item">
            <h4>شراء عوامل إزالة الكلور. 2024010305</h4>
            <span>الأجهزة المنزلية</span>
            <h3>مدة العقد: <span>4 أيام</span></h3>
            <div class="clearfix"></div>
            <ul class="col-xs-12 remove-padding">
                <li>
                    <h5>تاريخ بدء العقد: <span>01/08/2024</span></h5>
                </li>
                <li>
                    <h5>تاريخ انتهاء العقد: <span>20/08/2024</span></h5>
                </li>
            </ul>
            <div class="clearfix"></div>
            <ul class="col-xs-12 remove-padding">
                <li><i class="ri-map-pin-line"></i>
                    <h5>دكا، بنغلاديش</h5>
                </li>
                <li><i class="ri-function-line"></i>
                    <h5>التوريد والتنفيذ</h5>
                </li>
            </ul>
            <div class="clearfix"></div>
            <p>موليت في لابوروم تيمبور لوريم إنسيديدونت إيرور. أوتي إيو إكس أد سونت. بارياتور سينت كولبا دو إنسيديدونت إيوسمود إيوسمود كولبا. لابوروم تيمبور لوريم إنسيديدونت.</p>
            <div class="col-xs-12 remove-padding">
                <div class="Tender-progress">
                    <div style="width:50%;"></div>
                </div>
                <h6>الوقت المتبقي<span>2 أيام قبل تاريخ الإغلاق</span></h6>
            </div>
            <div class="col-xs-12 remove-padding">
                <div class="tender-img">
                    <img src="{{ asset('/assets/front/img/1.png') }}">
                    <p>اسم المشتري <span>شركة</span></p>
                </div>
                <a href="#" class="tender-link">تسجيل الدخول لعرض التفاصيل <i class="ri-lock-line"></i></a>
            </div>
        </div>
    </div>
</div>

<div class="container remove-padding Finish-tender">
    <div class="col-xs-12 title">
        <h1>المناقصات المنتهية</h1>
        <a href="#">عرض الكل <i class="ri-arrow-right-line"></i></a>
    </div>
    <div class="col-md-6 col-xs-12">
        <div class="col-xs-12 Tender-item Finish-tender-item">
            <h4>شراء عوامل إزالة الكلور. 2024010305</h4>
            <span>الأجهزة المنزلية</span>
            <h3>مدة العقد: <span>4 أيام</span></h3>
            <div class="clearfix"></div>
            <ul class="col-xs-12 remove-padding">
                <li><i class="ri-map-pin-line"></i>
                    <h5>دكا، بنغلاديش</h5>
                </li>
                <li><i class="ri-function-line"></i>
                    <h5>التوريد والتنفيذ</h5>
                </li>
            </ul>
            <div class="col-xs-12 remove-padding">
                <div class="row">
                    <div class="col-md-6 col-xs-12">
                        <h2>اسم البائع (الفائز)</h2>
                        <div class="tender-img has-rate">
                            <img src="{{ asset('/assets/front/img/1.png') }}">
                            <p>ليزلي ألكسندر</p>
                            <h4>4.8 <i class="ri-star-fill"></i><span>(653)</span></h4>
                        </div>
                    </div>

                    <div class="col-md-6 col-xs-12">
                        <h2>اسم المشتري</h2>
                        <div class="tender-img">
                            <img src="{{ asset('/assets/front/img/1.png') }}">
                            <p>شركة</p>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>

    <div class="col-md-6 col-xs-12">
        <div class="col-xs-12 Tender-item Finish-tender-item">
            <h4>شراء عوامل إزالة الكلور. 2024010305</h4>
            <span>الأجهزة المنزلية</span>
            <h3>مدة العقد: <span>4 أيام</span></h3>
            <div class="clearfix"></div>
            <ul class="col-xs-12 remove-padding">
                <li><i class="ri-map-pin-line"></i>
                    <h5>دكا، بنغلاديش</h5>
                </li>
                <li><i class="ri-function-line"></i>
                    <h5>التوريد والتنفيذ</h5>
                </li>
            </ul>
            <div class="col-xs-12 remove-padding">
                <div class="row">
                    <div class="col-md-6 col-xs-12">
                        <h2>اسم البائع (الفائز)</h2>
                        <div class="tender-img has-rate">
                            <img src="{{ asset('/assets/front/img/1.png') }}">
                            <p>ليزلي ألكسندر</p>
                            <h4>4.8 <i class="ri-star-fill"></i><span>(653)</span></h4>
                        </div>
                    </div>

                    <div class="col-md-6 col-xs-12">
                        <h2>اسم المشتري</h2>
                        <div class="tender-img">
                            <img src="{{ asset('/assets/front/img/1.png') }}">
                            <p>شركة</p>
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
