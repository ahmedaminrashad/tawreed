function messageBox(options, done, cancel) {
    var dialog = $("#message_box_modal");
    if (dialog.length > 0) dialog.remove();

    dialog = $(
        "\
        <div class='modal fade' id='message_box_modal' tabindex='-1' role='dialog' aria-labelledby='message_box_modal' aria-hidden='true'>\
        <div class='modal-dialog' role='document'>\
            <div class='modal-content'> \
                <div class='modal-header'>\
                    <h5 class='modal-title' id='message_box_modal_label'></h5>\
                    <button type='button' class='close' data-dismiss='modal' aria-label='Close'>\
                        <span aria-hidden='true'>&times;</span>\
                    </button>\
                </div>\
                <div class='modal-body'>\
                </div>\
                <div class='modal-footer'>\
                </div>\
            </div>\
        </div>\
    </div>"
    );

    if (options.confirm) {
        if (options.danger) {
            var html =
                "\
            <button type='button' class='btn btn-primary' id='action'>OK</button>\
            <button type='button' class='btn btn-secondary' id='close'>Cancel</button>";
            dialog.find(".modal-footer").html(html);
        } else {
            var html =
                "\
            <button type='button' class='btn btn-primary' id='action'>OK</button>\
            <button type='button' class='btn btn btn-light' id='close'>Cancel</button>";
            dialog.find(".modal-footer").html(html);
        }
    } else {
        if (options.danger) {
            var html =
                "\
            <button type='button' class='btn btn-danger' id='action'>Close</button>";
            dialog.find(".modal-footer").html(html);
        } else {
            var html =
                "\
            <button type='button' class='btn btn-success' id='action'>Close</button>";
            dialog.find(".modal-footer").html(html);
        }
    }

    $("body").append(dialog);

    if (typeof options == "string") {
        dialog.find(".modal-title").html("Information");
        dialog.find(".modal-body").html(options);
    } else {
        dialog.find(".modal-title").html(options.title);
        dialog.find(".modal-body").html(options.body);
    }

    dialog.find("#action").on("click", function () {
        dialog.modal("hide").on("hidden.bs.modal", function () {
            if (done != null) done();
        });
    });

    dialog.find("#close").on("click", function () {
        dialog.modal("hide").on("hidden.bs.modal", function () {
            if (cancel != null) cancel();
        });
    });

    dialog.modal({ backdrop: "static" });

    dialog.on("hidden.bs.modal", function () {
        dialog.remove();
    });
}

function infoBox(body, done) {
    messageBox({ title: "Information", body: body }, done);
}

function confirmBox(body, done, danger) {
    messageBox(
        { title: "Confirmation?", body: body, confirm: true, danger: danger },
        done
    );
}

function errorBox(body, done) {
    messageBox({ title: "Error!!", body: body, danger: true }, done);
}

function warningBox(body, done) {
    messageBox(
        { title: "Warning!", body: body, danger: true, confirm: true },
        done
    );
}
