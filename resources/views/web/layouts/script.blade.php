<script src="{{ asset('/assets/front/js/jquery-1.11.2.min.js') }}"></script>
<script src="{{ asset('/assets/front/js/bootstrap.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://code.jquery.com/ui/1.14.1/jquery-ui.js"></script>
<script src="{{ asset('/assets/front/js/jquery.uploader.min.js') }}"></script>

<script type="text/javascript">
    $(document).ready(function() {

        $(".mobile-menu-btn").click(function() {
            $('.mobile-menu-container').toggleClass('open-menu');
        });

        $(document).on('click', '.toggle-password1', function() {
            $(this).toggleClass("ri-eye-off-fill");
            var input = $("#login_password");
            input.attr('type') === 'password' ? input.attr('type', 'text') : input.attr('type', 'password')
        });

        $(document).on('click', '.toggle-password2', function() {
            $(this).toggleClass("ri-eye-off-fill");
            var input = $("#individual_password");
            input.attr('type') === 'password' ? input.attr('type', 'text') : input.attr('type', 'password')
        });

        $(document).on('click', '.toggle-password3', function() {
            $(this).toggleClass("ri-eye-off-fill");
            var input = $("#individual_password_confirmation");
            input.attr('type') === 'password' ? input.attr('type', 'text') : input.attr('type', 'password')
        });

        $(document).on('click', '.toggle-password4', function() {
            $(this).toggleClass("ri-eye-off-fill");
            var input = $("#company_password");
            input.attr('type') === 'password' ? input.attr('type', 'text') : input.attr('type', 'password')
        });

        $(document).on('click', '.toggle-password5', function() {
            $(this).toggleClass("ri-eye-off-fill");
            var input = $("#company_password_confirmation");
            input.attr('type') === 'password' ? input.attr('type', 'text') : input.attr('type', 'password')
        });

        $('#signUp input:radio').change(function() {
            $("#signUp .col-xs-12").removeClass("checked");
            $(this).closest('.col-xs-12').addClass("checked");
        });

        $('.js-example-basic-single').select2();
        // $('.country-select').select2();
        $('.country-select').select2({
            dropdownCssClass: "country-select"
        });
    });

</script>

<script type="text/javascript">
    $(document).ready(function() {});

    $('input[type=radio][name=type]').change(function() {
        if (this.value == 'company') {
            $('#account_form_btn').attr('data-target', '#signUp-company-form');
        } else if (this.value == 'individual') {
            $('#account_form_btn').attr('data-target', '#signUp-individual-form');
        }
    });

    $('#login_form').on("submit", function(e) {
        e.preventDefault();

        $.each($(".error"), function() {
            $(this).removeClass('error');
        });

        $.each($(".error_text"), function() {
            $(this).remove();
        });

        $.ajax({
            type: $('#login_form').attr('method')
            , url: $('#login_form').attr('action')
            , data: $('#login_form').serialize()
            , success: function(data) {
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
                $('#verify_resend_link_form input[name="resend_otp_user"]').val(userIDVal);

                $('#signUp-individual-form').modal('hide');
                $('#verify-otp-form').modal('show');

                let timerId;

                startTimer('verify-timer', 10, timerId, 'verify-resend-link');
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
                $('#verify_resend_link_form input[name="resend_otp_user"]').val(userIDVal);

                $('#signUp-company-form').modal('hide');
                $('#verify-otp-form').modal('show');

                let timerId;

                startTimer('verify-timer', 10, timerId, 'verify-resend-link');
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
                var userIDVal = data.data.user.id;
                var userEmailVal = data.data.user.email;

                $(':input', '#forget_password_form')
                    .not(':button, :submit, :reset, :hidden')
                    .val('')
                    .prop('checked', false)
                    .prop('selected', false);

                $("#reset-password-otp #reset_otp_user").val(userIDVal);
                $("#reset-password-otp #reset_sent_email").text(userEmailVal);
                $('#reset_resend_link_form input[name="resend_otp_user"]').val(userIDVal);

                $('#forgot-passord-div').modal('hide');
                $('#reset-password-otp').modal('show');

                let timerId;

                startTimer('reset-timer', 10, timerId, 'reset-resend-link');
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

    $("#logout_btn").click(function() {
        $('#logout_form').submit();
    });

    $('#logout_form').on("submit", function(e) {
        e.preventDefault();

        if (confirm('Are you sure you want to log out?')) {
            $.ajax({
                type: $('#logout_form').attr('method')
                , url: $('#logout_form').attr('action')
                , data: $('#logout_form').serialize()
                , success: function(data) {
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
            });
        }
    });

    function startTimer(className, timeLeft, timerId, linkClass) {
        const inputs = document.querySelectorAll('.otp-input input');

        inputs.forEach((input, index) => {
            input.addEventListener('input', (e) => {
                if (e.target.value.length > 1) {
                    e.target.value = e.target.value.slice(0, 1);
                }
                if (e.target.value.length === 1) {
                    if (index < inputs.length - 1) {
                        inputs[index + 1].focus();
                    }
                }
            });

            input.addEventListener('keydown', (e) => {
                if (e.key === 'Backspace' && !e.target.value) {
                    if (index > 0) {
                        inputs[index - 1].focus();
                    }
                }
                if (e.key === 'e') {
                    e.preventDefault();
                }
            });
        });

        timerId = setInterval(() => {
            if (timeLeft <= 0) {
                clearInterval(timerId);
                $("#" + className).text("00:00");
                // inputs.forEach(input => input.disabled = true);
                $("." + linkClass).removeClass('disabled');
            } else {
                $("." + linkClass).addClass('disabled');
                const minutes = Math.floor(timeLeft / 60);
                const seconds = timeLeft % 60;
                $("#" + className).text(`(${minutes}:${seconds.toString().padStart(2, '0')})`);
                timeLeft--;
            }
        }, 1000);
    }

    $(".reset-resend-link").click(function() {
        $("#reset_resend_link_form").submit();
    });

    $('#reset_resend_link_form').on("submit", function(e) {
        e.preventDefault();

        $.ajax({
            type: $('#reset_resend_link_form').attr('method')
            , url: $('#reset_resend_link_form').attr('action')
            , data: $('#reset_resend_link_form').serialize()
            , success: function(data) {
                let timerId;

                startTimer('reset-timer', 10, timerId, 'reset-resend-link');
                alert('Resend Reset OTP Mail');
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

    $(".verify-resend-link").click(function() {
        $("#verify_resend_link_form").submit();
    });

    $('#verify_resend_link_form').on("submit", function(e) {
        e.preventDefault();

        $.ajax({
            type: $('#verify_resend_link_form').attr('method')
            , url: $('#verify_resend_link_form').attr('action')
            , data: $('#verify_resend_link_form').serialize()
            , success: function(data) {
                let timerId;
                startTimer('verify-timer', 10, timerId, 'verify-resend-link');
                alert('Resend Reset OTP Mail');
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

</script>

@yield('script')
