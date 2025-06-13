@extends('web.layouts.master')

@section('title', __('web.settings'))

@section('content')
<div class="container-fluid body remove-padding">
    <div class="container profile-main remove-padding">
        @include('web.profile.aside', ['active' => "settings"])

        <div class="col-md-4 col-xs-12">
            <ul class="settings-list">
                <li class="active"><a data-toggle="tab" href="#notifications-tab"><img src="{{ asset('/assets/front/img/25.svg') }}"> {{ __('web.notifications') }}</a></li>
                <li><a data-toggle="tab" href="#change-password-tab"><img src="{{ asset('/assets/front/img/26.svg') }}"> {{ __('web.change_password') }}</a></li>
                <li><a data-toggle="tab" href="#change-email-tab"><img src="{{ asset('/assets/front/img/27.svg') }}"> {{ __('web.change_email') }}</a></li>
                <li><a data-toggle="tab" href="#payment-options-tab"><img src="{{ asset('/assets/front/img/28.svg') }}"> {{ __('web.payment_options') }}</a></li>
                <li><a data-toggle="tab" href="#delete-account-tab"><img src="{{ asset('/assets/front/img/29.svg') }}">{{ __('web.delete_account') }}</a></li>
            </ul>
        </div>

        <div class="col-md-4 col-xs-12 setting-tabs-main">
            <div class="tab-content">
                <div id="notifications-tab" class="tab-pane fade in active">
                    <form action="{{ route('profile.settings.notifications.store') }}" method="POST">
                        @csrf

                        <div class="col-xs-12 remove-padding switch-main">
                            <p>Push Notifications</p>
                            <label class="switch">
                                <input type="hidden" name="push_notify" value="0">
                                <input type="checkbox" name="push_notify" id="push_notify" value="1" @checked($user->push_notify == 1)>
                                <span class="slider round"></span>
                            </label>
                        </div>

                        <div class="col-xs-12 remove-padding switch-main">
                            <p>Notifications Emails</p>
                            <label class="switch">
                                <input type="hidden" name="email_notify" value="0">
                                <input type="checkbox" name="email_notify" id="email_notify" value="1" @checked($user->email_notify == 1)>
                                <span class="slider round"></span>
                            </label>
                        </div>

                        <button type="submit" style="margin-top: 10px;">{{ __('web.done') }}</button>
                    </form>
                </div>

                <div id="change-password-tab" class="tab-pane fade">
                    <h3>Enter your current password to change password</h3>
                    <form id="change-password-form" action="{{ route('profile.settings.password.update') }}" method="POST">
                        @csrf

                        <div class="col-xs-12 remove-padding old_password_div">
                            <input type="password" id="pass_log_id6" name="old_password" placeholder="Old Password">
                            <span toggle="#password-field6" class="ri-eye-fill ri-eye-off-fill toggle-password6"></span>
                            <h6>Must contain 8 character</h6>
                        </div>

                        <div class="col-xs-12 remove-padding new_password_div">
                            <input type="password" id="pass_log_id7" name="new_password" placeholder="New Password">
                            <span toggle="#password-field7" class="ri-eye-fill ri-eye-off-fill toggle-password7"></span>
                            <h6>Must contain 8 character</h6>
                        </div>

                        <div class="col-xs-12 remove-padding">
                            <input type="password" id="pass_log_id8" name="new_password_confirmation" placeholder="New Password Confirmation">
                            <span toggle="#password-field8" class="ri-eye-fill ri-eye-off-fill toggle-password8"></span>
                            <h6>Must contain 8 character</h6>
                        </div>

                        <button type="submit" style="margin-top: 10px;">{{ __('web.done') }}</button>
                    </form>
                </div>

                <div id="change-email-tab" class="tab-pane fade">
                    <div id="new_email_div">
                        <h3>{{ __('web.enter_new_email') }}</h3>
                        <form id="profile_email_update" action="{{ route('profile.settings.email.update') }}" method="POST">
                            @csrf

                            <input type="email" name="new_email" id="new_email">
                        </form>

                        <button id="post_new_email">{{ __('web.update') }}</button>
                    </div>

                    <div id="new_email_otp_div" style="display: none;">
                        <p>{{ __('web.otp_sent_to_new_email') }}</p>
                        <p id="set_email"></p>
                        <form id="new_email_otp_form" action="{{ route('profile.settings.verify.email.update') }}" method="POST">
                            @csrf

                            <div class="row">
                                <div class="col-xs-12 remove-padding otp-main otp-input">
                                    <div class="col-xs-2"><input type="number" class="otp_digit"> </div>
                                    <div class="col-xs-2"><input type="number" class="otp_digit"> </div>
                                    <div class="col-xs-2"><input type="number" class="otp_digit"> </div>
                                    <div class="col-xs-2"><input type="number" class="otp_digit"> </div>
                                    <div class="col-xs-2"><input type="number" class="otp_digit"> </div>
                                    <div class="col-xs-2"><input type="number" class="otp_digit"> </div>
                                </div>
                            </div>
                            <div class="col-xs-12 remove-padding"></div>
                            <button type="submit" style="margin-top: 10px;">{{ __('web.done') }}</button>
                        </form>
                        <p>Didn't receive the code ? <a href="javascript:void(0);" id="set-resend-link" class="set-resend-link disabled">Resend</a><br><span id="set-timer"></span></p>

                        <form id="verify_update_email_form" method="POST" action="{{ route('resend.otp') }}">
                            @csrf

                            <input type="hidden" name="resend_otp_user" value="{{ auth()->id() }}">
                        </form>
                    </div>
                </div>

                <div id="payment-options-tab" class="tab-pane fade">
                    <img src="{{ asset('/assets/front/img/30.svg') }}">
                    <h2>{{ __('web.no_payment_methods') }}</h2>

                    {{-- <ul class="Payment-Methods">
                        <li class="col-xs-12 remove-padding">
                            <h5>Mastercard***0409<br><span>Expiration Date:01/22</span></h5>
                            <button data-toggle="modal" data-target="#del-Method">Remove</button>
                        </li>
                        <li class="col-xs-12 remove-padding">
                            <h5>Mastercard***0409<br><span>Expiration Date:01/22</span></h5>
                            <button>Remove</button>
                        </li>
                        <li class="col-xs-12 remove-padding">
                            <h5>Visa***0409<br><span>Expiration Date:01/22</span></h5>
                            <button>Remove</button>
                        </li>
                        <li class="col-xs-12 remove-padding">
                            <h5>Visa***0409<br><span>Expiration Date:01/22</span></h5>
                            <button>Remove</button>
                        </li>
                    </ul> --}}
                </div>

                {{-- <div id="delete-account-tab" class="tab-pane fade">
                    <p>We need to confirm your identity before
                        deleting your account</p>
                    <form>
                        <div class="col-xs-12 remove-padding">
                            <input type="password" id="pass_log_id9" name="pass2" placeholder="The current password">
                            <span toggle="#password-field8" class="ri-eye-fill toggle-password9"></span>
                            <h6>Must contain 8 character</h6>
                        </div>
                        <button>Confirm Delete my Account</button>
                    </form>
                </div> --}}
            </div>
        </div>
    </div>
