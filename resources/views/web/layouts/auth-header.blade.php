<!-- login  -->
<div id="logIn" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <div class="modal-content">
            <span class="close" data-dismiss="modal"><i class="ri-close-line"></i></span>
            <img src="{{ asset('/assets/front/img/logo.png') }}">
            <h1>Welcome back </h1>
            <form>
                @csrf

                <input type="text" name="login_search" id="login_search" placeholder="Write your Email or Commercial Registration Number (Company Only)">
                <div class="col-xs-12 remove-padding">
                    <input type="password" id="pass_log_id" name="pass1" placeholder="password">
                    <span toggle="#password-field" class="ri-eye-fill ri-eye-off-fill toggle-password1"></span>
                </div>

                <button>Login</button>
                <a class="link-style" data-dismiss="modal" data-toggle="modal" data-target="#forgot-passord-div">Forgot password ?</a>
            </form>
            <div class="clearfix"></div>
            <p>Don't have an account? <a class="link-style" data-dismiss="modal" data-toggle="modal" data-target="#signUp">Create account</a></p>
        </div>
    </div>
</div>

<!-- sign up -->
<div id="signUp" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <div class="modal-content">
            <span class="close" data-dismiss="modal"><i class="ri-close-line"></i></span>
            <img src="{{ asset('/assets/front/img/logo.png') }}">
            <h1>Join as Individual or Company </h1>
            <form class="chose">
                <div class="row">
                    <div class="col-md-6">
                        <div class="col-xs-12 checked">
                            <input type="radio" checked name="type" value="company">
                            <img src="{{ asset('/assets/front/img/1.svg') }}">
                            <div class="radio-span"></div>
                            <h3>Campany</h3>
                            <h5>You can add company main info</h5>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="col-xs-12">
                            <input type="radio" name="type" value="individual">
                            <img src="{{ asset('/assets/front/img/2.svg') }}">
                            <div class="radio-span"></div>
                            <h3>Individual</h3>
                            <h5>You can submit tender as well as send proposals</h5>
                        </div>
                    </div>
                </div>
                <button class="link-style" id="account_form_btn" data-dismiss="modal" data-toggle="modal" data-target="#signUp-company-form">Create account</button>
            </form>
            <div class="clearfix"></div>
            <p>Already have an account? <a class="link-style" data-dismiss="modal" data-toggle="modal" data-target="#logIn">Login</a></p>
        </div>
    </div>
</div>

<!-- Sign Up Individual Form -->
<div id="signUp-individual-form" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <div class="modal-content">
            <span class="close" data-dismiss="modal"><i class="ri-close-line"></i></span>
            <img src="{{ asset('/assets/front/img/logo.png') }}">
            <h1>Create account</h1>
            <form id="signUp_individual_form" action="{{ route('register') }}" method="POST">
                @csrf

                <div id="full_name_div" class="col-xs-12 remove-padding">
                    <input type="text" name="full_name" placeholder="Full name">
                </div>

                <div id="country_id_individual_div" class="col-xs-12 remove-padding">
                    <select data-minimum-results-for-search="Infinity" class="country-select" name="country_id_individual" id="country_id_individual">
                        <option value="">Choose Country</option>
                        @foreach($countries as $id => $name)
                        <option value="{{ $id }}">{{ $name }}</option>
                        @endforeach
                    </select>
                </div>

                <div id="email_individual_div" class="col-xs-12 remove-padding">
                    <input type="email" name="email_individual" placeholder="Write your email" id="email_individual">
                </div>

                <div id="individual_password_div" class="col-xs-12 remove-padding">
                    <input type="password" id="individual_password" name="individual_password" placeholder="Password">
                    <span toggle="#password-field2" class="ri-eye-fill ri-eye-off-fill toggle-password2"></span>
                    <h6>Must contain 8 character</h6>
                </div>

                <div id="individual_password_confirmation_div" class="col-xs-12 remove-padding">
                    <input type="password" id="individual_password_confirmation" name="individual_password_confirmation" placeholder="Confirm Password">
                    <span toggle="#password-field3" class="ri-eye-fill ri-eye-off-fill toggle-password3"></span>
                    <h6>Must contain 8 character</h6>
                </div>

                <div class="clearfix"></div>

                <div id="read_div" class="col-xs-12 remove-padding">
                    <label class="checkbox-main"> Read & agree <a style="font-weight: bold;" data-dismiss="modal" data-toggle="modal" data-target="#terms_conditions">Terms & Conditions</a>, & <a style="font-weight: bold;" data-dismiss="modal" data-toggle="modal" data-target="#privacy_policy">Privacy policy</a>
                        <input type="checkbox" name="read_individual" id="read_individual" value="1">
                        <span class="checkmark"></span>
                    </label>
                </div>

                <input type="hidden" name="account_type" value="individual">
                <button type="submit">Create account</button>

            </form>

            <div class="clearfix"></div>
            <p>Already have an account? <a class="link-style" data-dismiss="modal" data-toggle="modal" data-target="#logIn">Login</a> </p>
        </div>
    </div>
