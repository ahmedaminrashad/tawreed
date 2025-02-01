@extends('web.layouts.master')

@section('title', 'Home')

@section('content')
<div class="container-fluid intor-main">
    <img src="{{ asset('/assets/front/img/1.png') }}">
    <div class="container">
        <h1>Find Tenders Match<br>
            your business</h1>
        <p>Forget the old rules. You can have the best<br> people. Right now. Right here.</p>
        <ul class="intor-links">
            @if(!auth('web')->check())
            <li><a class="link-style" data-toggle="modal" data-target="#signUp">Sign up</a></li>
            @endif
            <li><a class="link-style">QuoTech Premium</a></li>
        </ul>
        <div class="col-xs-12 col-md-8 col-md-offset-2 serch-bar remove-padding">
            <form>
                <div class="col-md-6">
                    <i></i>
                    <input type="text" placeholder="Tender  subject  , Company name ">
                </div>
                <div class="col-md-3">
                    <select data-minimum-results-for-search="Infinity" class="js-example-basic-single" name="state">
                        <option value="1">Categories</option>
                        <option value="2">Category 1</option>
                        <option value="3">Category 2</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <button>Finde Tenders</button>
                </div>
            </form>
        </div>
    </div>
</div>

@if(auth('api')->check())
<div class="container users-tenders remove-padding">
    <div class="col-md-6 col-xs-12 col-sm-12">
        <div class="col-xs-12 users-tenders-item">
            <h1>My Tenders </h1>
            <p>Consilio difficultates superare potest esse, immo</p>
            <a href="#">View All</a>
            <img src="{{ asset('/assets/front/img/4.svg') }}">
        </div>
    </div>

    <div class="col-md-6 col-xs-12 col-sm-12">
        <div class="col-xs-12 users-tenders-item">
            <h1>My proposal</h1>
            <p>Consilio difficultates superare potest esse, immo</p>
            <a href="#">View All</a>
            <div class="balance-main">
                <h6>Your debit balance<span><br>340 $ <i title="Payment Area" class="ri-information-fill"></i></span></h6>
                <a href="#">Pay now</a>
            </div>
            <img src="{{ asset('/assets/front/img/5.svg') }}">
        </div>
    </div>
</div>
@endif

<div class="container remove-padding categories-main">
    <div class="col-xs-12 title">
        <h1>Explorer by category</h1>
        <a href="{{ route('categories.index') }}">View all <i class="ri-arrow-right-line"></i></a>
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
        <h1>Recent Tenders </h1>
        <a href="#">View all <i class="ri-arrow-right-line"></i></a>
    </div>
    <div class="col-md-6 col-xs-12">
        <div class="col-xs-12 Tender-item">
            <h4>Purchase of Dechlorinating Agents . 2024010305</h4>
            <span>Home Appliances</span>
            <h3> Contract duration :<span>4 days</span></h3>
            <div class="clearfix"></div>
            <ul class="col-xs-12 remove-padding">
                <li>
                    <h5>Contract Start date : <span>01/08/2024</span></h5>
                </li>
                <li>
                    <h5>Contract End date : <span>20/08/2024</span></h5>
                </li>
            </ul>
            <div class="clearfix"></div>
            <ul class="col-xs-12 remove-padding">
                <li><i class="ri-map-pin-line"></i>
                    <h5>Dhaka, Bangladesh</h5>
                </li>
                <li><i class="ri-function-line"></i>
                    <h5>Supply & Implementation</h5>
                </li>
            </ul>
            <div class="clearfix"></div>
            <p>Mollit in laborum tempor Lorem incididunt irure. Aute eu ex ad sunt. Pariatur sint culpa do incididunt eiusmod eiusmod culpa. laborum tempor Lorem incididunt.</p>
            <div class="col-xs-12 remove-padding">
                <div class="Tender-progress">
                    <div style="width:50%;"></div>
                </div>
                <h6>Time remaining<span>2 days before closing date </span></h6>
            </div>
            <div class="col-xs-12 remove-padding">
                <div class="tender-img">
                    <img src="{{ asset('/assets/front/img/1.png') }}">
                    <p>Buyer name <span>company</span></p>
                </div>
                <a href="#" class="tender-link">Log in to View details <i class="ri-lock-line"></i></a>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xs-12">
        <div class="col-xs-12 Tender-item">
            <h4>Purchase of Dechlorinating Agents . 2024010305</h4>
            <span>Home Appliances</span>
            <h3> Contract duration :<span>4 days</span></h3>
            <div class="clearfix"></div>
            <ul class="col-xs-12 remove-padding">
                <li>
                    <h5>Contract Start date : <span>01/08/2024</span></h5>
                </li>
                <li>
                    <h5>Contract End date : <span>20/08/2024</span></h5>
                </li>
            </ul>
            <div class="clearfix"></div>
            <ul class="col-xs-12 remove-padding">
                <li><i class="ri-map-pin-line"></i>
                    <h5>Dhaka, Bangladesh</h5>
                </li>
                <li><i class="ri-function-line"></i>
                    <h5>Supply & Implementation</h5>
                </li>
            </ul>
            <div class="clearfix"></div>
            <p>Mollit in laborum tempor Lorem incididunt irure. Aute eu ex ad sunt. Pariatur sint culpa do incididunt eiusmod eiusmod culpa. laborum tempor Lorem incididunt.</p>
            <div class="col-xs-12 remove-padding">
                <div class="Tender-progress">
                    <div style="width:50%;"></div>
                </div>
                <h6>Time remaining<span>2 days before closing date </span></h6>
            </div>
            <div class="col-xs-12 remove-padding">
                <div class="tender-img">
                    <img src="{{ asset('/assets/front/img/1.png') }}">
                    <p>Buyer name <span>company</span></p>
                </div>
                <a href="#" class="tender-link">Log in to View details <i class="ri-lock-line"></i></a>
            </div>
        </div>
    </div>
