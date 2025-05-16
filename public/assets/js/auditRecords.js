$("#addAuditRecordsBtn").click(function(){
    $("#AuditModel").modal('show');

    // $('#emptyMsg').hide();

    // auditIndex++;
    // var newItemRow = `
    // <div class="row new-audit-row">
    //     <div class="form-group col-3 mb-1">
    //         <input type="text" class="form-control form-control-lg" name="items[` + auditIndex + `][audit_name]"  value="${auditiname}" autocomplete="off" placeholder="">
    //         <div class="invalid-feedback error"></div>
    //     </div>
    //     <div class="form-group col-3 mb-1">
    //         <input type="text" class="form-control form-control-lg" name="items[` + auditIndex + `][auditee_name]" value="${auditieename}" autocomplete="off" placeholder="">
    //         <div class="invalid-feedback error"></div>
    //     </div>
    //     <div class="form-group col-3 mb-1">
    //         <input type="date" class="form-control form-control-lg" name="items[` + auditIndex + `][date]" autocomplete="off" placeholder="Part No">
    //         <div class="invalid-feedback error"></div>
    //     </div>

    //     <div class="form-group col-2 mb-1">
    //         <input type="file" class="form-control form-control-lg" name="items[` + auditIndex + `][attachment]" autocomplete="off" placeholder="Qty">
    //         <div class="invalid-feedback error"></div>
    //     </div>
    // <div class="form-group col-1 mb-1">
    //         <i class="fas fa-trash-alt text-danger mt-3 remove-item-btn" style="font-size: 1rem"></i>
    //     </div>
    // </div>
    // `;

    // $('#AuditItemsContainer').append(newItemRow);
});
$(document).on('click', '.remove-item-btn', function (e) {
    e.preventDefault();
    let deleteUrl = $(this).attr('href');
    let $deleteButton = $(this);
    let confirmMsg = "Are you sure you want to delete this audit records?";
    confirmDelete(deleteUrl, confirmMsg, function(response) {
        
        if (response.isStatus == true) {
            window.location.reload();

               
        }
              
    }, function(response) {
        console.log("Failed to delete: " + response.message);
    });
});
 $(".view-item-btn").click(function () {
    let itemData = $(this).attr('data-iteam');
    let item = JSON.parse(itemData);

    $('#auditrecordsForm [name]').each(function () {
        let fieldName = $(this).attr('name');
        let fieldType = $(this).attr('type');

        // Skip file inputs
        if (fieldType === 'file') return;

        if (item.hasOwnProperty(fieldName)) {
            $(this).val(item[fieldName]);
        }
    });
        $(".attachmentDiv").hide();
        $(".auditSave").hide();
        $("#AuditModel").modal('show');

});

$('#auditSave').click(function (e) {
   
    let checkFormData = new FormData($("#auditrecordsForm")[0]);
    let $submitButton = $(this);
    let originalText = $submitButton.html();
    $submitButton.text('Wait...');
    $submitButton.prop('disabled', true);
var $form = $("#auditrecordsForm");
    $.ajax({
        type: 'POST',
        url: $("#auditrecordsForm").attr('action'),
        data: checkFormData,
        contentType: false,
        processData: false,
        success: function (response) {
            if (response.isStatus) {
                
                successMsg(response.message);
                let form = document.getElementById('auditrecordsForm');
                form.reset()
                $submitButton.html(originalText);
                $submitButton.prop('disabled', false);
                $("#AuditModel").modal('hide');
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