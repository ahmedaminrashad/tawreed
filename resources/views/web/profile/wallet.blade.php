@extends('web.layouts.master')

@section('title', 'Profile - Settings')

@section('content')
<div class="container-fluid body remove-padding">
    <div class="container profile-main remove-padding">
        @include('web.profile.aside', ['active' => "wallet"])
        
        <div class="col-md-8 wallet-main">
            <div class="col-xs-12 text-center wallet-empty">
                <img src="{{ asset('/assets/front/img/36.svg') }}">
                <h3>No balance in Wallet</h3>
            </div>
        </div>
    </div>
</div>


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
