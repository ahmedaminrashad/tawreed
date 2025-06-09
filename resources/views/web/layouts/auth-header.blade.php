<!-- login  -->
<div data-backdrop="static" data-keyboard="false" id="logIn" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <div class="modal-content">
            <span class="close" data-dismiss="modal"><i class="ri-close-line"></i></span>
            <img src="{{ asset('/assets/front/img/logo.png') }}">
            <h1>{{ __('web.welcome_back') }}</h1>
            <form id="login_form" action="{{ route('login') }}" method="POST">
                @csrf

                <div id="login_text_div" class="col-xs-12 remove-padding">
                    <input type="text" name="login_text" id="login_text" placeholder="{{ __('web.login_placeholder') }}">
                </div>
                <div id="login_password_div" class="col-xs-12 remove-padding">
                    <input type="password" id="login_password" name="login_password" placeholder="{{ __('web.password') }}">
                    <span toggle="#password-field" class="ri-eye-fill ri-eye-off-fill toggle-password1"></span>
                </div>

                <button type="submit">{{ __('web.login') }}</button>
            </form>
            <a class="link-style" data-dismiss="modal" data-toggle="modal" data-target="#forgot-passord-div">{{ __('web.forgot_password') }}</a>
            <div class="clearfix"></div>
            <p>{{ __('web.no_account') }} <a class="link-style" data-dismiss="modal" data-toggle="modal" data-target="#signUp">{{ __('web.create_account') }}</a></p>
        </div>
    </div>
</div>

<!-- sign up -->
<div data-backdrop="static" data-keyboard="false" id="signUp" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <div class="modal-content">
            <span class="close" data-dismiss="modal"><i class="ri-close-line"></i></span>
            <img src="{{ asset('/assets/front/img/logo.png') }}">
            <h1>{{ __('web.join_as') }}</h1>
            <form class="chose">
                <div class="row">
                    <div class="col-md-6">
                        <div class="col-xs-12 checked">
                            <input type="radio" checked name="type" value="company">
                            <img src="{{ asset('/assets/front/img/1.svg') }}">
                            <div class="radio-span"></div>
                            <h3>{{ __('web.company') }}</h3>
                            <h5>{{ __('web.company_info') }}</h5>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="col-xs-12">
                            <input type="radio" name="type" value="individual">
                            <img src="{{ asset('/assets/front/img/2.svg') }}">
                            <div class="radio-span"></div>
                            <h3>{{ __('web.individual') }}</h3>
                            <h5>{{ __('web.individual_info') }}</h5>
                        </div>
                    </div>
                </div>
                <button class="link-style" id="account_form_btn" data-dismiss="modal" data-toggle="modal" data-target="#signUp-company-form">{{ __('web.create_account') }}</button>
            </form>
            <div class="clearfix"></div>
            <p>{{ __('web.have_account') }} <a class="link-style" data-dismiss="modal" data-toggle="modal" data-target="#logIn">{{ __('web.login') }}</a></p>
        </div>
    </div>
</div>

<!-- Sign Up Individual Form -->
<div data-backdrop="static" data-keyboard="false" id="signUp-individual-form" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <div class="modal-content">
            <span class="close" data-dismiss="modal"><i class="ri-close-line"></i></span>
            <img src="{{ asset('/assets/front/img/logo.png') }}">
            <h1>{{ __('web.create_account') }}</h1>
            <form id="signUp_individual_form" action="{{ route('register') }}" method="POST">
                @csrf

                <div id="full_name_div" class="col-xs-12 remove-padding">
                    <input type="text" name="full_name" placeholder="{{ __('web.full_name') }}">
                </div>

                <div id="country_id_individual_div" class="col-xs-12 remove-padding">
                    <select data-minimum-results-for-search="Infinity" class="country-select" name="country_id_individual" id="country_id_individual">
                        <option value="">{{ __('web.choose_country') }}</option>
                        @foreach($countries as $id => $name)
                        <option value="{{ $id }}">{{ $name }}</option>
                        @endforeach
                    </select>
                </div>

                <div id="email_individual_div" class="col-xs-12 remove-padding">
                    <input type="email" name="email_individual" placeholder="{{ __('web.write_email') }}" id="email_individual">
                </div>

                <div id="individual_password_div" class="col-xs-12 remove-padding">
                    <input type="password" id="individual_password" name="individual_password" placeholder="{{ __('web.password') }}">
                    <span toggle="#password-field2" class="ri-eye-fill ri-eye-off-fill toggle-password2"></span>
                    <h6>{{ __('web.password_requirement') }}</h6>
                </div>

                <div id="individual_password_confirmation_div" class="col-xs-12 remove-padding">
                    <input type="password" id="individual_password_confirmation" name="individual_password_confirmation" placeholder="{{ __('web.confirm_password') }}">
                    <span toggle="#password-field3" class="ri-eye-fill ri-eye-off-fill toggle-password3"></span>
                    <h6>{{ __('web.password_requirement') }}</h6>
                </div>

                <div class="clearfix"></div>

                <div id="read_div" class="col-xs-12 remove-padding">
                    <label class="checkbox-main"> {{ __('web.read_agree') }} <a style="font-weight: bold;" data-dismiss="modal" data-toggle="modal" data-target="#terms_conditions">{{ __('web.terms_conditions') }}</a>, & <a style="font-weight: bold;" data-dismiss="modal" data-toggle="modal" data-target="#privacy_policy">{{ __('web.privacy_policy') }}</a>
                        <input type="checkbox" name="read_individual" id="read_individual" value="1">
                        <span class="checkmark"></span>
                    </label>
                </div>

                <input type="hidden" name="account_type" value="individual">
                <button type="submit">{{ __('web.create_account') }}</button>

            </form>

            <div class="clearfix"></div>
            <p>{{ __('web.have_account') }} <a class="link-style" data-dismiss="modal" data-toggle="modal" data-target="#logIn">{{ __('web.login') }}</a> </p>
        </div>
    </div>