</div>

<!-- Sign Up Company Form -->
<div id="signUp-company-form" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <div class="modal-content">
            <span class="close" data-dismiss="modal"><i class="ri-close-line"></i></span>
            <img src="{{ asset('/assets/front/img/logo.png') }}">
            <h1>Create account</h1>
            <form id="signUp_company_form" action="{{ route('register') }}" method="POST">
                @csrf

                <div id="company_name_div" class="col-xs-12 remove-padding">
                    <input type="text" name="company_name" placeholder="Company name">
                </div>

                <div id="country_id_company_div" class="col-xs-12 remove-padding">
                    <select data-minimum-results-for-search="Infinity" class="country-select" name="country_id_company" id="country_id_company">
                        <option value="">Choose Country</option>
                        @foreach($countries as $id => $name)
                        <option value="{{ $id }}">{{ $name }}</option>
                        @endforeach
                    </select>
                </div>

                <div id="crn_div" class="col-xs-12 remove-padding">
                    <input type="text" name="crn" id="crn" placeholder="Commercial Registration Number">
                </div>

                <div id="email_div" class="col-xs-12 remove-padding">
                    <input type="email" name="email_company" placeholder="Write your Email" id="email_company">
                </div>

                <div id="company_password_div" class="col-xs-12 remove-padding">
                    <input type="password" id="company_password" name="company_password" placeholder="Password">
                    <span toggle="#password-field2" class="ri-eye-fill ri-eye-off-fill toggle-password2"></span>
                    <h6>Must contain 8 character</h6>
                </div>

                <div id="company_password_confirmation_div" class="col-xs-12 remove-padding">
                    <input type="password" id="company_password_confirmation" name="company_password_confirmation" placeholder="Confirm Password">
                    <span toggle="#password-field3" class="ri-eye-fill ri-eye-off-fill toggle-password3"></span>
                    <h6>Must contain 8 character</h6>
                </div>

                <div class="clearfix"></div>

                <div id="read_company_div" class="col-xs-12 remove-padding">
                    <label class="checkbox-main"> Read & agree <a style="font-weight: bold;" data-dismiss="modal" data-toggle="modal" data-target="#terms_conditions">Terms & Conditions</a>, & <a style="font-weight: bold;" data-dismiss="modal" data-toggle="modal" data-target="#privacy_policy">Privacy policy</a>
                        <input type="checkbox" name="read_company" id="read_company" value="1">
                        <span class="checkmark"></span>
                    </label>
                </div>

                <input type="hidden" name="account_type" value="company">
                <button type="submit">Create account</button>

            </form>

            <div class="clearfix"></div>
            <p>Already have an account? <a class="link-style" data-dismiss="modal" data-toggle="modal" data-target="#logIn">Login</a> </p>
        </div>
    </div>
</div>

