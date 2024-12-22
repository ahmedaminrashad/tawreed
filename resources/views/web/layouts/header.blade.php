<header class="container-fluid remove-padding">
    <span class="mobile-menu-btn visible-xs visible-sm">
        <i class="ri-menu-line"></i>
    </span>
    <div class="container remove-padding">
        <div class="col-md-2">
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
        </div>
    </div>
</header>

@include('web.layouts.auth-header')

@yield('header')
