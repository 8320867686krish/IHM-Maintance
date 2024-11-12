$(document).ready(function () {
    $("#showTableTypeDiv").on("click", ".cloneTableTypeDiv .sendmail", function(e) {
        e.preventDefault();
        var hazmatId = $(this).attr('data-id');
        var text = $(`#tableTypeLable${hazmatId}`).text();
        var hazmat_type = $(`#table_type_${hazmatId}`).val();
        var po_order_id = $("#po_order_id").val();
        var po_no = $("#po_no").val();
        $("#order_id").val(po_order_id);
        $("#email_body").val(text+' is '+hazmat_type)
        $("#shipId").val($("#ship_id").val());
        $("#email_subject").val(po_no);
        $("#hazmat_id").val(hazmatId);
        $('#relevantModal').modal('show');

    });
    $("#sendEmailForm").on('submit',function(e){
        e.preventDefault();
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
                    $('#relevantModal').modal('hide');

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
    });
    
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
            <div class="form-group col-3 mb-1">
                <input type="text" class="form-control form-control-lg" name="items[` + itemIndex + `][description]" autocomplete="off" placeholder="Description">
                <div class="invalid-feedback error"></div>
            </div>
            <div class="form-group col-2 mb-1">
                <input type="text" class="form-control form-control-lg" name="items[` + itemIndex + `][impa_no]" autocomplete="off" placeholder="IMPA NO">
                <div class="invalid-feedback error"></div>
            </div>
            <div class="form-group col-2 mb-1">
                <input type="text" class="form-control form-control-lg" name="items[` + itemIndex + `][part_no]" autocomplete="off" placeholder="Part No">
                <div class="invalid-feedback error"></div>
            </div>

            <div class="form-group col-1 mb-1">
                <input type="text" class="form-control form-control-lg" name="items[` + itemIndex + `][qty]" autocomplete="off" placeholder="Qty">
                <div class="invalid-feedback error"></div>
            </div>

            <div class="form-group col-1 mb-1">
                <input type="text" class="form-control form-control-lg" name="items[` + itemIndex + `][unit]" autocomplete="off" placeholder="Unit">
                <div class="invalid-feedback error"></div>
            </div>

          


             <div class="form-group col-2 mb-1">
                <select  class="form-control form-control-lg" name="items[` + itemIndex + `][type_category]"><option value="Relevant">Relevant</option><option value="Non relevant">Non relevant</option></select>
                <div class="invalid-feedback error"></div>
            </div>

            <div class="form-group col-1 mb-1">
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
            getEquipment(selectedValue);
            var div = `<input type="hidden" name="hazmats[${selectedValue}][id]" id="po_iteam_hazmat_id" value="0">
<div class="col-12 col-md-12 col-lg-12 cloneTableTypeDiv mb-1 card" id="cloneTableTypeDiv${selectedValue}">
                <label for="table_type" id="tableTypeLable${selectedValue}" class="mr-5 mt-3 tableTypeLable card-header">${selectedText}</label>
                <div class="row card-body">
                    <div class="col-4 table_typecol mb-2">
                        <div class="form-group">
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

                    <div class="col-4 equipment mb-2" id="equipment${selectedValue}">
                        <div class="form-group">
                           <select class="form-control  equipmentSelectTag" id="equipmentselect_${selectedValue}" name="hazmats[${selectedValue}][hazmet_equipment]" data-id="${selectedValue}" data-findTable="${tableType[0]}" data-divValue="${selectedValue}">
                                <option value="">Select Equipment
                                </option>
                              
                            </select>
                        </div>
                    
                    </div>

                     <div class="col-4 manufacturer mb-2" id="manufacturer${selectedValue}">
                        <div class="form-group">
                           <select class="form-control  manufacturerselect" id="manufacturerselect_${selectedValue}" name="hazmats[${selectedValue}][hazmet_manufacturer]" data-id="${selectedValue}" data-findTable="${tableType[0]}" data-divValue="${selectedValue}">
                                <option value="">Select Manufacturer
                                </option>
                              
                            </select>
                        </div>
                    
                    </div>


                      <div class="col-4 modelMakePart mb-1" id="modelMakePart${selectedValue}">
                        <div class="form-group">
                           <select class="form-control  modelMakePartSelect" data-id="${selectedValue}" id="modelMakePartselect_${selectedValue}" name="hazmats[${selectedValue}][modelMakePart]"  data-findTable="${tableType[0]}" data-divValue="${selectedValue}">
                                <option value="">Select Model Make and Part
                                </option>
                              
                            </select>
                        </div>
                    
                    </div>
                      <div class=" col-4  documentLoad1 mb-1" id="documentLoad1_${selectedValue}">
                        <div class="form-group"></div>
                      </div>

                       <div class=" col-4  documentLoad2 mb-1" id="documentLoad2_${selectedValue}">
                        <div class="form-group"></div>
                      </div>
                    </div>
            </div>
            
            `;
        }
        $('#showTableTypeDiv').append(div);
    }
});
$(document).on('change', '.equipmentSelectTag', function () {
    let optionValue = $(this).val();
    let id = $(this).attr('data-id');
    getManufacturer(id, optionValue);
});
$(document).on('change', '.manufacturerselect', function () {
    let optionValue = $(this).val();
    let id = $(this).attr('data-id');
    var equipment = $(`#equipmentselect_${id}`).val();
    getModel(id, equipment, optionValue);

});

