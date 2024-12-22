<script src="{{ asset('/assets/front/js/jquery-1.11.2.min.js') }}"></script>
<script src="{{ asset('/assets/front/js/bootstrap.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script type="text/javascript">
    $(document).ready(function() {

        $(".mobile-menu-btn").click(function() {
            $('.mobile-menu-container').toggleClass('open-menu');
        });

        $(document).on('click', '.toggle-password1', function() {
            $(this).toggleClass("ri-eye-off-fill");
            var input = $("#pass_log_id");
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
            var input = $("#pass_log_id4");
            input.attr('type') === 'password' ? input.attr('type', 'text') : input.attr('type', 'password')
        });

        $(document).on('click', '.toggle-password5', function() {
            $(this).toggleClass("ri-eye-off-fill");
            var input = $("#pass_log_id5");
            input.attr('type') === 'password' ? input.attr('type', 'text') : input.attr('type', 'password')
        });

        $('#signUp input:radio').change(function() {
            $("#signUp .col-xs-12").removeClass("checked");
            $(this).closest('.col-xs-12').addClass("checked");
        });

        let time_limit = 30;
        let time_out = setInterval(() => {

            if (time_limit == 0) {
                $('#timer').html('Time Over');
            } else {
                if (time_limit < 10) {
                    time_limit = 0 + '' + time_limit;
                }
                $('#timer').html('00:' + time_limit);
                time_limit -= 1;
            }
        }, 1000);

        $('.js-example-basic-single').select2();
        // $('.country-select').select2();
        // $('.country-select').select2({
        //     dropdownCssClass: "country-select"
        // });
    });

</script>

@yield('script')
