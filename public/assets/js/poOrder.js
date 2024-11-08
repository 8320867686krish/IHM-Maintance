$(document).ready(function () {
    var itemIndex = "{{ isset($poData->poOrderItems) ? count($poData->poOrderItems) : 0 }}";
    $("#checkHazmatAddForm").on('submit', function (e) {

        e.preventDefault();

        $('.error').empty().hide();
        $('input').removeClass('is-invalid');
        $('select').removeClass('is-invalid');

        let formData = new FormData(this);

        $.ajax({
            url: $(this).attr('action'),
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
    if (typeof clickedIndex !== 'undefined') {

        let selectedValue = $(this).find('option').eq(clickedIndex).val();

        let selectedOption = $(this).find('option').eq(clickedIndex);

        let selectedText = $(this).find('option').eq(clickedIndex).text();
        let tableTypeData = selectedOption.data('table');
        let tableType = tableTypeData.split('-');
        if (!isSelected) {
            $(`#cloneTableTypeDiv${selectedValue}`).remove();
        } else {
            var div = `<input type="hidden" name="hazmats[${selectedValue}][id]" id="po_iteam_hazmat_id" value="0">
<div class="col-12 col-md-12 col-lg-12 cloneTableTypeDiv mb-3 card" id="cloneTableTypeDiv${selectedValue}">
                <label for="table_type" id="tableTypeLable" class="mr-5 mt-3 tableTypeLable card-header">${selectedText}</label>
                <div class="row card-body">
                    <div class="col-4 table_typecol">
                        <div class="form-group mb-3">
                            <select class="form-control table_type tableType${selectedValue}" id="table_type_${selectedValue}" name="hazmats[${selectedValue}][hazmat_type]"  data-findTable="${tableType[0]}" data-divValue="${selectedValue}">
                                <option value="Contained">Contained
                                </option>
                                <option value="Not Contained" selected="" >
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
            </div>
            
            `;
        }
        $('#showTableTypeDiv').append(div);
    }
});
//for contained or pchm then add
$("#showTableTypeDiv").on("change", ".cloneTableTypeDiv select.table_type", function () {
    const selectedValue = $(this).val();
    const tabletype = $(this).attr('data-findTable');
    const cloneTableTypeDiv = $(this).closest(".cloneTableTypeDiv");
    const divValue = $(this).attr("data-divvalue");
    cloneTableTypeDiv.find(`.onboard${divValue}`).remove();

    if (tabletype === 'A') {
        if (selectedValue === 'Contained' || selectedValue === 'PCHM') {

            let isOnboardDiv = `
            <div class="col-12 col-md-12 col-lg-12  mb-3  onboard${divValue}">
                <h5>Item arrived on board?</h5>
               <label class="custom-control custom-radio custom-control-inline">
                 <input type="radio" id="isArrived${divValue}" name="hazmats[${divValue}][isArrived]" value="yes" class="custom-control-input isArrivedChoice" data-isArrived="${divValue}"><span class="custom-control-label">Yes</span>
                </label>
                  <label class="custom-control custom-radio custom-control-inline">
                 <input type="radio" id="isArrived${divValue}" name="hazmats[${divValue}][isArrived]" value="no" class="custom-control-input isArrivedChoice" data-isArrived="${divValue}"><span class="custom-control-label">No</span>
                </label>
               
            </div>

             <div class="col-12 col-md-12 col-lg-12  mb-3  removeItem${divValue}">
                <h5>remove the item?</h5>
               <label class="custom-control custom-radio custom-control-inline">
                 <input type="radio" id="isRemove${divValue}" name="hazmats[${divValue}][isRemove]" value="yes" class="custom-control-input isRemoveChoice" data-isRemove="${divValue}"><span class="custom-control-label">Yes</span>
                </label>
                  <label class="custom-control custom-radio custom-control-inline">
                 <input type="radio" id="isRemove${divValue}" name="hazmats[${divValue}][isRemove]" value="no" class="custom-control-input isRemoveChoice" data-isRemove="${divValue}"><span class="custom-control-label">No</span>
                </label>
               
            </div>
           
        `;
            $(cloneTableTypeDiv).append(isOnboardDiv).fadeIn('slow');

        } else {
            cloneTableTypeDiv.find(`.returnItem${divValue}`).remove();
            cloneTableTypeDiv.find(`.returnItemDetails${divValue}`).remove();
            cloneTableTypeDiv.find(`.ihmUpdated${divValue}`).remove();
            cloneTableTypeDiv.find(`.itemInstall${divValue}`).remove();

        }

    }
})
$("#showTableTypeDiv").on("change", ".cloneTableTypeDiv input[type=radio].isRemoveChoice", function () {
    const divValue = $(this).attr("data-isRemove");
    const cloneTableTypeDiv = $(this).closest(".cloneTableTypeDiv");
    $(`.removeItemDetails${divValue}`).remove();
    if ($(this).val() === 'yes') {
        let removeItemDetails = ` <div class="row  col-12 mb-3  removeItemDetails${divValue}">
    <div class="col-4">
                   <div class="form-group mb-3">
                   <input type="text" name="hazmats[${divValue}][service_supplier_name]" id="service_supplier_name${divValue}" class="form-control" placeHolder="Service Supplier Name">
                   </div>
   </div>
     <div class="col-4">
                   <div class="form-group mb-3">
                   <input type="text" name="hazmats[${divValue}][service_supplier_address]" id="service_supplier_address${divValue}" class="form-control" placeHolder="Service Supplier Address">
                   </div>
   </div>
    <div class="col-4">
                   <div class="form-group mb-3">
                   <input type="date" name="hazmats[${divValue}][removal_date]" id="removal_date${divValue}" class="form-control" placeHolder="Removal Date">
                   </div>
   </div>

   <div class="col-4">
                   <div class="form-group mb-3">
                   <input type="text" name="hazmats[${divValue}][removal_location]" id="removal_location${divValue}" class="form-control" placeHolder="Removal Location">
                   </div>
   </div>

    <div class="col-4">
                   <div class="form-group mb-3">
                   <input type="file" name="hazmats[${divValue}][attachment]" id="attachment${divValue}" class="form-control" placeHolder="Attachment">
                   </div>
   </div>
     <div class="col-4">
                   <div class="form-group mb-3">
                   <input type="text" name="hazmats[${divValue}][po_no]" id="po_no${divValue}" class="form-control" placeHolder="PO No">
                   </div>
   </div>
  
</div>`
        $(cloneTableTypeDiv).append(removeItemDetails).fadeIn('slow');
    }


});

$("#showTableTypeDiv").on("change", ".cloneTableTypeDiv input[type=radio].isArrivedChoice", function () {

    const divValue = $(this).attr("data-isArrived");
    const cloneTableTypeDiv = $(this).closest(".cloneTableTypeDiv");
    cloneTableTypeDiv.find(`.returnItem${divValue}`).remove();

    if ($(this).val() === 'no') {
        cloneTableTypeDiv.find(`.returnItemDetails${divValue}`).remove();
    }
    cloneTableTypeDiv.find(`.ihmUpdated${divValue}`).remove();

    cloneTableTypeDiv.find(`.itemInstall${divValue}`).remove();
    let isReturnDiv = `
        <div class="col-12 col-md-12 col-lg-12  mb-3  returnItem${divValue}">
            <h5>return of item initiated ?</h5>
           <label class="custom-control custom-radio custom-control-inline">
             <input type="radio" id="isReturn_yes${divValue}" name="hazmats[${divValue}][isReturn]" value="yes" class="custom-control-input isReturnChoice" data-isReturn="${divValue}"><span class="custom-control-label">Yes</span>
            </label>
              <label class="custom-control custom-radio custom-control-inline">
             <input type="radio" id="isReturn_no${divValue}" name="hazmats[${divValue}][isReturn]" value="no" class="custom-control-input isReturnChoice" data-isReturn="${divValue}"><span class="custom-control-label">No</span>
            </label>
           
        </div>`
    $(isReturnDiv).insertBefore(`.removeItem${divValue}`).fadeIn('slow');


});
$("#showTableTypeDiv").on("change", ".cloneTableTypeDiv input[type=radio].isReturnChoice", function () {
    const divValue = $(this).attr("data-isReturn");
    const cloneTableTypeDiv = $(this).closest(".cloneTableTypeDiv");
    cloneTableTypeDiv.find(`.itemInstall${divValue}`).remove();

    if ($(this).val() === 'no') {
        let isArrived = $(`#isArrived${divValue}:checked`).val();  // Get value of the checked radio button

        if (isArrived === 'yes') {
            cloneTableTypeDiv.find(`.returnItemDetails${divValue}`).remove();

            let isInstalledDiv = `
        <div class="col-12 col-md-12 col-lg-12  mb-3  itemInstall${divValue}">
            <h5>Has the item been installed ?</h5>
           <label class="custom-control custom-radio custom-control-inline">
             <input type="radio" id="isInstalled_yes${divValue}" name="hazmats[${divValue}][isInstalled]" value="yes" class="custom-control-input isInstalledChoice" data-isInstalled="${divValue}"><span class="custom-control-label">Yes</span>
            </label>
              <label class="custom-control custom-radio custom-control-inline">
             <input type="radio" id="isInstalled_no${divValue}" name="hazmats[${divValue}][isInstalled]" value="no" class="custom-control-input isInstalledChoice" data-isInstalled="${divValue}"><span class="custom-control-label">No</span>
            </label>
           
        </div>`
            // $(cloneTableTypeDiv).append(isInstalledDiv).fadeIn('slow');
            $(isInstalledDiv).insertBefore(`.removeItem${divValue}`).fadeIn('slow');


        } else {
            let isInstalledDiv = `
            <div class="col-12 col-md-12 col-lg-12  mb-3  reminderSend${divValue}">
                <h5>Send Reminder</h5>
                
               
            </div>`
            $(isInstalledDiv).insertBefore(`.removeItem${divValue}`).fadeIn('slow');

            cloneTableTypeDiv.find(`.returnItemDetails${divValue}`).remove();

        }
    } else {
        cloneTableTypeDiv.find(`.ihmUpdated${divValue}`).remove();
        let returnItemDetails = ` <div class="row  col-12 mb-3  returnItemDetails${divValue}">
         <div class="col-4">
                        <div class="form-group mb-3">
                        <input type="text" name="hazmats[${divValue}][location]" id="location${divValue}" class="form-control" placeHolder="Location">
                        </div>
        </div>
          <div class="col-4">
                        <div class="form-group mb-3">
                        <input type="date" name=""hazmats[${divValue}][date]" id="date${divValue}" class="form-control" placeHolder="Date">
                        </div>
        <div>
       
    </div>`
        $(returnItemDetails).insertBefore(`.removeItem${divValue}`).fadeIn('slow');

    }
});
$("#showTableTypeDiv").on("change", ".cloneTableTypeDiv input[type=radio].isInstalledChoice", function () {
    const divValue = $(this).attr("data-isInstalled");
    const cloneTableTypeDiv = $(this).closest(".cloneTableTypeDiv");
    cloneTableTypeDiv.find(`.ihmUpdated${divValue}`).remove();
    if ($(this).val() === 'yes') {
        let isInstalledDiv = `
        <div class="col-12 col-md-12 col-lg-12  mb-3  ihmUpdated${divValue}">
            <h5>ihm been updated ?</h5>
           <label class="custom-control custom-radio custom-control-inline">
             <input type="radio" id="isIHMUpdated_yes${divValue}" name="hazmats[${divValue}][isIHMUpdated]" value="yes" class="custom-control-input isIHMUpdatedChoice" data-isIHMUpdated="${divValue}"><span class="custom-control-label">Yes</span>
            </label>
           
           
        </div>`
        $(isInstalledDiv).insertBefore(`.removeItem${divValue}`).fadeIn('slow');

    }
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
