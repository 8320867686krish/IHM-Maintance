var isStopped = false;
var initialLeft, initialTop;
let widthPercent = 100;
let previewImgInWidth = $("#previewImg1").width();
let currectWithPercent = widthPercent;
let amended = $("#amended").val();
function makeDotsDraggable() {
    $(".dot").draggable({
        containment: "#previewImg1",
        stop: function (event, ui) {
            var new_left_perc = parseInt($(this).css("left")) + "px";
            var new_top_perc = parseInt($(this).css("top")) + "px";

            var new_left_in_px = Math.round((parseInt($(this).css("left"))));
            var new_top_in_px = Math.round((parseInt($(this).css("top"))));

            $(this).css("left", new_left_perc);
            $(this).css("top", new_top_perc);

            dotsDrugUpdatePositionForDB(this);
        }
    });
}

function detailOfHazmats(checkId) {
    $.ajax({
        type: 'GET',
        url: `${baseUrl}/check/${checkId}/hazmat/${amended}`,
        success: function (response) {
            $("#chksName").val(response.check.data.name);
            $("#chkType").val(response.check.data.type);
            if(response.check.data.close_image){
                $('.showcloseUpImage').show();
                $('.showcloseUpImage').html(`<a href="${response.check.data.close_image}" target="_blank" style="color:blue">${response.check.original_close_image}</a>`);


            }
            if(response.check.data.away_image){
                $('.showawayImage').show();
                $('.showawayImage').html(`<a href="${response.check.data.away_image}" target="_blank" style="color:blue">${response.check.original_away_image}</a>`);
            }

            $('#showTableHazmat').html(response.html);

            $.each(response.check.hazmats, function (index, hazmatData) {
                if (hazmatData.type === 'Unknown') {
                    $(`#imagehazmat${hazmatData.hazmat_id}`).hide();
                    $(`#dochazmat${hazmatData.hazmat_id}`).hide();
                }
            });

            const cloneTableTypeDiv = $(".cloneTableTypeDiv select.table_type").closest(
                ".cloneTableTypeDiv");

            cloneTableTypeDiv.find(".equipment").hide();
            cloneTableTypeDiv.find(".manufacturer").hide();
            cloneTableTypeDiv.find(".modelMakePart").hide();

            $("#formType").val("edit");

            $("#checkDataAddModal").modal('show');
        },
    });
}
$(document).on('click', '#viewRemarks', function (e) {
    var remarks = $(this).attr('data-remarks');
    $(".remrksText").text(remarks)
    $("#remarksModel").modal('show');
});
function openAddModalBox(dot) {
    let $dot = $(dot);
    // Remove the "selected" class from all dots
    $(".dot").removeClass("selected");
    // Add the "selected" class to the clicked dot
    $dot.addClass("selected");

    // Retrieve data attributes from the clicked dot
    let checkId = $dot.attr('data-checkId');
    let data = $dot.attr('data-check');


    if (checkId) {
        $("#check_id").val(checkId);
        $("#id").val(checkId);
        // $("#checkDataAddModal").removeClass("addForm").addClass("editForm");
        detailOfHazmats(checkId);
    }

    // Populate form fields if data is available
    if (data) {
        var jsonObject = JSON.parse(data);
        for (var key in jsonObject) {
            if (jsonObject.hasOwnProperty(key)) {
                $("#" + key).val(jsonObject[key]);
            }
        }
    }
    // Show the modal box
    $("#checkDataAddModal").modal('show');
}

