$("#addAuditRecordsBtn").click(function(){
    $('#emptyMsg').hide();

    auditIndex++;
    var newItemRow = `
    <div class="row new-audit-row">
        <div class="form-group col-3 mb-1">
            <input type="text" class="form-control form-control-lg" name="items[` + auditIndex + `][audit_name]"  value="${auditiname}" autocomplete="off" placeholder="">
            <div class="invalid-feedback error"></div>
        </div>
        <div class="form-group col-3 mb-1">
            <input type="text" class="form-control form-control-lg" name="items[` + auditIndex + `][auditee_name]" value="${auditieename}" autocomplete="off" placeholder="">
            <div class="invalid-feedback error"></div>
        </div>
        <div class="form-group col-3 mb-1">
            <input type="date" class="form-control form-control-lg" name="items[` + auditIndex + `][date]" autocomplete="off" placeholder="Part No">
            <div class="invalid-feedback error"></div>
        </div>

        <div class="form-group col-2 mb-1">
            <input type="file" class="form-control form-control-lg" name="items[` + auditIndex + `][attachment]" autocomplete="off" placeholder="Qty">
            <div class="invalid-feedback error"></div>
        </div>
    <div class="form-group col-1 mb-1">
            <i class="fas fa-trash-alt text-danger mt-3 remove-item-btn" style="font-size: 1rem"></i>
        </div>
    </div>
    `;

    $('#AuditItemsContainer').append(newItemRow);
});
$(document).on('click', '.remove-item-btn', function () {
    var itemId = $(this).closest('.new-audit-row').data('id');
    if (itemId) {
        var deletedIds = $('#deleted_id').val();
        $('#deleted_id').val(deletedIds ? deletedIds + ',' + itemId : itemId);
    }
    $(this).closest('.new-audit-row').remove();
    if ($('.new-audit-row').length === 1) {
        $('#emptyMsg').show(); 
    }
});
$('#AuditForm').submit(function (e) {
    alert("ddd");
    e.preventDefault();
    e.preventDefault();

    var $submitButton = $(this).find('button[type="submit"]');
    var originalText = $submitButton.html();
    $submitButton.text('Wait...');
    $submitButton.prop('disabled', true);

    // Clear previous error messages and invalid classes
    $('.error').empty().hide();
    $('input').removeClass('is-invalid');

    var formData = new FormData(this);


    $.ajax({
        url: $(this).attr('action'),
        method: 'POST',
        data: formData,
        data: formData,
        dataType: 'json',
        contentType: false,
        processData: false,
        success: function (response) {
            if (response.message) {
                successMsgWithRedirect(response.message);
                location.reload();
            }
        },
        error: function (xhr, status, error) {
            if (xhr.status === 419) { // CSRF Token Mismatch
                location.reload();
            }
            let errors = xhr.responseJSON.errors;
            if (errors) {
                $.each(errors, function (field, messages) {
                    $('#' + field + 'Error').text(messages[0]).show();
                    $('[name="' + field + '"]').addClass('is-invalid');
                });
                var $errorDiv = $(".error:visible:first");
                if ($errorDiv.length) {
                    $('html, body').animate({
                        scrollTop: $errorDiv.offset().top - 200
                    }, 500);
                }
            } else {
                console.error('Error submitting form:', error);
            }
        },
        complete: function () {
            // $submitButton.html('<i class="fas fa-plus"></i>  Add');
            $submitButton.html(originalText); // Restore original text
            $submitButton.prop('disabled', false);
        }
    });
});