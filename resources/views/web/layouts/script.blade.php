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

        $('.js-example-basic-single').select2(
            {
                dir: "{{app()->getLocale() == 'ar'?'rtl':'ltr'}}"
            }
        );
        // $('.country-select').select2();
        $('.country-select').select2({
            dropdownCssClass: "country-select",
            dir: "{{app()->getLocale() == 'ar'?'rtl':'ltr'}}"
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

        // Show loading state
        var $btn = $('#individual_register_btn');
        var $btnText = $btn.find('.btn-text');
        var $btnLoading = $btn.find('.btn-loading');
        $btn.prop('disabled', true);
        $btnText.hide();
        $btnLoading.show();

        $.each($(".error"), function() {
            $(this).removeClass('error');
        });

        $.each($(".error_text"), function() {
            $(this).remove();
        });

        // Hide general error message
        $('#individual_form_error_message').hide();

        $.ajax({
            type: $('#signUp_individual_form').attr('method')
            , url: $('#signUp_individual_form').attr('action')
            , data: $('#signUp_individual_form').serialize()
            , success: function(data) {
                // Reset button state
                $btn.prop('disabled', false);
                $btnText.show();
                $btnLoading.hide();

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

                $('#signUp').modal('hide');
                $('#signUp-individual-form').modal('hide');
                $('#verify-otp-form').modal('show');

                let timerId;

                startTimer('verify-timer', 10, timerId, 'verify-resend-link');
            }
            , error: function(error) {
                // Reset button state
                $btn.prop('disabled', false);
                $btnText.show();
                $btnLoading.hide();

                if (error.responseJSON && error.responseJSON.messages) {
                    var errors = error.responseJSON.messages;
                    $.each(errors, function(index, messageArr) {
                        $("#" + index + "_div").addClass('error');
                        $.each(messageArr, function(key, message) {
                            $("#" + index + "_div").append(`<h6 class='error_text'>${message}</h6>`);
                        });
                    });
                } else if (error.responseJSON && error.responseJSON.data && error.responseJSON.data.error) {
                    // Show general error message in form
                    $('#individual_form_error_message h6.error_text').text(error.responseJSON.data.error);
                    $('#individual_form_error_message').show();
                } else if (error.responseJSON && error.responseJSON.message) {
                    // Show error message from response
                    $('#individual_form_error_message h6.error_text').text(error.responseJSON.message);
                    $('#individual_form_error_message').show();
                } else {
                    $('#individual_form_error_message h6.error_text').text('An error occurred. Please try again.');
                    $('#individual_form_error_message').show();
                }
                return false;
            }
        , });
    });

    $('#signUp_company_form').on("submit", function(e) {
        e.preventDefault();

        // Show loading state
        var $btn = $('#company_register_btn');
        var $btnText = $btn.find('.btn-text');
        var $btnLoading = $btn.find('.btn-loading');
        $btn.prop('disabled', true);
        $btnText.hide();
        $btnLoading.show();

        $.each($(".error"), function() {
            $(this).removeClass('error');
        });

        $.each($(".error_text"), function() {
            $(this).remove();
        });

        // Hide general error message
        $('#company_form_error_message').hide();

        $.ajax({
            type: $('#signUp_company_form').attr('method')
            , url: $('#signUp_company_form').attr('action')
            , data: $('#signUp_company_form').serialize()
            , success: function(data) {
                // Reset button state
                $btn.prop('disabled', false);
                $btnText.show();
                $btnLoading.hide();

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

                $('#signUp').modal('hide');
                $('#signUp-company-form').modal('hide');
                $('#verify-otp-form').modal('show');

                let timerId;

                startTimer('verify-timer', 10, timerId, 'verify-resend-link');
            }
            , error: function(error) {
                // Reset button state
                $btn.prop('disabled', false);
                $btnText.show();
                $btnLoading.hide();

                if (error.responseJSON && error.responseJSON.messages) {
                    var errors = error.responseJSON.messages;
                    $.each(errors, function(index, messageArr) {
                        $("#" + index + "_div").addClass('error');
                        $.each(messageArr, function(key, message) {
                            $("#" + index + "_div").append(`<h6 class='error_text'>${message}</h6>`);
                        });
                    });
                } else if (error.responseJSON && error.responseJSON.data && error.responseJSON.data.error) {
                    // Show general error message in form
                    $('#company_form_error_message h6.error_text').text(error.responseJSON.data.error);
                    $('#company_form_error_message').show();
                } else if (error.responseJSON && error.responseJSON.message) {
                    // Show error message from response
                    $('#company_form_error_message h6.error_text').text(error.responseJSON.message);
                    $('#company_form_error_message').show();
                } else {
                    $('#company_form_error_message h6.error_text').text('An error occurred. Please try again.');
                    $('#company_form_error_message').show();
                }
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
    $(document).ready(function () {
        $('.gallery-item').click(function () {
            const imgSrc = $(this).attr('src');
            $('#lightbox-img').attr('src', imgSrc);
            $('#lightbox').fadeIn();
        });

        $('.close').click(function () {
            $('#lightbox').fadeOut();
        });

        $('#lightbox').click(function (e) {
            if (e.target.id === 'lightbox-img') return;
            $('#lightbox').fadeOut();
        });

        // Notifications
        @if(auth('web')->check())
        loadNotificationCount();
        loadNotifications('all');

        // Mark all notifications as read when dropdown is opened
        $('#notification-btn').on('click', function() {
            // Small delay to ensure dropdown opens first
            setTimeout(function() {
                markAllNotificationsAsRead();
            }, 100);
        });

        // Prevent dropdown from closing when clicking inside notification menu
        $('.notification-main').on('click', function(e) {
            e.stopPropagation();
        });

        // Load notifications when tab is clicked
        $('.tab label').on('click', function(e) {
            e.stopPropagation(); // Prevent event from bubbling up and closing dropdown
            var type = $(this).data('type');
            loadNotifications(type);
        });

        // Mark notification as read when clicked
        $(document).on('click', '.notification-item', function(e) {
            e.stopPropagation(); // Prevent event from bubbling up and closing dropdown
            var notificationId = $(this).data('id');
            // Only mark as read if it's an unread notification
            if (notificationId && $(this).hasClass('unread-notification')) {
                markNotificationAsRead(notificationId);
            }
        });

        // Refresh notification count every 30 seconds
        setInterval(function() {
            loadNotificationCount();
        }, 30000);
        @endif
    });

    @if(auth('web')->check())
    function loadNotificationCount() {
        $.ajax({
            url: '{{ route("notifications.unread-count") }}',
            type: 'GET',
            success: function(response) {
                if (response.success) {
                    var count = response.data.unread_count;
                    if (count > 0) {
                        $('#notification-count').text(count).show();
                    } else {
                        $('#notification-count').hide();
                    }
                }
            }
        });
    }

    function loadNotifications(type) {
        var containerId = 'notifications-list-' + type;
        var $container = $('#' + containerId);
        
        $container.html('<div class="col-xs-12 remove-padding text-center" style="padding: 20px;"><p>{{ __("web.loading") }}...</p></div>');

        $.ajax({
            url: '{{ route("notifications.index") }}',
            type: 'GET',
            data: { type: type },
            success: function(response) {
                if (response.success) {
                    var notifications = response.data.notifications;
                    var html = '<div class="col-xs-12 remove-padding">';
                    
                    if (notifications.length === 0) {
                        html += '<div class="col-xs-12 remove-padding text-center" style="padding: 20px;"><p>{{ __("web.no_notifications") }}</p></div>';
                    } else {
                        notifications.forEach(function(notification) {
                            var itemClass = notification.is_read ? 'notification-item' : 'notification-item unread-notification';
                            html += '<div class="col-xs-12 remove-padding ' + itemClass + '" data-id="' + notification.id + '">';
                            html += '<img src="{{ asset("/assets/front/img/1.png") }}">';
                            html += '<a href="javascript:void(0);">' + notification.message + '</a>';
                            html += '<h5>' + notification.time_ago + '</h5>';
                            html += '</div>';
                        });
                    }
                    
                    html += '</div>';
                    $container.html(html);
                }
            },
            error: function() {
                $container.html('<div class="col-xs-12 remove-padding text-center" style="padding: 20px;"><p>{{ __("web.error_loading_notifications") }}</p></div>');
            }
        });
    }

    function markNotificationAsRead(notificationId) {
        $.ajax({
            url: '{{ route("notifications.read", ":id") }}'.replace(':id', notificationId),
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                if (response.success) {
                    // Update notification count
                    var count = response.data.unread_count;
                    if (count > 0) {
                        $('#notification-count').text(count).show();
                    } else {
                        $('#notification-count').hide();
                    }
                    
                    // Reload current tab
                    var activeTab = $('input[name="css-tabs"]:checked').attr('id');
                    var type = activeTab === 'tab1' ? 'all' : (activeTab === 'tab2' ? 'unread' : 'read');
                    loadNotifications(type);
                }
            },
            error: function(xhr, status, error) {
                console.error('Error marking notification as read:', error);
                console.error('Response:', xhr.responseText);
            }
        });
    }

    function markAllNotificationsAsRead() {
        $.ajax({
            url: '{{ route("notifications.read-all") }}',
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                if (response.success) {
                    // Update notification count
                    var count = response.data.unread_count || 0;
                    if (count > 0) {
                        $('#notification-count').text(count).show();
                    } else {
                        $('#notification-count').hide();
                    }
                    
                    // Reload current tab to update notification status
                    var activeTab = $('input[name="css-tabs"]:checked').attr('id');
                    var type = activeTab === 'tab1' ? 'all' : (activeTab === 'tab2' ? 'unread' : 'read');
                    loadNotifications(type);
                }
            },
            error: function(xhr, status, error) {
                console.error('Error marking all notifications as read:', error);
            }
        });
    }
    @endif

</script>

@yield('script')
