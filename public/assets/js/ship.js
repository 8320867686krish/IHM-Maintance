$('#projectForm').submit(function(e) {
    e.preventDefault();

    $('.error').empty().hide();
    $('input').removeClass('is-invalid');
    $('select').removeClass('is-invalid');

    let formData = new FormData(this);

    $.ajax({
        url: shipSave,
        type: 'POST',
        data: formData,
        dataType: 'json',
        contentType: false,
        processData: false,
        success: function(response) {
            if (response.isStatus) {
                successMsg(response.message);
            } else {
                errorMsg(response.message);
            }
        },
        error: function(xhr, status, error) {
            let errors = xhr.responseJSON.errors;

            if (errors) {
                $.each(errors, function(field, messages) {
                    $('#' + field + 'Error').text(messages[0]).show();
                    $('[name="' + field + '"]').addClass('is-invalid');
                });
            } else {
                console.error('Error submitting form:', error);
            }
        },
    });
});