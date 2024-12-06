
$(document).on("click", ".addSummary", function () {
    $("#SummaryModel").modal('show');
});

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
    form.find('#documentshow').html(`<a href=${summary.document} target="_blank">${doc}</a>`)
    $("#SummaryModel").modal('show');
  
});

$(document).on("click", ".SummaryModelClose", function () {
    let form = document.getElementById('addsummaryForm');
    $("#documentshow").html('');
    form.reset()
});


$(document).on("click", "#summarySave", function () {
    
    let checkFormData = new FormData($("#addsummaryForm")[0]);
    checkFormData.ship_id  = 7;
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
            $(this).closest('.new-part-mnual').remove();
       
        }
    });
});