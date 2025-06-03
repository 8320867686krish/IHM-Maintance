$("#correspondencesSave").click(function () {
    let checkFormData = new FormData($("#addcorrespondencesForm")[0]);
    let $submitButton = $(this);
    let originalText = $submitButton.html();
    $submitButton.text('Wait...');
    $submitButton.prop('disabled', true);
    var editorData = CKEDITOR.instances['mytextarea'].getData();
    checkFormData.append('content', editorData);
    $.ajax({
        type: 'POST',
        url: $("#addcorrespondencesForm").attr('action'),
        data: checkFormData,
        contentType: false,
        processData: false,
        success: function (response) {
            if (response.isStatus) {
                successMsg(response.message);
                let form = document.getElementById('addcorrespondencesForm');
                form.reset()
                $submitButton.html(originalText);
                $submitButton.prop('disabled', false);

                $("#corospondenceModel").modal('hide');

                $("#corospondenceList").html("");
                $("#corospondenceList").html(response.html);
            } else {
                $.each(response.message, function (field, messages) {
                    $('#' + field + 'Error').text(messages[0]).show();
                    $('[name="' + field + '"]').addClass('is-invalid');
                });
                $submitButton.html(originalText);
                $submitButton.prop('disabled', false);
            }
        },
        error: function (xhr, status, error) {
            $submitButton.html(originalText);
            $submitButton.prop('disabled', false);
        }
    });
});
$("#saveadmincorospondence").click(function () {
    let checkFormData = new FormData($("#correspondencesForm")[0]);
    let $submitButton = $(this);
    let originalText = $submitButton.html();
    $submitButton.text('Wait...');
    $submitButton.prop('disabled', true);
    var editorData = CKEDITOR.instances['mytextareasuperadmin'].getData();
    checkFormData.append('content', editorData);
    $.ajax({
        type: 'POST',
        url: $("#correspondencesForm").attr('action'),
        data: checkFormData,
        contentType: false,
        processData: false,
        success: function (response) {
            if (response.isStatus) {
                successMsg(response.message);
                let form = document.getElementById('correspondencesForm');
                form.reset()
                $submitButton.html(originalText);
                $submitButton.prop('disabled', false);
                $("#admincorospondenceModel").modal('hide');

                $("#admincorospondanceList").html();
                $("#admincorospondanceList").html(response.html);

                // window.location.reload();                
            } else {
                $.each(response.message, function (field, messages) {
                    $('#' + field + 'Error').text(messages[0]).show();
                    $('[name="' + field + '"]').addClass('is-invalid');
                });
                $submitButton.html(originalText);
                $submitButton.prop('disabled', false);
            }
        },
        error: function (xhr, status, error) {
            $submitButton.html(originalText);
            $submitButton.prop('disabled', false);
        }
    });
});
$("#avilableTemplateSave").click(function () {
    let checkFormData = new FormData($("#avilabletemplateForm")[0]);
    let $submitButton = $(this);
    let originalText = $submitButton.html();
    $submitButton.text('Wait...');
    $submitButton.prop('disabled', true);
    $.ajax({
        type: 'POST',
        url: $("#avilabletemplateForm").attr('action'),
        data: checkFormData,
        contentType: false,
        processData: false,
        success: function (response) {
            if (response.isStatus) {
                successMsg(response.message);
                let form = document.getElementById('avilabletemplateForm');
                form.reset()
                $submitButton.html(originalText);
                $submitButton.prop('disabled', false);
                window.location.reload();
            } else {
                $.each(response.message, function (field, messages) {
                    $('#' + field + 'Error').text(messages[0]).show();
                    $('[name="' + field + '"]').addClass('is-invalid');
                });
                $submitButton.html(originalText);
                $submitButton.prop('disabled', false);
            }
        },
        error: function (xhr, status, error) {
            $submitButton.html(originalText);
            $submitButton.prop('disabled', false);
        }
    });
})

