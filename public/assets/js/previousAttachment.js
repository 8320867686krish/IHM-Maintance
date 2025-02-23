
$(".addPreviousBtn").click(function(){
    let $form = $("#PreviousAttachmentModelForm"); // Use the form's direct ID
    $('#PreviousAttachmentModelForm')[0].reset();
    $form.find('.error').text('');
    $form.find('.is-invalid').removeClass('is-invalid');
    $("#PreviousAttachmentModel").modal('show');

});
$(document).on('click', '.previousAttachmentEdit', function () {

    var data = $(this).data('attachment'); 

    console.log(data);
    $("#PreviousAttachmentModelForm").find('#id').val(data.id);
    $("#PreviousAttachmentModelForm").find('#attachment_name').val(data.attachment_name);
    $("#PreviousAttachmentModelForm").find('#date_from').val(data.date_from);
    $("#PreviousAttachmentModelForm").find('#date_till').val(data.date_till);
    $("#PreviousAttachmentModelForm").find('#maintained_by').val(data.maintained_by);

    $("#PreviousAttachmentModel").modal('show');

})
$(document).on('click', '.major-delete', function (e) {
    e.preventDefault();
    let deleteUrl = $(this).attr('href');
    let $deleteButton = $(this);
    let confirmMsg = "Are you sure you want to delete this major document?";

    confirmDelete(deleteUrl, confirmMsg, function(response) {
        $("#majorList").html("");
        if (response.html && response.html.trim() !== '') {
            $("#majorlttable").DataTable().destroy();

                // Update table content
                $("#majorlttable tbody").html(response.html);

                // Reinitialize DataTable
                $("#majorlttable").DataTable({
                    lengthChange: false, // Add your options here
                    responsive: true,
                    order: [[0, "asc"]],
                });

        }
              
    }, function(response) {
        console.log("Failed to delete: " + response.message);
    });
});
$("#savePreviousAttachmentModel").click(function(){

    let checkFormData = new FormData($("#PreviousAttachmentModelForm")[0]);

    let $submitButton = $(this);
    let originalText = $submitButton.html();
    $submitButton.text('Wait...');
    $submitButton.prop('disabled', true);
    let $form = $("#PreviousAttachmentModelForm"); // Use the form's direct ID
    $form.find(".is-invalid").removeClass("is-invalid");
    $form.find(".text-danger").text("").hide();
    $.ajax({
        type: 'POST',
        url: $("#PreviousAttachmentModelForm").attr('action'),
        data: checkFormData,
        contentType: false,
        processData: false,
        success: function (response) {
            if (response.isStatus) {
                successMsg(response.message);
                let form = document.getElementById('PreviousAttachmentModelForm');
                form.reset()
                $submitButton.html(originalText);
                $submitButton.prop('disabled', false);
                $("#PreviousAttachmentModel").modal('hide');
              
                $("#PreviousAttachmentList").DataTable().destroy();

                // Update table content
                $("#PreviousAttachmentList tbody").html(response.html);

                // Reinitialize DataTable
                $("#PreviousAttachmentList").DataTable({
                    lengthChange: false, // Add your options here
                    responsive: true,
                    order: [[0, "desc"]],
                });

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
                $.each(errors, function(field, messages) {
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