<!-- otp -->
<div id="verify-otp-form" class="modal fade reset-model" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <span class="close" data-dismiss="modal"><i class="ri-close-line"></i></span>
            <img src="{{ asset('/assets/front/img/logo.png') }}">
            <h1>Enter OTP Sent to your email </h1>
            <h4>OTP Sent to your email @</h4>
            <h4 id="set_sent_email"></h4>
            <form id="otp_verify_form" action="{{ route('verify.otp') }}" method="POST">
                @csrf

                <div class="row">
                    <div id="otp_div">
                        <div class="col-xs-12 remove-padding otp-main">
                            <div class="col-xs-2"><input type="number" maxlength="1" class="input_style otp_digit" name="digit_1" id="digit_1" min="0" max="9"></div>
                            <div class="col-xs-2"><input type="number" maxlength="1" class="input_style otp_digit" name="digit_2" id="digit_2" min="0" max="9"></div>
                            <div class="col-xs-2"><input type="number" maxlength="1" class="input_style otp_digit" name="digit_3" id="digit_3" min="0" max="9"></div>
                            <div class="col-xs-2"><input type="number" maxlength="1" class="input_style otp_digit" name="digit_4" id="digit_4" min="0" max="9"></div>
                            <div class="col-xs-2"><input type="number" maxlength="1" class="input_style otp_digit" name="digit_5" id="digit_5" min="0" max="9"></div>
                            <div class="col-xs-2"><input type="number" maxlength="1" class="input_style otp_digit" name="digit_6" id="digit_6" min="0" max="9"></div>
                        </div>
                    </div>
                </div>

                <div class="col-xs-12 remove-padding"></div>

                <input type="hidden" name="otp_user" id="otp_user">
                <button type="submit">Verify</button>
            </form>
            <p>Didn’t receive the code ? <a href="javascript:void(0);">Resend</a><br><span id="timer"></span> </p>
        </div>
    </div>
</div>

<!-- Terms & Conditons -->
<div id="terms_conditions" class="modal fade terms" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <span class="close" data-dismiss="modal"><i class="ri-close-line"></i></span>
            <h1>Terms and Conditions</h1>
            <h5>{!! $terms_conditions !!}</h5>
        </div>
    </div>
</div>

<!-- Privacy Policy  -->
<div id="privacy_policy" class="modal fade terms" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <span class="close" data-dismiss="modal"><i class="ri-close-line"></i></span>
            <h1>Privacy Policy</h1>
            <h5>{!! $privacy_policy !!}</h5>
        </div>
    </div>
</div>

<!-- forgot password  -->
<div id="forgot-passord-div" class="modal fade reset-model" role="dialog">
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
<div id="reset-password-otp" class="modal fade reset-model" role="dialog">
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
                        <div class="col-xs-12 remove-padding otp-main">
                            <div class="col-xs-2"><input type="number" maxlength="1" class="input_style reset_otp_digit" name="reset_digit_1" id="reset_digit_1" min="0" max="9"></div>
                            <div class="col-xs-2"><input type="number" maxlength="1" class="input_style reset_otp_digit" name="reset_digit_2" id="reset_digit_2" min="0" max="9"></div>
                            <div class="col-xs-2"><input type="number" maxlength="1" class="input_style reset_otp_digit" name="reset_digit_3" id="reset_digit_3" min="0" max="9"></div>
                            <div class="col-xs-2"><input type="number" maxlength="1" class="input_style reset_otp_digit" name="reset_digit_4" id="reset_digit_4" min="0" max="9"></div>
                            <div class="col-xs-2"><input type="number" maxlength="1" class="input_style reset_otp_digit" name="reset_digit_5" id="reset_digit_5" min="0" max="9"></div>
                            <div class="col-xs-2"><input type="number" maxlength="1" class="input_style reset_otp_digit" name="reset_digit_6" id="reset_digit_6" min="0" max="9"></div>
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
        </div>
    </div>
</div>
