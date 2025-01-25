$("#logout-btn").click(function () {
    $("#profile_logout_form").submit();
});

$("#profile_logout_form").on("submit", function (e) {
    e.preventDefault();

    $.ajax({
        type: $("#logout_form").attr("method"),
        url: $("#logout_form").attr("action"),
        data: $("#logout_form").serialize(),
        success: function (data) {
            localStorage.removeItem("auth_token");

            location.reload();
        },
        error: function (error) {
            if (error.responseJSON.messages) {
                var errors = error.responseJSON.messages;
                $.each(errors, function (index, messageArr) {
                    $("#" + index + "_div").addClass("error");
                    $.each(messageArr, function (key, message) {
                        $("#" + index + "_div").append(
                            `<h6 class='error_text'>${message}</h6>`
                        );
                    });
                });
            } else {
                alert(error.responseJSON.data.error);
            }
            return false;
        },
    });
});