$(document).on('click', '.addcorospondence', function (e) {
    $("#corospondenceModel").modal('show');

});
$(document).on('click', '.addadmincorospondence', function (e) {
    $("#admincorospondenceModel").modal('show');

});
$(document).on('click', '#viewRemarks', function (e) {
    var remarks = $(this).attr('data-remarks');

    $(".remrksText").html(remarks)
    $("#remarksModel").modal('show');
});
$(document).on('click', '.delete-credential', function (e) {
    e.preventDefault();
    let deleteUrl = $(this).attr('href');
    let $deleteButton = $(this);
    let confirmMsg = "Are you sure you want to delete this credential?";

    confirmDelete(deleteUrl, confirmMsg, function (response) {
        // Success callback
        $(".credentials").html("");
        if (response.html && response.html.trim() !== '') {

            $(".credentials").html(response.html);
        }

    }, function (response) {
        // Error callback (optional)
        console.log("Failed to delete: " + response.message);
    });
});
$(document).on('click', '.delete-sms', function (e) {
    e.preventDefault();
    let deleteUrl = $(this).attr('href');
    let $deleteButton = $(this);
    let confirmMsg = "Are you sure you want to delete this sms?";

    confirmDelete(deleteUrl, confirmMsg, function (response) {
        // Success callback
        $(".credentials").html("");
        if (response.html && response.html.trim() !== '') {

            $(".smsList").html(response.html);
        }

    }, function (response) {
        // Error callback (optional)
        console.log("Failed to delete: " + response.message);
    });
});
$(document).on("click", "#saveSms", function () {

    let checkFormData = new FormData($("#smsForm")[0]);

    let $submitButton = $(this);
    let originalText = $submitButton.html();
    $submitButton.text('Wait...');
    $submitButton.prop('disabled', true);
    let $form = $("#smsForm"); // Use the form's direct ID
    $form.find(".is-invalid").removeClass("is-invalid");
    $form.find(".text-danger").text("").hide();
    $.ajax({
        type: 'POST',
        url: $("#smsForm").attr('action'),
        data: checkFormData,
        contentType: false,
        processData: false,
        success: function (response) {
            if (response.isStatus) {
                successMsg(response.message);
                let form = document.getElementById('smsForm');
                form.reset()
                $submitButton.html(originalText);
                $submitButton.prop('disabled', false);
                $("#smsModel").modal('hide');
                $(".smsList").html("");
                $(".smsList").html(response.html);
            } else {
                $.each(response.message, function (field, messages) {
                    $form.find('[name="' + field + '"]').addClass('is-invalid');
                    $form.find('#' + field + 'Error').text(messages[0]).show();
                });
                $submitButton.html(originalText);
                $submitButton.prop('disabled', false);
            }
        },
        error: function (xhr, status, error) {
            var errors = xhr.responseJSON.errors;

            if (errors) {
                $.each(errors, function (field, messages) {
                    $form.find('[name="' + field + '"]').addClass('is-invalid');
                    $form.find('#' + field + 'Error').text(messages[0]).show();
                });
            } else {
                console.error('Error submitting form:', error);
            }
            $submitButton.html(originalText);
            $submitButton.prop('disabled', false);
        }
    });
});
$(document).on("click", "#saveCredential", function () {

    let checkFormData = new FormData($("#credentialForm")[0]);

    let $submitButton = $(this);
    let originalText = $submitButton.html();
    $submitButton.text('Wait...');
    $submitButton.prop('disabled', true);

    $.ajax({
        type: 'POST',
        url: $("#credentialForm").attr('action'),
        data: checkFormData,
        contentType: false,
        processData: false,
        success: function (response) {
            if (response.isStatus) {
                successMsg(response.message);
                let form = document.getElementById('credentialForm');
                form.reset()
                $submitButton.html(originalText);
                $submitButton.prop('disabled', false);
                $("#credentialModel").modal('hide');
                $(".credentials").html("");
                $(".credentials").html(response.html);
            } else {
                $.each(response.message, function (field, messages) {
                    $('#' + field + 'Error').text(messages[0]).show();
                    $('[name="' + field + '"]').addClass('is-invalid');
                });
                $submitButton.html(originalText);
                $submitButton.prop('disabled', false);
            }
        },
        error: function (xhr, status, error) {
            var errors = xhr.responseJSON.errors;

            if (errors) {
                $.each(errors, function (field, messages) {
                    $('#' + field + 'Error').text(messages[0]).show();
                    $('[name="' + field + '"]').addClass('is-invalid');
                });
            } else {
                console.error('Error submitting form:', error);
            }
            $submitButton.html(originalText);
            $submitButton.prop('disabled', false);
        }
    });
});
$(document).on('click', '.addCredential', function (e) {

    let $form = $("#credentialForm"); // Use the form's direct ID
    $('#credentialForm')[0].reset();
    $form.find('.error').text('');
    $form.find('.is-invalid').removeClass('is-invalid');
    $("#credentialModel").modal('show');
});
$(document).on('click', '.addSms', function (e) {
    let $form = $("#smsForm"); // Use the form's direct ID

    $('#smsForm')[0].reset();
    $form.find('.error').text('');
    $form.find('.is-invalid').removeClass('is-invalid');
    $("#smsModel").modal('show');
});
$('.switch-input').change(function () {
    let isChecked = $(this).is(':checked');
    let corrospondanceId = $(this).attr('data-corrospondanceId');
    let $checkbox = $(this);
    if (isChecked == 1) {
        $.ajax({
            url: unlockurl,
            method: "POST",
            data: {
                "_token": unlockToken,
                "id": corrospondanceId,
                "isRead": isChecked ? 1 : 0
            },
            success: function (response) {
                swal("Success", response.message, "success");
            },
            error: function (xhr, status, error) {
                swal("Error", "An error occurred: " + error, "error");
                // $checkbox.prop('checked',
                //     initialState); // Revert checkbox state
            }
        });
    }
});
