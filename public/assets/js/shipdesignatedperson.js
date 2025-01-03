$("#designatedSave").click(function(){
     
    let checkFormData = new FormData($("#designatedForm")[0]);
    let $submitButton = $(this);
    let originalText = $submitButton.html();
    $submitButton.text('Wait...');
    $submitButton.prop('disabled', true);

    $.ajax({
        type: 'POST',
        url: $("#designatedForm").attr('action'),
        data: checkFormData,
        contentType: false,
        processData: false,
        success: function (response) {
            if (response.isStatus) {
                
                successMsg(response.message);
                let form = document.getElementById('designatedForm');
                form.reset()
                $submitButton.html(originalText);
                $submitButton.prop('disabled', false);
                $("#DesignatedModel").modal('hide');
                
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

$(".editdesignatedPerson").click(function(){
    var data = $(this).data('designated');
    var currentUserRoleLevel = $("#currentUserRoleLevel").val();
    if(currentUserRoleLevel == 5){
        $.ajax({
            type: 'GET',
            url: `${baseUrl}/designatedPersonShip/${data.id}`,
            contentType: false,
            processData: false,
            success: function (response) {
                $('#designatedForm #designatedpersionships').selectpicker('val', response.shipIds);
                $('#designatedForm #designatedpersionships').selectpicker('refresh');
            }
        });
    }
    let form = $(`#designatedForm`);    
    form.find("#name").val(data.name);
    form.find("#id").val(data.id);
    form.find("#passport_number").val(data.passport_number);
    form.find("#rank").val(data.rank);
    form.find("#sign_off_date").val(data.sign_off_date);
    form.find("#sign_on_date").val(data.sign_on_date);
    form.find("#ship_id").val(data.ship_id);
    form.find("#position").val(data.position);
    $("#DesignatedModel").modal('show');
});