</div>

<!-- Sign Up Company Form -->
<div data-backdrop="static" data-keyboard="false" id="signUp-company-form" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <div class="modal-content">
            <span class="close" data-dismiss="modal"><i class="ri-close-line"></i></span>
            <img src="{{ asset('/assets/front/img/logo.png') }}">
            <h1>{{ __('web.create_account') }}</h1>
            <form id="signUp_company_form" action="{{ route('register') }}" method="POST">
                @csrf

                <div id="company_name_div" class="col-xs-12 remove-padding">
                    <input type="text" name="company_name" placeholder="{{ __('web.company_name') }}">
                </div>

                <div id="country_id_company_div" class="col-xs-12 remove-padding">
                    <select data-minimum-results-for-search="Infinity" class="country-select" name="country_id_company" id="country_id_company">
                        <option value="">{{ __('web.choose_country') }}</option>
                        @foreach($countries as $id => $name)
                        <option value="{{ $id }}">{{ $name }}</option>
                        @endforeach
                    </select>
                </div>

                <div id="crn_div" class="col-xs-12 remove-padding">
                    <input type="text" name="crn" id="crn" placeholder="{{ __('web.crn') }}">
                </div>

                <div id="email_div" class="col-xs-12 remove-padding">
                    <input type="email" name="email_company" placeholder="{{ __('web.write_email') }}" id="email_company">
                </div>

                <div id="company_password_div" class="col-xs-12 remove-padding">
                    <input type="password" id="company_password" name="company_password" placeholder="{{ __('web.password') }}">
                    <span toggle="#password-field2" class="ri-eye-fill ri-eye-off-fill toggle-password4"></span>
                    <h6>{{ __('web.password_requirement') }}</h6>
                </div>

                <div id="company_password_confirmation_div" class="col-xs-12 remove-padding">
                    <input type="password" id="company_password_confirmation" name="company_password_confirmation" placeholder="{{ __('web.confirm_password') }}">
                    <span toggle="#password-field3" class="ri-eye-fill ri-eye-off-fill toggle-password5"></span>
                    <h6>{{ __('web.password_requirement') }}</h6>
                </div>

                <div class="clearfix"></div>

                <div id="read_company_div" class="col-xs-12 remove-padding">
                    <label class="checkbox-main"> {{ __('web.read_agree') }} <a style="font-weight: bold;" data-dismiss="modal" data-toggle="modal" data-target="#terms_conditions">{{ __('web.terms_conditions') }}</a>, & <a style="font-weight: bold;" data-dismiss="modal" data-toggle="modal" data-target="#privacy_policy">{{ __('web.privacy_policy') }}</a>
                        <input type="checkbox" name="read_company" id="read_company" value="1">
                        <span class="checkmark"></span>
                    </label>
                </div>

                <input type="hidden" name="account_type" value="company">
                <button type="submit">{{ __('web.create_account') }}</button>

            </form>

            <div class="clearfix"></div>
            <p>{{ __('web.have_account') }} <a class="link-style" data-dismiss="modal" data-toggle="modal" data-target="#logIn">{{ __('web.login') }}</a> </p>
        </div>
    </div>
</div>

<!-- otp -->
<div data-backdrop="static" data-keyboard="false" id="verify-otp-form" class="modal fade reset-model" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <span class="close" data-dismiss="modal"><i class="ri-close-line"></i></span>
            <img src="{{ asset('/assets/front/img/logo.png') }}">
            <h1>{{ __('web.enter_otp') }}</h1>
            <h4>{{ __('web.otp_sent_to') }}</h4>
            <h4 id="set_sent_email"></h4>
            <form id="otp_verify_form" action="{{ route('verify.otp') }}" method="POST">
                @csrf

                <div class="row">
                    <div id="otp_div">
                        <div class="col-xs-12 remove-padding otp-main otp-input">
                            <div class="col-xs-2"><input type="number" class="input_style otp_digit" name="digit_1" id="digit_1"></div>
                            <div class="col-xs-2"><input type="number" class="input_style otp_digit" name="digit_2" id="digit_2"></div>
                            <div class="col-xs-2"><input type="number" class="input_style otp_digit" name="digit_3" id="digit_3"></div>
                            <div class="col-xs-2"><input type="number" class="input_style otp_digit" name="digit_4" id="digit_4"></div>
                            <div class="col-xs-2"><input type="number" class="input_style otp_digit" name="digit_5" id="digit_5"></div>
                            <div class="col-xs-2"><input type="number" class="input_style otp_digit" name="digit_6" id="digit_6"></div>
                        </div>
                    </div>
                </div>

                <div class="col-xs-12 remove-padding"></div>

                <input type="hidden" name="otp_user" id="otp_user">
                <button type="submit">{{ __('web.verify') }}</button>
            </form>
            <p>{{ __('web.no_code_received') }} <a href="javascript:void(0);" class="verify-resend-link disabled">{{ __('web.resend') }}</a><br><span id="verify-timer"></span></p>
            
            <form id="verify_resend_link_form" method="POST" action="{{ route('resend.otp') }}">
                @csrf
                
                <input type="hidden" name="resend_otp_user">
            </form>
        </div>
    </div>
