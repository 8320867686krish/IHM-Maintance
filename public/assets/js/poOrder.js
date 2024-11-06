$(document).ready(function () {
    var itemIndex = "{{ isset($poData->poOrderItems) ? count($poData->poOrderItems) : 0 }}";
    $("#checkHazmatAddForm").on('submit', function (e) {

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
            success: function (response) {
                if (response.isStatus) {
                    successMsg(response.message);
                } else {
                    errorMsg(response.message);
                }
            },
            error: function (xhr, status, error) {
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
        });
    })
    // Increment the index for each new item



    $('#addItemBtn').click(function () {
        $('#emptyMsg').hide();
        itemIndex++;

        var newItemRow = `
        <div class="row new-item-row">
            <div class="form-group col-3 mb-3">
                <input type="text" class="form-control form-control-lg" name="items[` + itemIndex + `][description]" autocomplete="off" placeholder="Description">
                <div class="invalid-feedback error"></div>
            </div>
            <div class="form-group col-2 mb-3">
                <input type="text" class="form-control form-control-lg" name="items[` + itemIndex + `][impa_no]" autocomplete="off" placeholder="IMPA NO">
                <div class="invalid-feedback error"></div>
            </div>
            <div class="form-group col-2 mb-3">
                <input type="text" class="form-control form-control-lg" name="items[` + itemIndex + `][part_no]" autocomplete="off" placeholder="Part No">
                <div class="invalid-feedback error"></div>
            </div>

            <div class="form-group col-1 mb-3">
                <input type="text" class="form-control form-control-lg" name="items[` + itemIndex + `][qty]" autocomplete="off" placeholder="Qty">
                <div class="invalid-feedback error"></div>
            </div>

            <div class="form-group col-1 mb-3">
                <input type="text" class="form-control form-control-lg" name="items[` + itemIndex + `][unit]" autocomplete="off" placeholder="Unit">
                <div class="invalid-feedback error"></div>
            </div>

          


             <div class="form-group col-2 mb-3">
                <select  class="form-control form-control-lg" name="items[` + itemIndex + `][type_category]"><option value="Relavant">Relavant</option><option value="Non relevant">Non relevant</option></select>
                <div class="invalid-feedback error"></div>
            </div>

            <div class="form-group col-1 mb-3">
                <i class="fas fa-trash-alt text-danger mt-3 remove-item-btn" style="font-size: 1rem"></i>
            </div>
        </div>
        `;

        $('#orderItemsContainer').append(newItemRow);
    });
    $(document).on('click', '.remove-item-btn', function () {
        var itemId = $(this).closest('.new-item-row').data('id');
        if (itemId) {
            var deletedIds = $('#deleted_id').val();
            $('#deleted_id').val(deletedIds ? deletedIds + ',' + itemId : itemId);
        }
        $(this).closest('.new-item-row').remove();

        if ($('.new-item-row').length === 1) {
            // If no rows are left, show a message
            $('#msgShow').show(); // Make sure you have an element with this ID to display the message
        }
    });

    $('#POForm').submit(function (e) {
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
                    successMsgWithRedirect(response.message, poItemGrid);
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
});
let selectedHazmatsIds = [];
$('#suspected_hazmat').on('changed.bs.select', function (e, clickedIndex, isSelected, previousValue) {

    let selectedValue = $(this).find('option').eq(clickedIndex).val();
    let selectedText = $(this).find('option').eq(clickedIndex).text();
    if (!isSelected) {
        $(`#cloneTableTypeDiv${selectedValue}`).remove();
    } else {
        var div = `<div class="col-12 col-md-12 col-lg-12 cloneTableTypeDiv mb-3 card" id="cloneTableTypeDiv${selectedValue}">
                <label for="table_type" id="tableTypeLable" class="mr-5 mt-3 tableTypeLable card-header">${selectedText}</label>
                <div class="row card-body">
                    <div class="col-4 table_typecol">
                        <div class="form-group mb-3">
                            <select class="form-control table_type tableType${selectedValue}" id="table_type_${selectedValue}" name="hazmats[${selectedValue}][table_type]">
                                <option value="Contained">Contained
                                </option>
                                <option value="Not Contained" selected="">
                                    Not Contained</option>
                                <option value="PCHM">
                                    PCHM</option>
                                <option value="Unknown">
                                    Unknown</option>
                            </select>
                        </div>
                    
                    </div>

                    <div class="col-4 imagehazmat" id="imagehazmat9">
                        <div class="form-group mb-3">
                            <input type="file" class="form-control" accept="*/*" id="image_${selectedValue}" name="hazmats[${selectedValue}][image]">
                        </div>
                    
                    </div>

                    <div class="col-4 dochazmat" id="dochazmat9">
                        <div class="form-group mb-3">
                            <input type="file" class="form-control" id="doc_9" name="hazmats[${selectedValue}][doc]">
                        </div>
                        <div style="font-size: 13px; margin-bottom: 10px;" id="docNameShow_${selectedValue}">
                                                </div>
                    </div>

            
                
                

                  
                </div>
            </div>`;
    }
    $('#showTableTypeDiv').append(div);
});

$(".deletePo").click(function (e) {
    e.preventDefault();
    var itemId = $(this).closest('.new-po-order').data('id');
    let confirmMsg = "Are you sure you want to delete this PO Record?";
    deleteUrl = "{{ url('po-order/delete') }}/" + itemId;

    confirmDeleteMethod(deleteUrl, confirmMsg, function (response) {
        $(this).closest('.new-po-order').remove();

    }, function (response) {
        console.log("Failed to delete: " + response.message);
    });
});