</div>

<div id="change-password-modal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <span class="close" data-dismiss="modal"><i class="ri-close-line"></i></span>
            <img src="{{ asset('/assets/front/img/16.svg') }}">
            <h1>Your password has been changed successfully </h1>
            <a data-dismiss="modal" href="javascript:void(0);">{{ __('web.done') }}</a>
        </div>
    </div>
</div>

<div id="change-email-model" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <span class="close" data-dismiss="modal"><i class="ri-close-line"></i></span>
            <img src="{{ asset('/assets/front/img/16.svg') }}">
            <h1>Your Email has been changed successfully</h1>
            <a data-dismiss="modal" href="javascript:void(0);">{{ __('web.done') }}</a>
        </div>
    </div>
</div>

<div id="del-Method" class="modal fade del-model" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <h3>Remove Payment Option</h3>
            <span class="close" data-dismiss="modal"><i class="ri-close-line"></i></span>
            <img src="{{ asset('/assets/front/img/31.svg') }}">
            <h1>Are you sure you want to Remove
                this Credit Cardfrom ?</h1>
            <p>Remove this credit card from your payment options list</p>
            <ul>
                <li><a data-dismiss="modal" href="javascript:void(0);">{{ __('web.cancel') }}</a></li>
                <li><a href="javascript:void(0);">{{ __('web.remove') }}</a></li>
            </ul>
        </div>
    </div>
</div>

{{-- <div id="del-Account" class="modal fade del-model" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <h3>Delete your account</h3>
            <span class="close" data-dismiss="modal"><i class="ri-close-line"></i></span>
            <img src="{{ asset('/assets/front/img/32.svg') }}">
            <h1>To delete your account you Must cancel all open tenders bid or withdraw your proposals for the open tenders bid</h1>
            <ul>
                <li><a data-dismiss="modal" href="javascript:void(0);">{{ __('web.ok') }}</a></li>
            </ul>
        </div>
    </div>
</div> --}}

@endsection

@section('script')
<script src="{{ asset('/assets/front/js/profile.js') }}"></script>