</div>

<div class="container remove-padding Finish-tender">
    <div class="col-xs-12 title">
        <h1>Finished Tenders </h1>
        <a href="#">View all <i class="ri-arrow-right-line"></i></a>
    </div>
    <div class="col-md-6 col-xs-12">
        <div class="col-xs-12 Tender-item Finish-tender-item">
            <h4>Purchase of Dechlorinating Agents . 2024010305</h4>
            <span>Home Appliances</span>
            <h3> Contract duration :<span>4 days</span></h3>
            <div class="clearfix"></div>
            <ul class="col-xs-12 remove-padding">
                <li><i class="ri-map-pin-line"></i>
                    <h5>Dhaka, Bangladesh</h5>
                </li>
                <li><i class="ri-function-line"></i>
                    <h5>Supply & Implementation</h5>
                </li>
            </ul>
            <div class="col-xs-12 remove-padding">
                <div class="row">
                    <div class="col-md-6 col-xs-12">
                        <h2>Seller name ( winner) </h2>
                        <div class="tender-img has-rate">
                            <img src="{{ asset('/assets/front/img/1.png') }}">
                            <p>Leslie Alexander</p>
                            <h4>4.8 <i class="ri-star-fill"></i><span>(653)</span></h4>
                        </div>
                    </div>

                    <div class="col-md-6 col-xs-12">
                        <h2>Buyer name </h2>
                        <div class="tender-img">
                            <img src="{{ asset('/assets/front/img/1.png') }}">
                            <p>Bessie Cooper</p>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>

    <div class="col-md-6 col-xs-12">
        <div class="col-xs-12 Tender-item Finish-tender-item">
            <h4>Purchase of Dechlorinating Agents . 2024010305</h4>
            <span>Home Appliances</span>
            <h3> Contract duration :<span>4 days</span></h3>
            <div class="clearfix"></div>
            <ul class="col-xs-12 remove-padding">
                <li><i class="ri-map-pin-line"></i>
                    <h5>Dhaka, Bangladesh</h5>
                </li>
                <li><i class="ri-function-line"></i>
                    <h5>Supply & Implementation</h5>
                </li>
            </ul>
            <div class="col-xs-12 remove-padding">
                <div class="row">
                    <div class="col-md-6 col-xs-12">
                        <h2>Seller name ( winner) </h2>
                        <div class="tender-img has-rate">
                            <img src="{{ asset('/assets/front/img/1.png') }}">
                            <p>Leslie Alexander</p>
                            <h4>4.8 <i class="ri-star-fill"></i><span>(653)</span></h4>
                        </div>
                    </div>

                    <div class="col-md-6 col-xs-12">
                        <h2>Buyer name </h2>
                        <div class="tender-img">
                            <img src="{{ asset('/assets/front/img/1.png') }}">
                            <p>Bessie Cooper</p>
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
            <h4>Enterprise Suite</h4>
            <h1>QuoTech Premium</h1>
            <p>please make sure that you verify your profile To subscribe to Quetech Premium .
                introducing an unparalleled array of concurrent proposals for tender bidding! Step into a world where opportunities abound, and your bidding options are limitless. We've expanded and enhanced our tender proposal. </p>
            <h2>$ 99/mth<span>Billed annually</span></h2>
            <a href="#">Upgrade</a>
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
