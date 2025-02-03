$("#designatedSave").click(function(){
     
    let checkFormData = new FormData($("#designatedForm")[0]);
    let $submitButton = $(this);
    let originalText = $submitButton.html();
    $submitButton.text('Wait...');
    $submitButton.prop('disabled', true);
var $form = $("#designatedForm");
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
})
$("#shoredpSave").click(function(){
    let checkFormData = new FormData($("#adminshoredpForm")[0]);
    let $submitButton = $(this);
    let originalText = $submitButton.html();
    $submitButton.text('Wait...');
    $submitButton.prop('disabled', true);
    var $form = $("#adminshoredpForm");
    $.ajax({
        type: 'POST',
        url: $("#adminshoredpForm").attr('action'),
        data: checkFormData,
        contentType: false,
        processData: false,
        success: function (response) {
            if (response.isStatus) {
                
                successMsg(response.message);
                let form = document.getElementById('adminshoredpForm');
                form.reset()
                $submitButton.html(originalText);
                $submitButton.prop('disabled', false);
                $("#AdminShoreDpModel").modal('hide');
                $(".shoredplist").html("");
                $(".shoredplist").html(response.html);
              //  window.location.reload();
                
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
$("#addDesignated").click(function(){
    $("#designatedForm")[0].reset();
});
$("#admindesignatedSave").click(function(){
     
    let checkFormData = new FormData($("#admindesignatedForm")[0]);
    let $submitButton = $(this);
    let originalText = $submitButton.html();
    $submitButton.text('Wait...');
    $submitButton.prop('disabled', true);
var $form = $("#admindesignatedForm");
    $.ajax({
        type: 'POST',
        url: $("#admindesignatedForm").attr('action'),
        data: checkFormData,
        contentType: false,
        processData: false,
        success: function (response) {
            if (response.isStatus) {
                
                successMsg(response.message);
                let form = document.getElementById('admindesignatedForm');
                form.reset()
                $submitButton.html(originalText);
                $submitButton.prop('disabled', false);
                $("#adminDesignatedModel").modal('hide');
                $(".admindprecoreds").html("");
                $(".admindprecoreds").html(response.html);
              //  window.location.reload();
                
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
})
$(document).on("click", ".admineditdesignatedPerson", function () {
    var data = $(this).data('designated');
    let form = $(`#admindesignatedForm`);    
    form.find("#name").val(data.name);
    form.find("#id").val(data.id);
    form.find("#passport_number").val(data.passport_number);
    form.find("#rank").val(data.rank);
    form.find("#sign_off_date").val(data.sign_off_date);
    form.find("#sign_on_date").val(data.sign_on_date);
    form.find("#ship_id").val(data.ship_id);
    form.find("#position").val(data.position);
    $("#adminDesignatedModel").modal('show');
});

$(document).on("click", ".adminShoreDp", function () {
    var dataresponse = $(this).data('designated');
    let form = $(`#adminshoredpForm`);   
    let data = (dataresponse.designated_person_detail); 

    console.log(data);
        $.ajax({
            type: 'GET',
            url: `${baseUrl}/designatedPersonShip/${data.id}`,
            contentType: false,
            processData: false,
            success: function (response) {
                $('#adminshoredpForm #designatedpersionships').selectpicker('val', response.shipIds);
                $('#adminshoredpForm #designatedpersionships').selectpicker('refresh');
            }
        });
    
   
    form.find("#name").val(data.name);
    form.find("#id").val(data.id);
    form.find("#passport_number").val(data.passport_number);
    form.find("#rank").val(data.rank);
    form.find("#sign_off_date").val(data.sign_off_date);
    form.find("#sign_on_date").val(data.sign_on_date);
    form.find("#ship_id").val(data.ship_id);
    form.find("#position").val(data.position);
    $("#AdminShoreDpModel").modal('show');
});

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
