
$("#addQuestion").click(function () {
    iteamQuestion++;
    if (iteamQuestion > 10) {
        errorMsg("You can't add more than 10 items.");

        return false;
    }
    const key = `new_${iteamQuestion}`;
    let newItemRow = `
<div class="row new-question-row mb-3" data-question-key="${key}">
    <!-- Remove Button -->
    <div class="form-group col-12 text-right">
        <i class="fas fa-trash-alt text-danger mt-3 remove-item-btn" style="font-size: 1.5rem; cursor: pointer;"   data-removequestion="${key}"></i>
    </div>

    <!-- Question Row -->
    <div class="form-group col-12">
        <div class="row align-items-center">
            <label class="col-md-2">Q - ${iteamQuestion}</label>
            <div class="col-md-5">
                <input type="text" class="form-control form-control-lg" 
                    name="questions[${key}][question_name]" 
                    autocomplete="off" placeholder="Enter Question">
                <div id="questions_${key}_question_nameError" class="invalid-feedback error"></div>
            </div>
        </div>
    </div>

    <!-- Answer Type Selection -->
    <div class="form-group col-12">
        <div class="row align-items-center">
            <label class="col-md-2">Answer Type</label>
            <div class="col-md-5">
                <select class="form-control form-control-lg answer-type-select" 
                    name="questions[${key}][answer_type]" 
                    data-item-id="${key}">
                    <option value="">Select Type</option>
                    <option value="text">Text</option>
                    <option value="file">File</option>
                </select>
                <div id="questions_${key}_answer_typeError" class="invalid-feedback error"></div>
            </div>
        </div>
    </div>

    <!-- Correct Answer -->
    <div class="form-group col-12" id="correctAnswerContainer_${key}">
        <div class="row align-items-center">
            <label class="col-md-2">Correct Answer</label>
            <div class="col-md-5">
                <select class="form-control form-control-lg" name="questions[${key}][correct_answer]">
                    <option value="">Choose Answer</option>
                    <option value="A">A</option>
                    <option value="B">B</option>
                    <option value="C">C</option>
                    <option value="D">D</option>
                </select>
                <div id="questions_${key}_correct_answerError" class="invalid-feedback error"></div>
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
$(document).on("click", "#startBrifing", function () {

    $("#startBrifingModel").modal('show');

});
$(document).on("click", "#startExam", function () {
    $("#satrtExamModel").modal('show');
});
$(document).on("click", "#finalstart", function () {
    $("#stratExamForm").submit();
});
$(document).on("click", "#dontread", function () {
    $("#satrtExamModel").modal('hide');
});


$(document).on("submit", "#trainingStart", function () {

    $("#trainingStart").submit();
})
$(document).on("click", "#startTraining", function () {

    $("#startTrainingModel").modal('show');

});

$(document).on("click", ".editBrif", function () {

    var data = $(this).data('brief');
    console.log(data.designated_people_id);
    $("#startBrifingForm").find('#id').val(data.id);
    $("#startBrifingForm").find('#number_of_attendance').val(data.number_of_attendance);
    $("#startBrifingForm").find('#brifing_date').val(data.brifing_date);
    $("#startBrifingForm").find('#designated_people_id').val(data.designated_people_id);
    $("#startBrifingModel").modal('show');

});
$(document).on("click", ".uploadBrief", function () {
    var briefid = $(this).data("briefid");

    // Find the corresponding file input for the current row
    $("#fileInput_" + briefid).click();
});

// Handle file input change
$(document).on("change", ".fileInput", function () {
    var briefid = $(this).data("briefid");
    var file = this.files[0];
    if (file) {
        console.log(baseUrl + '/briefing/upload');
        var formData = new FormData();
        formData.append("brief_id", briefid);  // Add brief ID to the data
        formData.append("brifing_document", file);  // Append the file to the FormData
        $.ajax({
            url: baseUrl + '/briefing/upload',  // Replace with your route for handling file upload
            type: 'POST',
            data: formData,
            contentType: false,  // This is important to send the file correctly
            processData: false,  // Do not process the data
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')  // Add the CSRF token here
            },
            success: function (response) {
                if (response.isStatus) {
                    successMsg(response.message);
                    $(".brifingHistory").html("");
                    $(".brifingHistory").html(response.html);
                    // You can update the UI or notify the user of success here
                }
            },

        });
    }
});

$(document).on("click", "#saveBrifing", function () {

    let checkFormData = new FormData($("#startBrifingForm")[0]);

    let $submitButton = $(this);
    let originalText = $submitButton.html();
    $submitButton.text('Wait...');
    $submitButton.prop('disabled', true);
    let $form = $("#startBrifingForm"); // Use the form's direct ID
    $form.find(".is-invalid").removeClass("is-invalid");
    $form.find(".text-danger").text("").hide();
    $.ajax({
        type: 'POST',
        url: $("#startBrifingForm").attr('action'),
        data: checkFormData,
        contentType: false,
        processData: false,
        success: function (response) {
            if (response.isStatus) {
                successMsg(response.message);
                let form = document.getElementById('startBrifingForm');
                form.reset()
                $submitButton.html(originalText);
                $submitButton.prop('disabled', false);
                $("#startBrifingModel").modal('hide');
                $(".brifingHistory").html("");
                $(".brifingHistory").html(response.html);
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
                $.each(errors, function (field, messages) {
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
            // console.log(errors);
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

    // Remove old option fields if they exist
    cloneTableTypeDiv.find("[id^='options-']").remove();

    // Append new options block
    const textOptions = `
<div class="options-container col-12 mb-3" id="options-${itemId}">
    <div class="row">
        <div class="form-group col-12">
            <div class="row align-items-center">
                <label class="col-md-2">Option A</label>
                <div class="col-md-5">
                    <input type="${selectedType}" class="form-control form-control-lg" 
                        name="questions[${itemId}][option_a]" 
                        autocomplete="off" placeholder="Option A">
                    <div id="questions_${itemId}_option_aError" class="invalid-feedback error"></div>
                </div>
            </div>
        </div>

        <div class="form-group col-12">
            <div class="row align-items-center">
                <label class="col-md-2">Option B</label>
                <div class="col-md-5">
                    <input type="${selectedType}" class="form-control form-control-lg" 
                        name="questions[${itemId}][option_b]" 
                        autocomplete="off" placeholder="Option B">
                    <div id="questions_${itemId}_option_bError" class="invalid-feedback error"></div>
                </div>
            </div>
        </div>

        <div class="form-group col-12">
            <div class="row align-items-center">
                <label class="col-md-2">Option C</label>
                <div class="col-md-5">
                    <input type="${selectedType}" class="form-control form-control-lg" 
                        name="questions[${itemId}][option_c]" 
                        autocomplete="off" placeholder="Option C">
                    <div id="questions_${itemId}_option_cError" class="invalid-feedback error"></div>
                </div>
            </div>
        </div>

        <div class="form-group col-12">
            <div class="row align-items-center">
                <label class="col-md-2">Option D</label>
                <div class="col-md-5">
                    <input type="${selectedType}" class="form-control form-control-lg" 
                        name="questions[${itemId}][option_d]" 
                        autocomplete="off" placeholder="Option D">
                    <div id="questions_${itemId}_option_dError" class="invalid-feedback error"></div>
                </div>
            </div>
        </div>
    </div>
</div>
`;

    // Append new options block right after the answer type field
    $(this).closest('.form-group').after(textOptions);

    // $(textOptions).insertBefore(`#correctAnswerContainer${itemId}`).fadeIn('slow');

});