<script type="text/javascript">
    $(document).on('click', '.toggle-password6', function() {
        $(this).toggleClass("ri-eye-off-fill");
        var input = $("#pass_log_id6");
        input.attr('type') === 'password' ? input.attr('type', 'text') : input.attr('type', 'password')
    });

    $(document).on('click', '.toggle-password7', function() {
        $(this).toggleClass("ri-eye-off-fill");
        var input = $("#pass_log_id7");
        input.attr('type') === 'password' ? input.attr('type', 'text') : input.attr('type', 'password')
    });

    $(document).on('click', '.toggle-password8', function() {
        $(this).toggleClass("ri-eye-off-fill");
        var input = $("#pass_log_id8");
        input.attr('type') === 'password' ? input.attr('type', 'text') : input.attr('type', 'password')
    });

    $(document).on('click', '.toggle-password9', function() {
        $(this).toggleClass("ri-eye-off-fill");
        var input = $("#pass_log_id9");
        input.attr('type') === 'password' ? input.attr('type', 'text') : input.attr('type', 'password')
    });

    $('#change-password-form').on("submit", function(e) {
        e.preventDefault();

        $.each($(".error"), function() {
            $(this).removeClass('error');
        });

        $.each($(".error_text"), function() {
            $(this).remove();
        });

        $.ajax({
            type: $('#change-password-form').attr('method')
            , url: $('#change-password-form').attr('action')
            , data: $('#change-password-form').serialize()
            , success: function(data) {
                $(':input', '#change-password-form')
                    .not(':button, :submit, :reset, :hidden')
                    .val('')
                    .prop('checked', false)
                    .prop('selected', false);

                $('#change-password-modal').modal('show');
            }
            , error: function(error) {
                if (error.responseJSON.messages) {
                    var errors = error.responseJSON.messages;
                    $.each(errors, function(index, messageArr) {
                        $("." + index + "_div").addClass('error');
                        $.each(messageArr, function(key, message) {
                            $("." + index + "_div").append(`<h6 class='error_text'>${message}</h6>`);
                        });
                    });
                } else {
                    alert(error.responseJSON.data.error);
                }
                return false;
            }
        , });
    });

    $("#post_new_email").click(function() {
        $('#profile_email_update').submit();
    });

    $('#profile_email_update').on("submit", function(e) {
        e.preventDefault();

        $.ajax({
            type: $('#profile_email_update').attr('method')
            , url: $('#profile_email_update').attr('action')
            , data: $('#profile_email_update').serialize()
            , success: function(data) {
                var newEmail = $("#new_email").val();
                $("#new_email_div").hide();

                $("#profile_email_update #new_email").val();

                $(':input', '#profile_email_update')
                    .not(':button, :submit, :reset, :hidden')
                    .val('')
                    .prop('checked', false)
                    .prop('selected', false);

                $("#new_email_otp_div #set_email").text(newEmail);

                $("#new_email_otp_div").show();

                let timerId;

                startTimer('set-timer', 10, timerId, 'set-resend-link');
            }
            , error: function(error) {
                if (error.responseJSON.messages) {
                    var errors = error.responseJSON.messages;
                    $.each(errors, function(index, messageArr) {
                        $("#" + index + "_div").addClass('error');
                        $.each(messageArr, function(key, message) {
                            $("#" + index + "_div").append(`<h6 class='error_text'>${message}</h6>`);
                        });
                    });
                } else {
                    alert(error.responseJSON.data.error);
                }
                return false;
            }
        });
    });

    $(".set-resend-link").click(function() {
        $("#verify_update_email_form").submit();
    });

    $('#verify_update_email_form').on("submit", function(e) {
        e.preventDefault();

        $.ajax({
            type: $('#verify_update_email_form').attr('method')
            , url: $('#verify_update_email_form').attr('action')
            , data: $('#verify_update_email_form').serialize()
            , success: function(data) {
                let timerId;

                startTimer('set-timer', 10, timerId, 'set-resend-link');
            }
            , error: function(error) {
                if (error.responseJSON.messages) {
                    var errors = error.responseJSON.messages;
                    $.each(errors, function(index, messageArr) {
                        $("#" + index + "_div").addClass('error');
                        $.each(messageArr, function(key, message) {
                            $("#" + index + "_div").append(`<h6 class='error_text'>${message}</h6>`);
                        });
                    });
                } else {
                    alert(error.responseJSON.data.error);
                }
                return false;
            }
        });
    });

    $('#new_email_otp_form').on("submit", function(e) {
        e.preventDefault();

        var otpFinal = '';

        $.each($(".error"), function() {
            $(this).removeClass('error');
        });

        $.each($(".error_text"), function() {
            $(this).remove();
        });

        $.each($(".otp_digit"), function() {
            otpFinal = otpFinal + $(this).val();
        });

        $.ajax({
            type: $('#new_email_otp_form').attr('method')
            , url: $('#new_email_otp_form').attr('action')
            , data: {
                "_token": "{{ csrf_token() }}"
                , "otp": otpFinal
            }
            , success: function(data) {
                $(':input', '#new_email_otp_form')
                    .not(':button, :submit, :reset, :hidden')
                    .val('')
                    .prop('checked', false)
                    .prop('selected', false);

                $("#new_email_otp_div #set_email").text('');

                location.reload();
            }
            , error: function(error) {
                if (error.responseJSON.messages) {
                    var errors = error.responseJSON.messages;
                    $.each(errors, function(index, messageArr) {
                        $("#" + index + "_div").addClass('error');
                        $.each(messageArr, function(key, message) {
                            $("#" + index + "_div").append(`<h6 class='error_text'>${message}</h6>`);
                        });
                    });
                } else {
                    alert(error.responseJSON.data.error);
                }
                return false;
            }
        , });
    });

</script>

@endsection