$(document).on('change', '.modelMakePartSelect', function () {
    let optionValue = $(this).val();
    let id = $(this).attr('data-id');

    getDocument(id);

});
$("#showTableTypeDiv").on("change", ".cloneTableTypeDiv select.table_type", function () {
    const selectedValue = $(this).val();
    const tabletype = $(this).attr('data-findTable');
    const cloneTableTypeDiv = $(this).closest(".cloneTableTypeDiv");
    const divValue = $(this).attr("data-divvalue");
    cloneTableTypeDiv.find(`.onboard${divValue}`).remove();
    cloneTableTypeDiv.find(`.notification${divValue}`).remove();
    cloneTableTypeDiv.find(`.noitemInstalled${divValue}`).remove();
    cloneTableTypeDiv.find(`. removeItem${divValue}`).remove();

    if (selectedValue === 'Contained' || selectedValue === 'PCHM') {
        let isOnboardDiv = "";
        if(tabletype == 'A'){
        isOnboardDiv += `<div class="row card-body  notification${divValue}">
        <div class="col-11">
                        <div class="form-group">
                                       <div class="alert alert-danger" role="alert">Its not allowed on Board.!</div>

                        </div>
        </div>
            <div class="col-1"><div class="form-group"><button class="btn btn-primary float-right mb-1 sendmail"  type="button" data-id=${divValue}>Send Email</button></div></div>
         </div>`
        }
              isOnboardDiv += `  <div class="col-12 col-md-12 col-lg-12  mb-1  onboard${divValue}">
                <h5>Item arrived on board?</h5>
               <label class="custom-control custom-radio custom-control-inline">
                 <input type="radio" id="isArrived${divValue}" name="hazmats[${divValue}][isArrived]" value="yes" class="custom-control-input isArrivedChoice" data-tab="${tabletype}" data-isArrived="${divValue}"><span class="custom-control-label">Yes</span>
                </label>
                  <label class="custom-control custom-radio custom-control-inline">
                 <input type="radio" id="isArrived${divValue}" name="hazmats[${divValue}][isArrived]" value="no" class="custom-control-input isArrivedChoice"  data-tab="${tabletype}" data-isArrived="${divValue}"><span class="custom-control-label">No</span>
                </label>
               
            </div>

             <div class="col-12 col-md-12 col-lg-12  mb-1  removeItem${divValue}">
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


})
function removeItemDetailsfun(divValue) {
    let removeItemDetails = ` <div class="row  col-12 mb-1  removeItemDetails${divValue}">
    <div class="col-4 mb-2">
                   <div class="form-group">
                   <input type="text" name="hazmats[${divValue}][service_supplier_name]" id="service_supplier_name${divValue}" class="form-control" placeHolder="Service Supplier Name">
                   </div>
   </div>
     <div class="col-4 mb-2">
                   <div class="form-group">
                   <input type="text" name="hazmats[${divValue}][service_supplier_address]" id="service_supplier_address${divValue}" class="form-control" placeHolder="Service Supplier Address">
                   </div>
   </div>
    <div class="col-4 mb-2">
                   <div class="form-group">
                   <input type="date" name="hazmats[${divValue}][removal_date]" id="removal_date${divValue}" class="form-control" placeHolder="Removal Date">
                   </div>
   </div>

   <div class="col-4 mb-2">
                   <div class="form-group">
                   <input type="text" name="hazmats[${divValue}][removal_location]" id="removal_location${divValue}" class="form-control" placeHolder="Removal Location">
                   </div>
   </div>

    <div class="col-4 mb-2">
                   <div class="form-group">
                   <input type="file" name="hazmats[${divValue}][attachment]" id="attachment${divValue}" class="form-control" placeHolder="Attachment">
                   </div>
   </div>
     <div class="col-4 mb-2">
                   <div class="form-group">
                   <input type="text" name="hazmats[${divValue}][po_no]" id="po_no${divValue}" class="form-control" placeHolder="PO No">
                   </div>
   </div>
  
</div>`
    return removeItemDetails;
}
$("#showTableTypeDiv").on("change", ".cloneTableTypeDiv input[type=radio].isRemoveChoice", function () {
    const divValue = $(this).attr("data-isRemove");
    const cloneTableTypeDiv = $(this).closest(".cloneTableTypeDiv");
    $(`.removeItemDetails${divValue}`).remove();
    if ($(this).val() === 'yes') {
        let removeItemDetails = removeItemDetailsfun(divValue);
        $(cloneTableTypeDiv).append(removeItemDetails).fadeIn('slow');
    }
});

$("#showTableTypeDiv").on("change", ".cloneTableTypeDiv input[type=radio].isArrivedChoice", function () {

    const divValue = $(this).attr("data-isArrived");
    const tabValue = $(this).attr("data-tab");

    const cloneTableTypeDiv = $(this).closest(".cloneTableTypeDiv");
    cloneTableTypeDiv.find(`.returnItem${divValue}`).remove();

    if ($(this).val() === 'no') {
        cloneTableTypeDiv.find(`.returnItemDetails${divValue}`).remove();
    }
    cloneTableTypeDiv.find(`.ihmUpdated${divValue}`).remove();

    cloneTableTypeDiv.find(`.ihmItemDetails${divValue}`).remove();
    cloneTableTypeDiv.find(`.noitemInstalled${divValue}`).remove();

    cloneTableTypeDiv.find(`.itemInstall${divValue}`).remove();
    cloneTableTypeDiv.find(`.arrivedItemDetails${divValue}`).remove();

    let isReturnDiv = "";
    if ($(this).val() === 'yes') {
        isReturnDiv += ` <div class="row col-12 col-md-12 col-lg-12  mb-1   arrivedItemDetails${divValue}">
        <div class="col-4">
                       <div class="form-group mb-1">
                       <input type="text" name="hazmats[${divValue}][arrived_location]" id="arrived_location${divValue}" class="form-control" placeHolder="Location">
                       </div>
       </div>
         <div class="col-4">
                       <div class="form-group mb-1">
                       <input type="date" name="hazmats[${divValue}][arrived_date]" id="arrived_date${divValue}" class="form-control" placeHolder="Date">
                       </div>
       </div>
      
   </div>`
        if (tabValue === 'B') {
            isReturnDiv += `<div class="col-12 col-md-12 col-lg-12  mb-1  ihmUpdated${divValue}">
                <h5>ihm been updated ?</h5>
                <label class="custom-control custom-checkbox">
                <input type="checkbox" id="isIHMUpdated_yes${divValue}" name="hazmats[${divValue}][isIHMUpdated]" value="yes" class="custom-control-input isIHMUpdatedChoice" data-isIHMUpdated="${divValue}"><span class="custom-control-label"></span>
                </label></div>`
        }
    }
    if (tabValue === 'A') {
        isReturnDiv += `
        <div class="col-12 col-md-12 col-lg-12  mb-1  returnItem${divValue}">
            <h5>return of item initiated ?</h5>
           <label class="custom-control custom-radio custom-control-inline">
             <input type="radio" id="isReturn_yes${divValue}" name="hazmats[${divValue}][isReturn]" value="yes" class="custom-control-input isReturnChoice" data-isReturn="${divValue}"><span class="custom-control-label">Yes</span>
            </label>
              <label class="custom-control custom-radio custom-control-inline">
             <input type="radio" id="isReturn_no${divValue}" name="hazmats[${divValue}][isReturn]" value="no" class="custom-control-input isReturnChoice" data-isReturn="${divValue}"><span class="custom-control-label">No</span>
            </label>
           
        </div>`
    }
    $(isReturnDiv).insertBefore(`.removeItem${divValue}`).fadeIn('slow');

});
$("#showTableTypeDiv").on("change", ".cloneTableTypeDiv input[type=radio].isReturnChoice", function () {
    const divValue = $(this).attr("data-isReturn");
    const cloneTableTypeDiv = $(this).closest(".cloneTableTypeDiv");
    cloneTableTypeDiv.find(`.itemInstall${divValue}`).remove();
    cloneTableTypeDiv.find(`.noitemInstalled${divValue}`).remove();


    if ($(this).val() === 'no') {
        let isArrived = $(`#isArrived${divValue}:checked`).val();  // Get value of the checked radio button

        if (isArrived === 'yes') {
            cloneTableTypeDiv.find(`.returnItemDetails${divValue}`).remove();

            let isInstalledDiv = `
        <div class="col-12 col-md-12 col-lg-12  mb-1  itemInstall${divValue}">
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
            cloneTableTypeDiv.find(`.returnItemDetails${divValue}`).remove();

        }
    } else {
        cloneTableTypeDiv.find(`.ihmUpdated${divValue}`).remove();
        let returnItemDetails = ` <div class="row  col-12 mb-1  returnItemDetails${divValue}">
         <div class="col-4">
                        <div class="form-group mb-1">
                        <input type="text" name="hazmats[${divValue}][location]" id="location${divValue}" class="form-control" placeHolder="Location">
                        </div>
        </div>
          <div class="col-4">
                        <div class="form-group mb-1">
                        <input type="date" name="hazmats[${divValue}][date]" id="date${divValue}" class="form-control" placeHolder="Date">
                        </div>
        </div>
       
    </div>`
        $(returnItemDetails).insertBefore(`.removeItem${divValue}`).fadeIn('slow');

    }
});
$("#showTableTypeDiv").on("change", ".cloneTableTypeDiv input[type=radio].isInstalledChoice", function () {
    const divValue = $(this).attr("data-isInstalled");
    const cloneTableTypeDiv = $(this).closest(".cloneTableTypeDiv");
    cloneTableTypeDiv.find(`.ihmUpdated${divValue}`).remove();
    cloneTableTypeDiv.find(`.noitemInstalled${divValue}`).remove();
    cloneTableTypeDiv.find(`.ihmItemDetails${divValue}`).remove();


    if ($(this).val() === 'yes') {
        let isInstalledDiv = `
        <div class="col-12 col-md-12 col-lg-12  mb-1  ihmUpdated${divValue}">
            <h5>ihm been updated ?</h5>
           <label class="custom-control custom-checkbox">
             <input type="checkbox" id="isIHMUpdated_yes${divValue}" name="hazmats[${divValue}][isIHMUpdated]" value="yes" class="custom-control-input isIHMUpdatedChoice" data-isIHMUpdated="${divValue}"><span class="custom-control-label"></span>
            </label>
           
           
        </div>`
        $(isInstalledDiv).insertBefore(`.removeItem${divValue}`).fadeIn('slow');

    } else {
        let isInstalledDiv = `
        <div class=" col-12 col-md-12 col-lg-12  mb-1 noitemInstalled${divValue}">
           <p>Waiting for return to initiate
            </p>
           
           
        </div>`
        $(isInstalledDiv).insertBefore(`.removeItem${divValue}`).fadeIn('slow');
    }
});
$("#showTableTypeDiv").on("change", ".cloneTableTypeDiv input[type=checkbox].isIHMUpdatedChoice", function () {
    const divValue = $(this).attr("data-isIHMUpdated");
    const cloneTableTypeDiv = $(this).closest(".cloneTableTypeDiv");
    cloneTableTypeDiv.find(`.ihmItemDetails${divValue}`).remove();
    let tableValue = $(`#isArrived${divValue}:checked`).attr('data-tab');  // Get value of the checked radio button
    if ($(this).is(":checked")) {

        let ihmupdetedDetails = ` <div class="row  col-12 mb-2  ihmItemDetails${divValue}">
        <div class="col-4 mb-2">
                       <div class="form-group">
                       <input type="text" name="hazmats[${divValue}][ihm_location]" id="location${divValue}" class="form-control" placeHolder="Location">
                       </div>
       </div>
         <div class="col-4 mb-2">
                       <div class="form-group">
                       <input type="text" name="hazmats[${divValue}][ihm_sublocation]" id="ihm_sublocation${divValue}" class="form-control" placeHolder="Sub Location">
                       </div>
       </div>
       <div class="col-4 mb-2">
                       <div class="form-group">
                       <input type="text" name="hazmats[${divValue}][ihm_machinery_equipment]" id="ihm_machinery_equipment${divValue}" class="form-control" placeHolder="Machinary/Equipment">
                       </div>
       </div>

       <div class="col-4 mb-2">
                       <div class="form-group">
                       <input type="text" name="hazmats[${divValue}][ihm_parts]" id="ihm_parts${divValue}" class="form-control" placeHolder="Parts where used">
                       </div>
       </div>
 ${tableValue === 'B' ? tableBFiled(divValue) : `<div class="col-4 mb-2">
                       <div class="form-group">
                       <input type="text" name="hazmats[${divValue}][ihm_qty]" id="ihm_qty${divValue}" class="form-control" placeHolder="Quantity">
                       </div>
       </div>

       <div class="col-4 mb-2">
                       <div class="form-group">
                       <input type="text" name="hazmats[${divValue}][ihm_unit]" id="ihm_unit${divValue}" class="form-control" placeHolder="Unit">
                       </div>
       </div>`}
       
       <div class="col-12 mb-2">
                       <div class="form-group">
                       <input type="text" name="hazmats[${divValue}][ihm_remarks]" id="remarks${divValue}" class="form-control" placeHolder="remarks">
                       </div>
       </div>
      
   </div>`
        $(ihmupdetedDetails).insertBefore(`.removeItem${divValue}`).fadeIn('slow');

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
function tableBFiled(divValue) {
    let data = `<div class="col-4 mb-2">
                       <div class="form-group">
                       <input type="text" name="hazmats[${divValue}][ihm_previous_qty]" id="ihm_previous_qty${divValue}" class="form-control" placeHolder="Previous Quantity">
                       </div>
       </div>

       <div class="col-4 mb-2">
                       <div class="form-group">
                       <input type="text" name="hazmats[${divValue}][ihm_previous_unit]" id="ihm_previous_unit${divValue}" class="form-control" placeHolder="Unit">
                       </div>
       </div>
        <div class="col-3 mb-2">
                       <div class="form-group">
                       <input type="date" name="hazmats[${divValue}][ihm_last_date]" id="ihm_last_date${divValue}" class="form-control" placeHolder="Last Date">
                       </div>
       </div>
       <div class="col-3 mb-2">
                       <div class="form-group">
                       <input type="text" name="hazmats[${divValue}][ihm_qty]" id="ihm_qty${divValue}" class="form-control" placeHolder="Next Quantity">
                       </div>
       </div>

       <div class="col-3 mb-2">
                       <div class="form-group">
                       <input type="text" name="hazmats[${divValue}][ihm_unit]" id="ihm_unit${divValue}" class="form-control" placeHolder="Unit">
                       </div>
       </div>
          <div class="col-3 mb-2">
                       <div class="form-group">
                       <input type="date" name="hazmats[${divValue}][ihm_date]" id="ihm_date${divValue}" class="form-control" placeHolder="Next Date">
                       </div>
       </div>
       
       `;
    return data;
}
function getEquipment(hazmetId) {
    let url = `${baseUrl}/equipment/${hazmetId}`;
    fetchData(url, function (response) {
        $(`#equipmentselect_${hazmetId}`).attr('data-id', hazmetId);
        $.each(response.equipments, function (index, value) {
            $(`#equipmentselect_${hazmetId}`).append($('<option>', {
                value: index,
                text: index
            }));
        });
    });
}

function fetchData(url, callback) {
    $.ajax({
        url: url,
        method: 'get',
        dataType: 'json',
        contentType: false,
        processData: false,
        success: function (response) {
            callback(response);  // Pass the response to the callback
        }
    });
}


function getManufacturer(hazmetId, equipment) {
    let url = `${baseUrl}/manufacturer/${hazmetId}/${equipment}`;
    fetchData(url, function (response) {
        $(`#manufacturerselect_${hazmetId}`).empty();
        $(`#manufacturerselect_${hazmetId}`).empty().append($('<option>', {
            value: "",
            text: "First Select Equipment"
        }));
        $(`#manufacturerselect_${hazmetId}`).attr('data-id', hazmetId);
        $.each(response.manufacturers, function (index, value) {
            $(`#manufacturerselect_${hazmetId}`).append($('<option>', {
                value: value.manufacturer,
                text: value.manufacturer
            }));
        });
    });
}

function getModel(hazmetId, equipment, manufacturer) {
    let url = `${baseUrl}/model/${hazmetId}/${equipment}/${manufacturer}`;
    fetchData(url, function (response) {

        $(`#modelMakePartselect_${hazmetId}`).attr('data-id', hazmetId);

        $(`#modelMakePartselect_${hazmetId}`).empty();
        $(`#modelMakePartselect_${hazmetId}`).empty().append($('<option>', {
            value: "",
            text: "First Select Make & Model"
        }));
        $.each(response.documentData, function (index, value) {
            $(`#modelMakePartselect_${hazmetId}`).append($('<option>', {
                value: value.id,
                text: value.modelmakepart
            }));
        });
    });
}

function getDocument(hazmetId) {
    let url = `${baseUrl}/document/${hazmetId}`;
    fetchData(url, function (response) {
        let data = response.documentFile;
        if (data.document1['name'] != null) {
            $(`#documentLoad1_${hazmetId}`).empty();
            let html =
                `<a href="${data.document1['path']}" target="_black" > ${data.document1['name']} </a>`;
            $(`#documentLoad1_${hazmetId}`).append(html);
        }

        if (data.document2['name'] != null) {
            $(`#documentLoad2_${hazmetId}`).empty();
            let html =
                `<a href="${data.document2['path']}" target="_black"> ${data.document2['name']} </a>`;
            $(`#documentLoad2_${hazmetId}`).append(html);
        }

    });
}