</div>

<!-- Terms & Conditons -->
<div data-backdrop="static" data-keyboard="false" id="terms_conditions" class="modal fade terms" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <span class="close" data-dismiss="modal"><i class="ri-close-line"></i></span>
            <h1>{{ __('web.terms_conditions') }}</h1>
            <h5>{!! $terms_conditions !!}</h5>
        </div>
    </div>
</div>

<!-- Privacy Policy  -->
<div data-backdrop="static" data-keyboard="false" id="privacy_policy" class="modal fade terms" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <span class="close" data-dismiss="modal"><i class="ri-close-line"></i></span>
            <h1>{{ __('web.privacy_policy') }}</h1>
            <h5>{!! $privacy_policy !!}</h5>
        </div>
    </div>
</div>

<!-- forgot password  -->
<div data-backdrop="static" data-keyboard="false" id="forgot-passord-div" class="modal fade reset-model" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <span class="close" data-dismiss="modal"><i class="ri-close-line"></i></span>
            <img src="{{ asset('/assets/front/img/logo.png') }}">
            <h1>Forget password</h1>
            <h4>Enter you Email or Commercial Register Number to reset password</h4>
            <form id="forget_password_form" action="{{ route('forget.password') }}" method="POST">
                @csrf

                <input type="text" name="forget_password_search" id="forget_password_search" placeholder="Write your Email or Commercial Registration Number (Company Only)">
                <button type="submit">Request OTP</button>
            </form>
        </div>
    </div>
</div>

<!-- reset password  -->
<div data-backdrop="static" data-keyboard="false" id="reset-password-otp" class="modal fade reset-model" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <span class="close" data-dismiss="modal"><i class="ri-close-line"></i></span>
            <img src="{{ asset('/assets/front/img/logo.png') }}">
            <h1>Forget Password</h1>
            <h4>Enter you OTP sent to your email address to reset password @</h4>
            <h4 id="reset_sent_email"></h4>
            <form id="reset_password_otp_form" action="{{ route('reset.password') }}" method="POST">
                @csrf

                <div class="row">
                    <div id="reset_otp_div">
                        <div class="col-xs-12 remove-padding otp-main otp-input">
                            <div class="col-xs-2"><input type="number" class="input_style reset_otp_digit" name="reset_digit_1" id="reset_digit_1"></div>
                            <div class="col-xs-2"><input type="number" class="input_style reset_otp_digit" name="reset_digit_2" id="reset_digit_2"></div>
                            <div class="col-xs-2"><input type="number" class="input_style reset_otp_digit" name="reset_digit_3" id="reset_digit_3"></div>
                            <div class="col-xs-2"><input type="number" class="input_style reset_otp_digit" name="reset_digit_4" id="reset_digit_4"></div>
                            <div class="col-xs-2"><input type="number" class="input_style reset_otp_digit" name="reset_digit_5" id="reset_digit_5"></div>
                            <div class="col-xs-2"><input type="number" class="input_style reset_otp_digit" name="reset_digit_6" id="reset_digit_6"></div>
                        </div>
                    </div>
                </div>

                <div id="new_password_div">
                    <div class="col-xs-12 remove-padding">
                        <input type="password" id="new_password" name="new_password" placeholder="New Password">
                        <span toggle="#password-field4" class="ri-eye-fill ri-eye-off-fill toggle-password4"></span>
                    </div>
                </div>

                <div id="new_password_confirmation_div">
                    <div class="col-xs-12 remove-padding">
                        <input type="password" id="new_password_confirmation" name="new_password_confirmation" placeholder="New Password Confirmation">
                        <span toggle="#password-field4" class="ri-eye-fill ri-eye-off-fill toggle-password4"></span>
                    </div>
                </div>

                <input type="hidden" name="reset_otp_user" id="reset_otp_user">
                <button type="submit">Reset Password</button>
            </form>

            <p>Didn't receive the code ? <a href="javascript:void(0);" class="reset-resend-link disabled">Resend</a><br><span id="reset-timer"></span></p>
            
            <form id="reset_resend_link_form" method="POST" action="{{ route('resend.otp') }}">
                @csrf

                <input type="hidden" name="resend_otp_user">
            </form>
        </div>
    </div>
</div>