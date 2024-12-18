
$("#addQuestion").click(function () {
    iteamQuestion++;
    if (iteamQuestion > 10) {
        errorMsg("You can't add more than 10 items.");

        return false;
    }
    let newItemRow = `
    <div class="row new-question-row mb-3">
        <!-- Remove Button -->
        <div class="form-group col-12 text-right">
            <i class="fas fa-trash-alt text-danger mt-3 remove-item-btn" style="font-size: 1.5rem; cursor: pointer;"></i>
        </div>

        <!-- Question Row -->
        <div class="form-group col-12">
            <div class="row align-items-center">
                <label class="col-md-2">Q - ${iteamQuestion}</label>
                <div class="col-md-10">
                    <input type="text" class="form-control form-control-lg" 
                        name="questions[` + iteamQuestion + `][question_name]" 
                        autocomplete="off" placeholder="Enter Question">
                    <div class="invalid-feedback error"></div>
                </div>
            </div>
        </div>

        <!-- Answer Type Selection -->
        <div class="form-group col-12">
            <div class="row align-items-center">
                <label class="col-md-2">Answer Type</label>
                <div class="col-md-10">
                    <select class="form-control form-control-lg answer-type-select" 
                        name="questions[` + iteamQuestion + `][answer_type]" 
                        data-item-id="` + iteamQuestion + `">
                         <option value="">Select Type</option>
                        <option value="text">Text</option>
                        <option value="file">File</option>
                    </select>
                    <div class="invalid-feedback error"></div>
                </div>
            </div>
        </div>

      

      
          <div class="form-group col-12" id="correctAnswerContainer` + iteamQuestion + `">
                    <div class="row align-items-center">
                        <label class="col-md-2">Correct Answer</label>
                        <div class="col-md-10">
                            <input type="text" class="form-control form-control-lg" 
                                name="questions[` + iteamQuestion + `][correct_answer]" 
                                autocomplete="off" placeholder="Correct Answer">
                        </div>
                    </div>
                </div>
    </div>
    `;

    $('.questionContainer').append(newItemRow);
});
let selectedValues = [];
$("#selectAll").change(function () {
    const isChecked = $(this).prop('checked');
    $(".assignChk").prop('checked', isChecked);
    if (isChecked) {
        selectedValues = $(".assignChk").map(function () {
            return $(this).val();
        }).get();
    } else {
        selectedValues = [];
    }
    $('#training_sets_id').val(selectedValues.join(', '));
});

$(".assignChk").change(function () {
    const value = $(this).val();
    if ($(this).is(":checked")) {
        if (!selectedValues.includes(value)) {
            selectedValues.push(value);
        }
    } else {
        selectedValues = selectedValues.filter(item => item !== value);
    }
    $('#training_sets_id').val(selectedValues.join(', '));
    if ($(".assignChk:checked").length === $(".assignChk").length) {
        $("#selectAll").prop('checked', true);
    } else {
        $("#selectAll").prop('checked', false);
    }
});


$(".assignSets").click(function () {
    if (!selectedValues.length) {
        errorMsg("Please select at least one checkbox.");
    } else {
        $("#assignModel").modal('show');

    }
    return false;
})

$('#assignTrainingForm').submit(function (e) {
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
                successMsg(response.message);
                $("#hazmat_companies_id").val("");
                $(".assignChk").prop('checked', false);
                $("#selectAll").prop('checked', false);

                $("#assignModel").modal('hide');
            }
        },
        error: function (xhr, status, error) {
            // If there are errors, display them
            let errors = xhr.responseJSON.errors;
            if (errors) {
                $.each(errors, function (field, messages) {
                    $('#' + field + 'Error').text(messages[0]).show();
                    $('[name="' + field + '"]').addClass('is-invalid');
                });
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
// Handle Change in Answer Type
$(document).on('change', '.answer-type-select', function () {
    const itemId = $(this).data('item-id');
    const selectedType = $(this).val();
    const cloneTableTypeDiv = $(this).closest(".new-question-row");
    cloneTableTypeDiv.find("[id^='options-']").remove();

    var textOptions = `<div class="options-container col-12 mb-3" id="options-` + iteamQuestion + `">
            <div class="row">
                <div class="form-group col-12">
                    <div class="row align-items-center">
                        <label class="col-md-2">Option A</label>
                        <div class="col-md-10">
                            <input type="${selectedType}" class="form-control form-control-lg" 
                                name="questions[` + itemId + `][option_a]" 
                                autocomplete="off" placeholder="Option A">
                        </div>
                    </div>
                </div>
                <div class="form-group col-12">
                    <div class="row align-items-center">
                        <label class="col-md-2">Option B</label>
                        <div class="col-md-10">
                            <input type="${selectedType}" class="form-control form-control-lg" 
                                name="questions[` + itemId + `][option_b]" 
                                autocomplete="off" placeholder="Option B">
                        </div>
                    </div>
                </div>
                <div class="form-group col-12">
                    <div class="row align-items-center">
                        <label class="col-md-2">Option C</label>
                        <div class="col-md-10">
                            <input type="${selectedType}" class="form-control form-control-lg" 
                                name="questions[` + itemId + `][option_c]" 
                                autocomplete="off" placeholder="Option C">
                        </div>
                    </div>
                </div>
                <div class="form-group col-12">
                    <div class="row align-items-center">
                        <label class="col-md-2">Option D</label>
                        <div class="col-md-10">
                            <input type="${selectedType}" class="form-control form-control-lg" 
                                name="questions[` + itemId + `][option_d]" 
                                autocomplete="off" placeholder="Option D">
                        </div>
                    </div>
                </div>
              
            </div>
        </div>`



    $(textOptions).insertBefore(`#correctAnswerContainer${itemId}`).fadeIn('slow');

});

// Remove Question Row
var deletedIds = []; // Array to store deleted IDs

$(document).on('click', '.remove-item-btn', function () {
    itemId = $(this).data('removequestion');
    console.log(itemId);
    if (!deletedIds.includes(itemId)) {
        deletedIds.push(itemId);
    }
    $('#deleted_questions_id').val(deletedIds.join(', '));

    $(this).closest('.new-question-row').remove();
});
$('#trainingForm').submit(function (e) {
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
                successMsg(response.message);
                window.location.reload();
            }
        },
        error: function (xhr, status, error) {
            // If there are errors, display them
            let errors = xhr.responseJSON.errors;
            if (errors) {
                $.each(errors, function (field, messages) {
                    $('#' + field + 'Error').text(messages[0]).show();
                    $('[name="' + field + '"]').addClass('is-invalid');
                });
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