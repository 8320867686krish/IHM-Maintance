
$(document).on("click", ".addSummary", function () {
    $("#SummaryModel").modal('show');
});

$(document).on("click", ".startAmended", function () {
    $('#amededmodel').val(1);
    $("#unlockModal").modal('show')

});
$(document).on("click", ".downloadReport", function (e) {
    e.preventDefault();
    const $submitButton = $(this);
    const originalText = $submitButton.text();

    // Disable the button and show "Please wait..."
    $submitButton.text("wait...").prop("disabled", true);

    const href = $submitButton.attr("href");
    $.ajax({
        url: href,
        type: 'GET',
        xhrFields: {
            responseType: 'blob' // Needed for binary files (PDF/Excel)
        },
        success: function (response, status, xhr) {
            const disposition = xhr.getResponseHeader('Content-Disposition');
            let filename = null;

            if (disposition && disposition.indexOf('attachment') !== -1) {
                const matches = /filename[^;=\n]*=((['"]).*?\2|[^;\n]*)/.exec(disposition);
                if (matches != null && matches[1]) {
                    filename = matches[1].replace(/['"]/g, '');
                }
            }

            // If filename not found, do not proceed
            if (!filename) {
                alert("File could not be downloaded. Filename not found in response.");
                $submitButton.text(originalText).prop('disabled', false);
                return;
            }

            const contentType = xhr.getResponseHeader("Content-Type");
            const blob = new Blob([response], { type: contentType });

            const link = document.createElement('a');
            link.href = window.URL.createObjectURL(blob);
            link.download = filename;
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
            URL.revokeObjectURL(link.href);

            $submitButton.text(originalText).prop('disabled', false);

            const isOpen = $("#amededmodel").val();
            if (isOpen == 1) {
                $("#unlockModal").modal('hide');
                $("#amendedModal").modal('show');
            } else {
                $("#unlockModal").modal('hide');
            }
        },

        error: function (xhr, status, error) {
            console.error('Download failed:', error);
            $('#spinShow').hide();
            $submitButton.text(originalText).prop('disabled', false);
            $(".bg-overlay").hide();
        }
    });

});

$('.switch-input').change(function () {
    let isChecked = $(this).is(':checked');
    let shipId = $(this).attr('data-shipId');
    let initialState = !isChecked; // Capture the initial state
    let $checkbox = $(this);
    let message = isChecked ? "Are you sure you want to lock vscp?" :
        "Are you sure you want to unlock vscp?";
    if (isChecked == 1) {
        $("#initialIhm").addClass('initialIhmDisable');
    } else {
        $("#initialIhm").removeClass('initialIhmDisable');
        $('#amededmodel').val(0);

        $("#unlockModal").modal('show')
    }
    if (isChecked == 1) {
        confirmChangeStatus(message, function () {
            $.ajax({
                url: unlockurl,
                method: "POST",
                data: {
                    "_token": unlockToken,
                    "ship_id": shipId,
                    "is_unlock": isChecked ? 1 : 0
                },
                success: function (response) {
                    swal("Success", response.message, "success");
                },
                error: function (xhr, status, error) {
                    swal("Error", "An error occurred: " + error, "error");
                    $checkbox.prop('checked',
                        initialState); // Revert checkbox state
                }
            });
        }, function () {
            $checkbox.prop('checked', initialState); // Revert checkbox state if cancelled
        });
    } else {
        $.ajax({
            url: unlockurl,
            method: "POST",
            data: {
                "_token": unlockToken,
                "ship_id": shipId,
                "is_unlock": isChecked ? 1 : 0
            },
        });
    }

});
function confirmChangeStatus(message, confirmCallback, cancelCallback) {
    swal({
        title: "Are you sure?",
        text: message,
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#7066e0",
        confirmButtonText: "Yes, do it!",
        cancelButtonText: "No, cancel!",
        closeOnConfirm: false,
        closeOnCancel: false,
    }, function (isConfirm) {
        if (isConfirm) {
            confirmCallback();
        } else {
            cancelCallback();
            swal("Cancelled", "Your action has been cancelled.", "error");
        }
    });
}
$(document).on("click", ".editSummary", function (e) {

    e.preventDefault();
    let summary = $(this).data('summary');
    console.log(summary);
    let doc = $(this).data('doc');
    let form = $(`#addsummaryForm`);
    form.find("#title").val(summary.title);
    form.find('#uploaded_by').val(summary.uploaded_by);
    form.find('#date').val(summary.date);
    form.find('#id').val(summary.id);
    form.find('#version').val(summary.version);

    form.find('#documentshow').html(`<a href=${summary.document} target="_blank">${doc}</a>`)
    $("#SummaryModel").modal('show');

});

$(document).on("click", ".SummaryModelClose", function () {
    let form = document.getElementById('addsummaryForm');
    $("#documentshow").html('');
    form.reset()
});
$(document).on("click", "#saveAmended", function () {

    let checkFormData = new FormData($("#amendedForm")[0]);

    let $submitButton = $(this);
    let originalText = $submitButton.html();
    $submitButton.text('Wait...');
    $submitButton.prop('disabled', true);

    $.ajax({
        type: 'POST',
        url: $("#amendedForm").attr('action'),
        data: checkFormData,
        contentType: false,
        processData: false,
        success: function (response) {
            if (response.isStatus) {

                successMsg(response.message);
                let form = document.getElementById('amendedForm');
                form.reset()
                $submitButton.html(originalText);
                $submitButton.prop('disabled', false);
                $("#amendedModal").modal('hide');
                window.location.href = response.redirectUrl;

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

$(document).on("click", "#summarySave", function () {

    let checkFormData = new FormData($("#addsummaryForm")[0]);
    checkFormData.ship_id = 7;
    let $submitButton = $(this);
    let originalText = $submitButton.html();
    $submitButton.text('Wait...');
    $submitButton.prop('disabled', true);

    $.ajax({
        type: 'POST',
        url: $("#addsummaryForm").attr('action'),
        data: checkFormData,
        contentType: false,
        processData: false,
        success: function (response) {
            if (response.isStatus) {

                successMsg(response.message);
                let form = document.getElementById('addsummaryForm');
                $("#documentshow").html();
                form.reset()
                $submitButton.html(originalText);
                $submitButton.prop('disabled', false);
                $("#SummaryModel").modal('hide');
                $(".summaryList").html(response.html);


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


$(document).on("click", ".summarybtn", function (e) {
    e.preventDefault();
    let recordId = $(this).data('id');

    let deleteUrl = $(this).attr("href");

    let $liToDelete = $(this).closest('li');
    let confirmMsg = "Are you sure you want to delete this document?";

    confirmDeleteWithElseIf(deleteUrl, confirmMsg, 'delete', function (response) {
        // Success callback
        if (response.isStatus) {
            $("#summeryList").DataTable().destroy();

            // Update table content
            $("#summeryList tbody").html(response.html);

            // summeryList DataTable
            $("#summeryList").DataTable({
                lengthChange: false, // Add your options here
                responsive: true,
                order: [[0, "desc"]],
            });


        }
    });
});