function dotsDrugUpdatePositionForDB(dot) {
    let $dots = $(dot);

    let check_id = $dots.attr('data-checkId');
    let jsonObject = JSON.parse($dots.attr('data-check'));

    let position_left = parseFloat($dots.css('left')) * (100 / widthPercent);
    let position_top = parseFloat($dots.css('top')) * (100 / widthPercent);

    if (check_id && check_id != "0") {
        $.ajax({
            url: "",
            method: 'POST',
            data: {
                id: check_id,
                type: jsonObject.type,
                project_id: jsonObject.project_id,
                position_left: position_left,
                position_top: position_top,
                _token: '{{ csrf_token() }}'
            },
            success: function (response) {
                let messages = `<div class="alert alert-primary alert-dismissible fade show" role="alert">
                            ${response.message}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span>&times;</span>
                            </button>
                        </div>`;

                $("#showSuccessMsg").html(messages);
                $('#showSuccessMsg').fadeIn().delay(20000).fadeOut();
            },
            error: function (xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    }
}

function updateZoomValue() {
    $('.zoom-value').text(widthPercent + '%');
}

function resetImagePx() {
    $(".target").css({
        left: "0px",
        top: "0px"
    });
}

function setDotPosition() {
    $(".dot").each(function (index) {
        let left = parseFloat($(this).css('left'));
        let top = parseFloat($(this).css('top'));

        left = left * (widthPercent / currectWithPercent);
        top = top * (widthPercent / currectWithPercent);

        $(this).css('left', left);
        $(this).css('top', top);
        $(this).width(20 * (widthPercent / 100));
        $(this).height(20 * (widthPercent / 100));
        $(this).css('line-height', 20 * (widthPercent / 100) + "px");
    });
}

function updateZoom(zoomValue) {
    let newWidth = previewImgInWidth * (zoomValue / 100);
    $("#previewImg1").width(newWidth);
    setDotPosition();
    updateZoomValue(zoomValue);
}


$(document).ready(function () {
    let checkId;
    $(".imagehazmat").hide();

    // $("#checkList").css('max-height', $("#previewImg1").height());
    $("#checkList").css('max-height', '100%');
    $('.target').draggable({
        stop: function (event, ui) {
            isStopped = true;
        }
    });

    $('.ranger').on('input', function () {
        currectWithPercent = widthPercent;
        widthPercent = parseInt($(this).val());
        updateZoom(widthPercent);
    });

    $(document).on("click", "#zoom-in", function () {
        resetImagePx();
        currectWithPercent = widthPercent;
        if (widthPercent <= 175) {
            widthPercent += 25;
            let newWidth = previewImgInWidth * (widthPercent / 100);
            $("#previewImg1").width(newWidth);
            setDotPosition();
            updateZoomValue();
            $('.ranger').val(widthPercent);
        }
    });

    $(document).on("click", "#zoom-out", function () {
        resetImagePx();
        currectWithPercent = widthPercent;
        if (widthPercent >= 75) {
            widthPercent -= 25;
            let newWidth = previewImgInWidth * (widthPercent / 100);
            $("#previewImg1").width(newWidth);
            setDotPosition();
            updateZoomValue();
            $('.ranger').val(widthPercent);
        }
    });

    $(".outfit img").click(function (e) {
        e.preventDefault();
        if (!isStopped) {

            var dot_count = $(".dot").length;

            var top_offset = $(this).offset().top - $(window).scrollTop();
            var left_offset = $(this).offset().left - $(window).scrollLeft();

            var top_px = Math.round((e.clientY - top_offset - 10));
            var left_px = Math.round((e.clientX - left_offset - 10));

            var top_perc = top_px / $(this).height() * 100;
            var left_perc = left_px / $(this).width() * 100;

            var container_width = $(this).width();
            var container_height = $(this).height();

            var top_in_px = Math.round((top_perc / 100) * container_height);
            var left_in_px = Math.round((left_perc / 100) * container_width);

            var dot = '<div class="dot" style="top: ' + top_in_px + 'px; left: ' +
                left_in_px + 'px;" id="dot_' + (dot_count + 1) + '">' + (dot_count + 1) + '</div>';

            $(dot).hide().appendTo($(this).parent()).fadeIn(350, function () {
                openAddModalBox(this); // Call the function with the newly created dot
                makeDotsDraggable();
            });

            currectWithPercent = widthPercent;
            setDotPosition();
        }

        if (isStopped) {
            isStopped = false;
        }
    });

    makeDotsDraggable();
    $(document).on("click", ".dot", function () {
        openAddModalBox(this);
    });

    $(document).on("click", "#editCheckbtn", function (event) {
        event.stopPropagation(); // Prevents the click event from bubbling up to the parent .dot element
        let checkId = $(this).attr('data-id');
        let data = $(this).attr('data-check');
        let allCheck = $(this).attr('data-all');
        $("#allCheck").val(allCheck);

        if (data) {
            let parseData = JSON.parse(data);
            $("#position_left").val(parseData.position_left);
            $("#position_top").val(parseData.position_top)
            $("#ship_id").val(parseData.ship_id);
            $("#check_id").val(parseData.id);
            $("#deck_id").val(parseData.deck_id);
        }

        detailOfHazmats(checkId);
        //   let dotElement = $(`#${checkDataId}`)[0];
        //  openAddModalBox(dotElement);
    });

    $(document).on("click", "#checkDataAddSubmitBtn", function () {
        var checkId = $(".dot.selected").attr('data-checkId');
        $("#id").val(checkId);
        let position_left = parseFloat($(".dot.selected").css('left')) * (100 / widthPercent);
        let position_top = parseFloat($(".dot.selected").css('top')) * (100 / widthPercent);
        if (!isNaN(position_left)) {
            $("#position_left").val(position_left);
        }
        if (!isNaN(position_top)) {
            $("#position_top").val(position_top);
        }
        if (!checkId) {
            checkId = 0;
            $(".dot.selected").attr('data-checkId', checkId);
        }
        let checkFormData = new FormData($("#checkDataAddForm")[0]);

        let $submitButton = $(this);
        let originalText = $submitButton.html();
        $submitButton.text('Wait...');
        $submitButton.prop('disabled', true);

        $.ajax({
            type: 'POST',
            url: $("#checkDataAddForm").attr('action'),
            data: checkFormData,
            contentType: false,
            processData: false,
            success: function (response) {
                if (response.isStatus) {
                    $(".dot.selected").attr('data-checkId', response.id);
                    var checkData = {
                        id: response.id,
                        name: response.name,
                        project_id: $("#project_id").val(),
                        deck_id: $("#deck_id").val(),
                        type: $("#type").val(),
                        equipment: $("#equipment").val(),
                        component: $("#component").val(),
                        remarks: $("#remarks").val(),
                        recommendation: $("#recommendation").val(),
                        allCheck: $("#allCheck").val()
                    };
                    let checkDataJson = JSON.stringify(checkData);
                    $(".dot.selected").attr('data-check', checkDataJson);
                    $('#checkListUl').html(response.htmllist);
                    $("#checkListTable").html(response.trtd);
                    successMsg(response.message);
                    $("#checkDataAddForm").trigger('reset');
                    $(".showcloseUpImage").hide();
                    $(".showawayImage").hide();
                    $("#id").val("");
                    $("#check_id").val("");

                    $('#suspected_hazmat option').prop("selected", false).trigger(
                        'change');
                    $("#showTableHazmat").empty();
                    $submitButton.html(originalText);
                    $submitButton.prop('disabled', false);
                    $("#type").removeClass('is-invalid');
                    $("#typeError").text('');
                    $("#formType").val('add');
                    $("#checkDataAddModal").modal('hide');
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
});

$(document).on("click", "#checkDataAddCloseBtn", function () {
    $("#checkDataAddForm").trigger('reset');
    $("#id").val("");
    $("#check_id").val("");
    $("#showTableHazmat").empty();
    $('.showcloseUpImage').hide();
    $('.showawayImage').hide();
    $("#type").removeClass('is-invalid');
    $("#formType").val("add");
    $("#typeError").text('');
});
$(document).on("click", ".deleteCheckbtn", function (e) {
    e.preventDefault();
    let recordId = $(this).data('id');
    let deleteUrl = $(this).attr("href");
    let $liToDelete = $(this).closest('li');
    let confirmMsg = "Are you sure you want to delete this check?";

    confirmDeleteWithElseIf(deleteUrl, confirmMsg, 'post', function (response) {
        // Success callback
        if (response.isStatus) {
            $liToDelete.remove();
            $(".dot").remove();
            $('#showDeckCheck').html();
            $('#checkListUl').html();
            $('#showDeckCheck').html(response.htmldot);
            $('#checkListUl').html(response.htmllist);
            makeDotsDraggable();
        }
    });
});
checkIteamindex = 0;
$(document).on('click', '.addNewItemBtn', function (e) {
    e.preventDefault();
    checkIteamindex++;
    // Get the index of the clicked button
    //  var clickedIndex = $('.addNewItemBtn').index(this);
var  newItem = "";
    // Add a new item to the container
     newItem+= `<div class="col-12 col-md-12 col-lg-12 card cloneCheck" id="cloneCheck${checkIteamindex}">`
               
        newItem+=  `<div class="col-12 col-md-12 col-lg-12 mt-2 text-right">
        <a href="javascript:;" class="deleteCheckItem" data-itemId=${checkIteamindex} title="Delete"><i class="fas fa-trash-alt text-danger" style="font-size: 1rem"></i></a> </div>`

    
              
    
           
    newItem+= `<div class="row card-body">
                    <div class="col-12 mt-2 ihm_part">
                        <div class="form-group">
                            <label>IHM Table</label>
                            <select class="form-control ihm_part_table" name="check_hazmats[${checkIteamindex}][ihm_part_table]" data-check="${checkIteamindex}" id="ihm_part${checkIteamindex}">
                                <option value="">Select IHM</option>    
                                <option value="i-1">i-1</option>
                                <option value="i-2">i-2</option>
                                <option value="i-3">i-3</option>
                            </select>
                        </div>
                     </div>
                </div>
            </div>`
    $('#showTableHazmat').append(newItem);
    // Log the index for debugging

});

$(document).on('click', '.deleteCheckItem', function (e) {
    var checkItemId = $(this).attr('data-itemId');
    var deletedCheckIds = $('#check_deleted_id').val();
    $('#check_deleted_id').val(deletedCheckIds ? deletedCheckIds + ',' + checkItemId : checkItemId);
    $(`#cloneCheck${checkItemId}`).remove();

});

$(document).on('change', '.ihm_part_table', function (e) {
    var id = $(this).attr('data-check');
    var value = $(this).val();
    const cloneTableTypeDiv = $(this).closest(".cloneCheck");
    cloneTableTypeDiv.find(`#itemsData${id}`).remove();
    var divitem = creteFiledforI1(id, value);
    $(cloneTableTypeDiv).append(divitem);

});
function creteFiledforI1(id, value) {
    var title = '';
    var label = 'Name of';

    if (value === 'i-1') {
        label += 'paint';
        title += 'I-1 Paints and coating systems';
    }
    else if (value === 'i-2') {
        label += 'equipment and machinery';
        title += 'I-2 Equipment and machinery';

    }
    else {
        label += 'structural element';
        title += 'I-3 Strucure and hull';

    }

    var item = `<div class="row card-body" id="itemsData${id}"><div class="col-12 mb-2"><h4>${title} containing materials listed in table A and table B of appendix 1 of these guidelines
    </h4></div>`;


    if (value === 'i-1') {
        item += `<div class="col-4 mb-2">
        <div class="form-group">
                            <label>Application of paint</label>
                            <input type="text" name="check_hazmats[${id}][application_of_paint]" id="application_of_paint[${id}]" class="form-control">
                            </div>
    </div>`
    }
    item += `<div class="col-4 mb-2">
        <div class="form-group">
                            <label>${label}</label>
                            <input type="text" name="check_hazmats[${id}][name_of_paint]" id="name_of_paint[${id}]" class="form-control">
                            </div>
    </div>
    <div class="col-4 mb-2">
        <div class="form-group">
                            <label>Location</label>
                            <input type="text" name="check_hazmats[${id}][location]" id="location[${id}]" class="form-control">
                            </div>
    </div>
     <div class="col-4 mb-2">
        <div class="form-group">
                            <label>Materials(classification in appendix 1)</label>
                            <select  name="check_hazmats[${id}][hazmat_id]" id="hazmat_id[${id}]" class="form-control">`;
    item += '<option value="">Select Hazmat</option>'
    hazmatOptions.forEach(option => {
        item += `<option value="${option.id}">${option.name}</option>`;
    });

    item += `</select>
                            </div>
    </div>`;
    if (value === 'i-2' || value === 'i-3') {

        item += `<div class="col-4 mb-2">
        <div class="form-group">
                            <label>Parts where used</label>
                            <input type="text" name="check_hazmats[${id}][parts_where_used]" id="parts_where_used[${id}]" class="form-control">
                            </div>
    </div>`;
    }

    item += `<div class="col-4 mb-2">
        <div class="form-group">
                            <label>Quantity</label>
                            <input type="number" name="check_hazmats[${id}][qty]" id="qty[${id}]" class="form-control">
                            </div>
    </div>
    <div class="col-4 mb-2">
        <div class="form-group">
                            <label>Unit</label>
                            <input type="text" name="check_hazmats[${id}][unit]" id="unit[${id}]" class="form-control">
                            </div>
    </div>
    
     <div class="col-9 mb-2">
        <div class="form-group">
                            <label>Remarks</label>
                            <input type="text" name="check_hazmats[${id}][remarks]" id="remarks[${id}]" class="form-control">
                            </div>
    </div>

    <div class="col-3 mb-2">
        <div class="form-group">
                            <label>Type</label>
                            <select  name="check_hazmats[${id}][hazmat_type]" id="hazmat_type[${id}]" class="form-control">
                            <option value="">Select Type</option>
                             <option value="Contained">Contained</option>
                              <option value="PCHM">PCHM</option>
                            </select>
                            </div>
    </div>
     
    </div>`
    item += ` <div class="row card-body strikethroughDiv" id=strikethroughDiv${id}>
    <div class="col-3 mb-2">
      <label class="custom-control custom-checkbox custom-control-inline">
        <input type="checkbox" value="1" name="check_hazmats[${id}][isStrike]" id="strike[${id}]" data-id="${id}" class="custom-control-input strike"><span class="custom-control-label">Strike through  </span>
    </label>
       
      </div></div>
    `
    return item;
}

$("#showTableHazmat").on("change", ".cloneCheck input[type=checkbox].strike", function () {
    const cloneTableTypeDiv = $(this).closest(".cloneCheck");
    let id = $(this).attr('data-id');
    $(`#strikethroughDivIteam${id}`).remove();
    if ($(this).is(":checked")) {
        let item = ` <div class="row card-body strikethroughDivIteam" id=strikethroughDivIteam${id}>
            <div class="col-12 mb-2">
                <div class="form-group">
                    <label>Remarks</label>
                    <textarea name="check_hazmats[${id}][strike_remarks]" id="strike[${id}]"class="form-control"></textarea>
                </div>
            </div>

             <div class="col-6 mb-2">
                <div class="form-group">
                    <label>Document</label>
                    <input type="file" name="check_hazmats[${id}][strike_document]" id="strike_document[${id}]"class="form-control">
                </div>
            </div>

              <div class="col-6 mb-2">
                <div class="form-group">
                    <label>Date</label>
                    <input type="date" name="check_hazmats[${id}][strike_date]" id="strike_date[${id}]"class="form-control">
                </div>
            </div>
        </div>
        `
        $(`#strikethroughDiv${id}`).after(item);

    } else {
        // Remove strikethrough if unchecked
        console.log("noo");
    }
});
