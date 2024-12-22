<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Styles -->
    @include('web.layouts.head')
</head>
<body>

    <!-- Header -->
    @include('web.layouts.header')

    <!-- Content -->
    <div class="container-fluid body">
        @yield('content')
    </div>

    <!-- Footer -->
    @include('web.layouts.footer')

    <!-- Scripts -->
    @include('web.layouts.script')
    

    <script type="text/javascript">
        $(document).ready(function() {
            $('.country-select').select2();
        });
    
        $('input[type=radio][name=type]').change(function() {
            if (this.value == 'company') {
                $('#account_form_btn').attr('data-target', '#signUp-company-form');
            } else if (this.value == 'individual') {
                $('#account_form_btn').attr('data-target', '#signUp-individual-form');
            }
        });
    
        $('#signUp_individual_form').on("submit", function(e) {
            e.preventDefault();
    
            $.each($(".error"), function() {
                $(this).removeClass('error');
            });
    
            $.each($(".error_text"), function() {
                $(this).remove();
            });
    
            $.ajax({
                type: $('#signUp_individual_form').attr('method')
                , url: $('#signUp_individual_form').attr('action')
                , data: $('#signUp_individual_form').serialize()
                , success: function(data) {
                    var userIDVal = data.data.user.id;
                    var userEmailVal = data.data.user.email;
    
                    $(':input', '#signUp_individual_form')
                        .not(':button, :submit, :reset, :hidden')
                        .val('')
                        .prop('checked', false)
                        .prop('selected', false);
    
                    $("#read_individual").prop('checked', false);
                    $(".country-select").val('').trigger('change');
    
                    $("#verify-otp-form #otp_user").val(userIDVal);
                    $("#verify-otp-form #set_sent_email").text(userEmailVal);
    
                    $('#signUp-individual-form').modal('hide');
                    $('#verify-otp-form').modal('show');
                }
                , error: function(error) {
                    var errors = error.responseJSON.messages;
                    $.each(errors, function(index, messageArr) {
                        $("#" + index + "_div").addClass('error');
                        $.each(messageArr, function(key, message) {
                            $("#" + index + "_div").append(`<h6 class='error_text'>${message}</h6>`);
                        });
                    });
                    return false;
                }
            , });
        });
    
        $('#signUp_company_form').on("submit", function(e) {
            e.preventDefault();
    
            $.each($(".error"), function() {
                $(this).removeClass('error');
            });
    
            $.each($(".error_text"), function() {
                $(this).remove();
            });
    
            $.ajax({
                type: $('#signUp_company_form').attr('method')
                , url: $('#signUp_company_form').attr('action')
                , data: $('#signUp_company_form').serialize()
                , success: function(data) {
                    var userIDVal = data.data.user.id;
                    var userEmailVal = data.data.user.email;
    
                    $(':input', '#signUp_company_form')
                        .not(':button, :submit, :reset, :hidden')
                        .val('')
                        .prop('checked', false)
                        .prop('selected', false);
    
                    $("#read_company").prop('checked', false);
                    $(".country-select").val('').trigger('change');
    
                    $("#verify-otp-form #otp_user").val(userIDVal);
                    $("#verify-otp-form #set_sent_email").text(userEmailVal);
    
                    $('#signUp-company-form').modal('hide');
                    $('#verify-otp-form').modal('show');
                }
                , error: function(error) {
                    var errors = error.responseJSON.messages;
                    $.each(errors, function(index, messageArr) {
                        $("#" + index + "_div").addClass('error');
                        $.each(messageArr, function(key, message) {
                            $("#" + index + "_div").append(`<h6 class='error_text'>${message}</h6>`);
                        });
                    });
                    return false;
                }
            , });
        });
    
        $('#otp_verify_form').on("submit", function(e) {
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
                type: $('#otp_verify_form').attr('method')
                , url: $('#otp_verify_form').attr('action')
                , data: {
                    "_token": "{{ csrf_token() }}"
                    , "otp_user": $("#otp_user").val()
                    , "otp": otpFinal
                }
                , success: function(data) {
                    $(':input', '#otp_verify_form')
                        .not(':button, :submit, :reset, :hidden')
                        .val('')
                        .prop('checked', false)
                        .prop('selected', false);
    
                    $("#verify-otp-form #otp_user").val('');
                    $("#verify-otp-form #set_sent_email").text('');
    
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
    
        $('#forget_password_form').on("submit", function(e) {
            e.preventDefault();
    
            $.each($(".error"), function() {
                $(this).removeClass('error');
            });
    
            $.each($(".error_text"), function() {
                $(this).remove();
            });
    
            $.ajax({
                type: $('#forget_password_form').attr('method')
                , url: $('#forget_password_form').attr('action')
                , data: $('#forget_password_form').serialize()
                , success: function(data) {
                    // console.log(data);
                    // return false;
    
                    var userIDVal = data.data.user.id;
                    var userEmailVal = data.data.user.email;
    
                    $(':input', '#forget_password_form')
                        .not(':button, :submit, :reset, :hidden')
                        .val('')
                        .prop('checked', false)
                        .prop('selected', false);
    
                    $("#reset-password-otp #reset_otp_user").val(userIDVal);
                    $("#reset-password-otp #reset_sent_email").text(userEmailVal);
    
                    $('#forgot-passord-div').modal('hide');
                    $('#reset-password-otp').modal('show');
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
        
        $('#reset_password_otp_form').on("submit", function(e) {
            e.preventDefault();
    
            var otpFinal = '';
    
            $.each($(".error"), function() {
                $(this).removeClass('error');
            });
    
            $.each($(".error_text"), function() {
                $(this).remove();
            });
    
            $.each($(".reset_otp_digit"), function() {
                otpFinal = otpFinal + $(this).val();
            });
    
            $.ajax({
                type: $('#reset_password_otp_form').attr('method')
                , url: $('#reset_password_otp_form').attr('action')
                , data: {
                    "_token": "{{ csrf_token() }}"
                    , "new_password": $("#new_password").val()
                    , "new_password_confirmation": $("#new_password_confirmation").val()
                    , "otp_user": $("#reset_otp_user").val()
                    , "otp": otpFinal
                }
                , success: function(data) {
    
                    $(':input', '#reset_password_otp_form')
                        .not(':button, :submit, :reset, :hidden')
                        .val('')
                        .prop('checked', false)
                        .prop('selected', false);
    
                    $("#reset-password-otp #reset_otp_user").val('');
                    $("#reset-password-otp #reset_sent_email").text('');
    
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
</body>
</html>
