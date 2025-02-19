
$(".addMajorBtn").click(function(){
    let $form = $("#majorRepairForm"); // Use the form's direct ID
    $('#majorRepairForm')[0].reset();
    $form.find('.error').text('');
    $form.find('.is-invalid').removeClass('is-invalid');
    $("#majorRepairModel").modal('show');

});
$(document).on('click', '.majorrepairEdit', function () {

    var data = $(this).data('major'); 

    console.log(data);
    $("#majorRepairForm").find('#id').val(data.id);
    $("#majorRepairForm").find('#name').val(data.name);
    $("#majorRepairForm").find('#date').val(data.date);
    $("#majorRepairForm").find('#location_name').val(data.location_name);
    $("#majorRepairForm").find('#document_uploaded_by').val(data.document_uploaded_by);

    $("#majorRepairModel").modal('show');

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
$("#savemajorRepair").click(function(){

    let checkFormData = new FormData($("#majorRepairForm")[0]);

    let $submitButton = $(this);
    let originalText = $submitButton.html();
    $submitButton.text('Wait...');
    $submitButton.prop('disabled', true);
    let $form = $("#majorRepairForm"); // Use the form's direct ID
    $form.find(".is-invalid").removeClass("is-invalid");
    $form.find(".text-danger").text("").hide();
    $.ajax({
        type: 'POST',
        url: $("#majorRepairForm").attr('action'),
        data: checkFormData,
        contentType: false,
        processData: false,
        success: function (response) {
            if (response.isStatus) {
                successMsg(response.message);
                let form = document.getElementById('majorRepairForm');
                form.reset()
                $submitButton.html(originalText);
                $submitButton.prop('disabled', false);
                $("#majorRepairModel").modal('hide');
              
                $("#majorlttable").DataTable().destroy();

                // Update table content
                $("#majorlttable tbody").html(response.html);

                // Reinitialize DataTable
                $("#majorlttable").DataTable({
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