// Remove Question Row
var deletedIds = []; // Array to store deleted IDs

$(document).on('click', '.remove-item-btn', function () {
    const itemId = $(this).data('removequestion'); // Ensure this is set when adding the row
    const row = $(this).closest('.new-question-row');

    // Track deleted question IDs if they exist
    if (itemId && !deletedIds.includes(itemId)) {
        deletedIds.push(itemId);
        $('#deleted_questions_id').val(deletedIds.join(','));
    }

    // Decrease question counter only if needed
    iteamQuestion--;

    // Remove the question block
    row.remove();
});
$('#trainingFormBtn').click(function (e) {

    let formData = new FormData($("#trainingForm")[0]);

    let $form = $("#trainingForm");

   
    

   let $submitButton = $('#trainingFormBtn'); // Use your actual button ID or class
    let originalText = $submitButton.html();

    // Set "Wait..." text and disable button
    $submitButton.text('Wait...').prop('disabled', true);

    // Clear previous error messages and invalid classes
    $('.error').empty().hide();
    $('input').removeClass('is-invalid');



    $.ajax({
        url: $("#trainingForm").attr('action'),
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
            // If there are errors, display them
            let errors = xhr.responseJSON.errors;
            if (errors) {
                $.each(errors, function (field, messages) {
                    let escapedField = field.replace(/\./g, '_').replace(/\[/g, '\\[').replace(/\]/g, '\\]');
                    $('#' + escapedField).addClass('is-invalid');


                    $('#' + escapedField + 'Error').text(messages[0]).show();
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