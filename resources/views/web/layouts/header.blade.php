<header class="container-fluid remove-padding member-head">
    <span class="mobile-menu-btn visible-xs visible-sm">
        <i class="ri-menu-line"></i>
    </span>
    <div class="container remove-padding">
        <div class="col-md-1">
            <a href="{{ route('home') }}">
                <img src="{{ asset('/assets/front/img/logo.png') }}">
            </a>
        </div>
        <div class="mobile-menu-container">
            <div class="col-md-3 main-menu">
                <ul>
                    <li><a href="javascript:void(0);">Tenders</a></li>
                    <li><a href="javascript:void(0);">Contact us</a></li>
                    <li><a href="javascript:void(0);">About us </a></li>
                </ul>
            </div>
            <div class="col-md-4 search-main">
                <form>
                    <span></span>
                    <input type="text" name="search_text" id="search_text" placeholder="Tender subject ,Company name">
                    <select data-minimum-results-for-search="Infinity" class="js-example-basic-single" name="state">
                        <option value="1">Categories</option>
                        <option value="2">Category 1</option>
                        <option value="3">Category 2</option>
                    </select>
                </form>
            </div>
            @if(!auth('api')->check())
            <div class="col-md-3">
                <ul class="side-menu">
                    <li>
                        <a class="link-style" data-toggle="modal" data-target="#logIn">Log in</a>
                    </li>
                    <li class="sign-btn">
                        <a class="link-style" data-toggle="modal" data-target="#signUp">Sign up</a>
                    </li>
                    <li class="dropdown">
                        <button type="button" data-toggle="dropdown">
                            <i class="ri-global-line"></i>
                        </button>
                        <span><i class="ri-arrow-down-s-fill"></i></span>
                        <ul class="dropdown-menu">
                            <li class="active">
                                <a href="javascript:void(0);">English</a>
                            </li>
                            <li>
                                <a href="javascript:void(0);">Arabic</a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
            @else
            <div class="col-md-4 member-side">
                <ul>
                    <li><a href="#" class="Create-Tender-btn"><i class="ri-add-circle-line"></i> Create Tenders</a></li>
                    <li class="dropdown">
                        <button type="button" data-toggle="dropdown">
                            <i class="ri-global-line"></i>
                        </button>
                        <span><i class="ri-arrow-down-s-fill"></i></span>
                        <ul class="dropdown-menu lang-main">
                            <h3 class="visible-xs visible-sm">Languge</h3>
                            <span class="visible-xs visible-sm close-btn">Close</span>

                            <li class="active"><a href="#">English</a></li>
                            <li><a href="#">Arabic</a></li>
                        </ul>
                    </li>

                    <li class="dropdown">
                        <button type="button" data-toggle="dropdown">
                            <i class="ri-notification-line"></i>
                            <h6>2</h6>
                        </button>
                        <span><i class="ri-arrow-down-s-fill"></i></span>
                        <ul class="dropdown-menu notification-main">

                            <h3>Notifications</h3>
                            <span class="visible-xs visible-sm close-btn">Close</span>
                            <div class="tabbed">
                                <input type="radio" id="tab1" name="css-tabs" checked>
                                <input type="radio" id="tab2" name="css-tabs">
                                <input type="radio" id="tab3" name="css-tabs">

                                <ul class="tabs">
                                    <li class="tab"><label for="tab1">All</label></li>
                                    <li class="tab"><label for="tab2">Unread</label></li>
                                    <li class="tab"><label for="tab3">Read</label></li>
                                </ul>

                                <div class="tab-content">
                                    <div class="col-xs-12 remove-padding">
                                        <div class="col-xs-12 remove-padding notification-item">
                                            <img src="img/1.png" />
                                            <a href="#">Your Verification Request is Rejected you can View Reason of Rejection.</a>
                                            <h5>Last Wednesday at 9:42 AM</h5>
                                        </div>
                                        <div class="col-xs-12 remove-padding notification-item unread-notification">
                                            <img src="img/1.png" />
                                            <a href="#">Your Verification Request is Rejected you can View Reason of Rejection.</a>
                                            <h5>Last Wednesday at 9:42 AM</h5>
                                        </div>
                                        <div class="col-xs-12 remove-padding notification-item">
                                            <img src="img/1.png" />
                                            <a href="#">Your Verification Request is Rejected you can View Reason of Rejection.</a>
                                            <h5>Last Wednesday at 9:42 AM</h5>
                                        </div>
                                        <div class="col-xs-12 remove-padding notification-item">
                                            <img src="img/1.png" />
                                            <a href="#">Your Verification Request is Rejected you can View Reason of Rejection.</a>
                                            <h5>Last Wednesday at 9:42 AM</h5>
                                        </div>
                                    </div>
                                </div>

                                <div class="tab-content">
                                    <div class="col-xs-12 remove-padding notification-item">
                                        <img src="img/1.png" />
                                        <a href="#">Your Verification Request is Rejected you can View Reason of Rejection.</a>
                                        <h5>Last Wednesday at 9:42 AM</h5>
                                    </div>
                                    <div class="col-xs-12 remove-padding notification-item">
                                        <img src="img/1.png" />
                                        <a href="#">Your Verification Request is Rejected you can View Reason of Rejection.</a>
                                        <h5>Last Wednesday at 9:42 AM</h5>
                                    </div>
                                    <div class="col-xs-12 remove-padding notification-item">
                                        <img src="img/1.png" />
                                        <a href="#">Your Verification Request is Rejected you can View Reason of Rejection.</a>
                                        <h5>Last Wednesday at 9:42 AM</h5>
                                    </div>
                                    <div class="col-xs-12 remove-padding notification-item">
                                        <img src="img/1.png" />
                                        <a href="#">Your Verification Request is Rejected you can View Reason of Rejection.</a>
                                        <h5>Last Wednesday at 9:42 AM</h5>
                                    </div>
                                    <div class="col-xs-12 remove-padding notification-item">
                                        <img src="img/1.png" />
                                        <a href="#">Your Verification Request is Rejected you can View Reason of Rejection.</a>
                                        <h5>Last Wednesday at 9:42 AM</h5>
                                    </div>
                                </div>

                                <div class="tab-content">
                                    <div class="col-xs-12 remove-padding notification-item">
                                        <img src="img/1.png" />
                                        <a href="#">Your Verification Request is Rejected you can View Reason of Rejection.</a>
                                        <h5>Last Wednesday at 9:42 AM</h5>
                                    </div>
                                    <div class="col-xs-12 remove-padding notification-item">
                                        <img src="img/1.png" />
                                        <a href="#">Your Verification Request is Rejected you can View Reason of Rejection.</a>
                                        <h5>Last Wednesday at 9:42 AM</h5>
                                    </div>
                                    <div class="col-xs-12 remove-padding notification-item">
                                        <img src="img/1.png" />
                                        <a href="#">Your Verification Request is Rejected you can View Reason of Rejection.</a>
                                        <h5>Last Wednesday at 9:42 AM</h5>
                                    </div>
                                </div>
                            </div>



                        </ul>
                    </li>
                    <li><a href="#"><i class="ri-message-3-line"></i>
                            <h6>2</h6>
                        </a></li>
                    <li class="dropdown">
                        <button type="button" data-toggle="dropdown">
                            <i class="ri-user-line"></i>
                        </button>
                        <span><i class="ri-arrow-down-s-fill"></i></span>
                        <ul class="dropdown-menu profile-drop">
                            <h3 class="visible-xs visible-sm">Profile</h3>
                            <span class="visible-xs visible-sm close-btn">Close</span>

                            <li><a href="#"><i class="ri-user-line"></i> Profile</a></li>
                            <li><a href="#"><i class="ri-key-fill"></i> My tenders </a></li>
                            <li><a href="#"><i class="ri-article-line"></i> My tenders </a></li>
                            <li><a href="#"><i class="ri-wallet-line"></i> Wallet</a></li>
                            <li><a href="#"><i class="ri-settings-2-line"></i> Setting</a></li>
                            <li>
                                <a class="link-style">
                                    <i class="ri-shut-down-line"></i>
                                    <button type="submit" id="logout_btn" class="link-style">Logout</button>
                                    <form id="logout_form" method="POST" action="{{ route('logout') }}">
                                        @csrf
                                    </form>
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
            @endif
        </div>
    </div>
</header>

@include('web.layouts.auth-header')

@yield('header')
