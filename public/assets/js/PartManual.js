
$(document).on("click", ".addPart", function () {
    $("#partmanuelModel").modal('show');
});

    $(document).on("click", ".editPopup", function (e) {

    e.preventDefault();
    let part = $(this).data('part');
    let doc = $(this).data('doc');
    let form = $(`#addPartManualForm`);
    form.find("#title").val(part.title);
    form.find('#uploaded_by').val(part.uploaded_by);
    form.find('#date').val(part.date);
    form.find('#id').val(part.id);
    form.find('#version').val(part.version);

    form.find('#documentshow').html(`<a href=${part.document} target="_blank">${doc}</a>`)
    $("#partmanuelModel").modal('show');
  
});

$(document).on("click", ".partmanuelModelClose", function () {
    let form = document.getElementById('addPartManualForm');
    $("#documentshow").html('');
    form.reset()
});


$(document).on("click", "#partManualSave", function () {
    
    let checkFormData = new FormData($("#addPartManualForm")[0]);
    checkFormData.ship_id  = 7;
    let $submitButton = $(this);
    let originalText = $submitButton.html();
    $submitButton.text('Wait...');
    $submitButton.prop('disabled', true);

    $.ajax({
        type: 'POST',
        url: $("#addPartManualForm").attr('action'),
        data: checkFormData,
        contentType: false,
        processData: false,
        success: function (response) {
            if (response.isStatus) {
                
                successMsg(response.message);
                let form = document.getElementById('addPartManualForm');
                $("#documentshow").html();
                form.reset()
                $submitButton.html(originalText);
                $submitButton.prop('disabled', false);
                $("#partmanuelModel").modal('hide');
                
                $(".partmanullist").html(response.html);
                
                
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


$(document).on("click", ".deletepartMenualbtn", function (e) {
    e.preventDefault();
    let recordId = $(this).data('id');

    let deleteUrl = $(this).attr("href");
   
    let $liToDelete = $(this).closest('li');
    let confirmMsg = "Are you sure you want to delete this document?";

    confirmDeleteWithElseIf(deleteUrl, confirmMsg, 'delete', function (response) {
        // Success callback
        if (response.isStatus) {
            $(this).closest('.new-part-mnual').remove();
       
        }
    });
});