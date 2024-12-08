  $(document).ready(function() {
   
        $('#getDeckCropImg').click(async function() {
            let $submitButton = $(this);
            let originalText = $submitButton.html();
            $submitButton.text('Wait...');
            $submitButton.prop('disabled', true);
            $(".pdfModalCloseBtn").prop('disabled', true);

            let images = document.querySelectorAll('.pdf-image');
            let projectId = shipData || '';
            const pdfFile = document.getElementById('pdfFile').files[0];

            let allResponses = [];

            for (let index = 0; index < images.length; index++) {
                let image = images[index];
                let areas = $(image).areaSelect('get');
                let textareas = [];

                areas.forEach(area => {
                    let input = document.getElementById(area.id);
                    if (input) {
                        textareas.push({
                            ...area,
                            'text': input.value
                        });
                    }
                });

                try {
                    if (textareas.length > 0) {
                        allResponses.length = 0;
                        let response = await saveImageWithAreas(image.src, index, projectId,
                            pdfFile, textareas);
                        allResponses.push(response);
                    }
                } catch (error) {
                    console.error('Error saving image:', error);
                    $submitButton.html(originalText);
                    $submitButton.prop('disabled', false);
                    $(".pdfModalCloseBtn").prop('disabled', false);
                    return;
                }
            }
            handleSaveSuccess(allResponses);
            cleanupModal();
            $submitButton.html(originalText);
            $submitButton.prop('disabled', false);
            $(".pdfModalCloseBtn").prop('disabled', false);
        });
        function handleSaveSuccess(responses) {
            $('.deckView').html('');
            responses.forEach(response => {
                $('.deckView').append(response.html);
            });
        }
        function cleanupModal() {
            $('.pdf-image').empty();
            $("#pdfFile").val('');
            $("#pdfModal").removeClass('show');
            $("body").removeClass('modal-open');
            $("#img-container").empty();
            $(".modal-backdrop").remove();
            $('#pdfModal').modal('hide');
        }

        function saveImageWithAreas(imageSrc, index, projectId, pdfFile, textareas) {
            return new Promise((resolve, reject) => {
                let areasJSON = JSON.stringify(textareas);

                fetch(imageSrc)
                    .then(res => res.blob())
                    .then(blob => {
                        var formData = new FormData();
                        formData.append('image', blob, 'page_' + (index + 1) + '.png');
                        formData.append('_token', token);
                        formData.append('ship_id', projectId);
                        formData.append('ga_plan', pdfFile);
                        formData.append('areas', areasJSON);

                        $.ajax({
                            type: 'POST',
                            url: `${baseUrl}/upload/GaPlan`,
                            data: formData,
                            processData: false,
                            contentType: false,
                            success: function(response) {
                                resolve(response);
                            },
                            error: function(xhr, status, error) {
                                reject(new Error(
                                    `Error ${xhr.status}: ${xhr.statusText}`));
                            }
                        });
                    })
                    .catch(error => {
                        reject(new Error(`Failed to fetch image: ${error.message}`));
                    });
            });
        }

        // window.convertToImage = async function() {

        //     $(".dashboard-spinner").show();
        //     const existingFilePath = document.getElementById('existingFilePath').value;

        //     const pdfFile = document.getElementById('pdfFile').files[0];
           

        //     const fileReader = new FileReader();
            
        //     fileReader.onload = async function() {
        //         const pdfData = new Uint8Array(this.result);
        //         const pdf = await pdfjsLib.getDocument('http://127.0.0.1:8001/uploads/shipsVscp/8/1732610841_gaplan.pdf').promise;

        //         for (let i = 1; i <= pdf.numPages; i++) {
        //             const page = await pdf.getPage(i);
        //             const viewport = page.getViewport({
        //                 scale: 1
        //             });


        //             const canvas = document.createElement('canvas');
        //             const context = canvas.getContext('2d');
        //             canvas.width = viewport.width;
        //             canvas.height = viewport.height;
        //             $(".dashboard-spinner").show();

        //             await page.render({
        //                 canvasContext: context,
        //                 viewport
        //             }).promise;
        //             const imageData = canvas.toDataURL('image/png');
        //             const img = document.createElement('img');
        //             img.src = imageData;
        //             img.classList.add('pdf-image'); // Add a class to the image

        //             const container = document.getElementById('img-container');
        //             var pdfContainer = document.createElement('div');
        //             pdfContainer.id = 'pdfContainer' + i; // Set the ID for the new div
        //             pdfContainer.className = 'pdfContainer'; // Set the class for the new div
        //             container.appendChild(pdfContainer);
                   
        //             pdfContainer.appendChild(img);
        //             img.onload = function() {
        //                 var options = {
        //                     currentPage: i,
        //                     deleteMethod: 'doubleClick',
        //                     handles: true,
        //                     area: {
        //                         strokeStyle: 'green',
        //                         lineWidth: 2
        //                     },
        //                     onSelectEnd: function(image, selection) {
        //                         console.log("Selection End:", selection);
        //                     },
        //                     initAreas: []
        //                 };
        //                 $(this).areaSelect(options);
        //             };
        //             $(".dashboard-spinner").hide();
        //         }


        //     };
        //     fileReader.readAsArrayBuffer(pdfFile);
        //     $('#pdfModal').modal('show');
        // }
        // async function convertToImage() {
        //     $(".dashboard-spinner").show();
        
        //     const pdfFileInput = document.getElementById('pdfFile').files[0]; // Get selected file from input
        //     const fileReader = new FileReader();
        //     fileReader.onload = async function() {
        //         const pdfData = new Uint8Array(this.result);
        //         const pdf = await pdfjsLib.getDocument({
        //             data: pdfData
        //         }).promise;

        //         for (let i = 1; i <= pdf.numPages; i++) {
        //             const page = await pdf.getPage(i);
        //             const viewport = page.getViewport({
        //                 scale: 1
        //             });


        //             const canvas = document.createElement('canvas');
        //             const context = canvas.getContext('2d');
        //             canvas.width = viewport.width;
        //             canvas.height = viewport.height;
        //             $(".dashboard-spinner").show();

        //             await page.render({
        //                 canvasContext: context,
        //                 viewport
        //             }).promise;
        //             const imageData = canvas.toDataURL('image/png');
        //             const img = document.createElement('img');
        //             img.src = imageData;
        //             img.classList.add('pdf-image'); // Add a class to the image

        //             const container = document.getElementById('img-container');
        //             var pdfContainer = document.createElement('div');
        //             pdfContainer.id = 'pdfContainer' + i; // Set the ID for the new div
        //             pdfContainer.className = 'pdfContainer'; // Set the class for the new div
        //             container.appendChild(pdfContainer);
        //             // if(i == 1) {
        //             // } else {
        //             //     container.appendChild(pdfContainer).style="display:none";
        //             // }
        //             pdfContainer.appendChild(img);
        //             img.onload = function() {
        //                 var options = {
        //                     currentPage: i,
        //                     deleteMethod: 'doubleClick',
        //                     handles: true,
        //                     area: {
        //                         strokeStyle: 'green',
        //                         lineWidth: 2
        //                     },
        //                     onSelectEnd: function(image, selection) {
        //                         console.log("Selection End:", selection);
        //                     },
        //                     initAreas: []
        //                 };
        //                 $(this).areaSelect(options);
        //             };
        //             $(".dashboard-spinner").hide();
        //         }

        //         // Bind event listeners after images are loaded
        //         // $('.pdf-image').on('load', function() {
        //         //     var options = {
        //         //         deleteMethod: 'doubleClick',
        //         //         handles: true,
        //         //         area: {
        //         //             strokeStyle: 'green',
        //         //             lineWidth: 2
        //         //         },

        //         //         onSelectEnd: function(image, selection) {
        //         //             console.log("Selection End:", selection);
        //         //         },
        //         //         initAreas: []
        //         //     };
        //         //     $(this).areaSelect(options);
        //         // });
        //     };
        //     fileReader.readAsArrayBuffer(pdfFile);
        
        //     // Check if a file is selected from input
        
        //         $(".dashboard-spinner").hide();
        //         $('#pdfModal').modal('show');
            
        // }
        
        async function convertToImage() {
            $(".dashboard-spinner").show();

            const pdfFile = document.getElementById('pdfFile').files[0];
            if (!pdfFile) {
                alert('Please select a PDF file.');
                return;
            }

            const fileReader = new FileReader();
            fileReader.onload = async function() {
                const pdfData = new Uint8Array(this.result);
                const pdf = await pdfjsLib.getDocument({
                    data: pdfData
                }).promise;

                for (let i = 1; i <= pdf.numPages; i++) {
                    const page = await pdf.getPage(i);
                    const viewport = page.getViewport({
                        scale: 1
                    });


                    const canvas = document.createElement('canvas');
                    const context = canvas.getContext('2d');
                    canvas.width = viewport.width;
                    canvas.height = viewport.height;
                    $(".dashboard-spinner").show();

                    await page.render({
                        canvasContext: context,
                        viewport
                    }).promise;
                    const imageData = canvas.toDataURL('image/png');
                    const img = document.createElement('img');
                    img.src = imageData;
                    img.classList.add('pdf-image'); // Add a class to the image

                    const container = document.getElementById('img-container');
                    var pdfContainer = document.createElement('div');
                    pdfContainer.id = 'pdfContainer' + i; // Set the ID for the new div
                    pdfContainer.className = 'pdfContainer'; // Set the class for the new div
                    container.appendChild(pdfContainer);
                   
                    pdfContainer.appendChild(img);
                    img.onload = function() {
                        var options = {
                            currentPage: i,
                            deleteMethod: 'doubleClick',
                            handles: true,
                            area: {
                                strokeStyle: 'green',
                                lineWidth: 2
                            },
                            onSelectEnd: function(image, selection) {
                                console.log("Selection End:", selection);
                            },
                            initAreas: []
                        };
                        $(this).areaSelect(options);
                    };
                    $(".dashboard-spinner").hide();
                }


            };
            fileReader.readAsArrayBuffer(pdfFile);
            $('#pdfModal').modal('show');
        }

        
        $('#pdfModal').on('hidden.bs.modal', function() {
            $("#img-container").empty();
            $(".pdf-image").empty();
        });

        $('#pdfFile').change(function() {
            convertToImage();
        });
        if (window.location.hash) {
            // Use the hash to find the section
            var target = $(window.location.hash);
            var subsection = window.location.href.split("#").pop();
            var section = '';
            if (subsection == 'po-records' || subsection == 'onbaord-training') {
                section = "ihm_maintenance";
            }
            if(subsection == 'check_list'){
                console.log("hh");
                section ="check_list";

            }

            // Scroll to the section smoothly
            if (target.length) {
                $('.aside-nav .nav li').removeClass('active');
                $(`.${section}`).parent('li').addClass('active');
                $('.main-content').hide();
                $(`#${section}`).show();
                let targetId = $(this).attr('href');
                $(`#${subsection}`).addClass('show');


                $(targetId).show();

                $('html, body').animate({
                    scrollTop: target.offset().top
                }, 1000);
            }
        }
        const url = window.location.href;

        const segments = url.split('/');
        const projectId = segments[segments.length - 1];
        let sidebar = $("#mainSidebar");
        let isSidebarVisible = true;

        if ($(window).width() >= 768) {
            $("#sidebarCollapse").show();
            $("#sidebarCollapse").find('span').css({
                "height": "1em",
                "width": "1em"
            });
        } else {
            $("#sidebarCollapse").hide();
        }

        $(document).on("click", "#sidebarCollapse", function() {
            if ($(window).width() >= 768) {
                if (isSidebarVisible) {
                    sidebar.css("left", "-188px"); //250
                    $('#page-aside').css("left", "78px"); //8
                    $('.dashboard-wrapper').css("margin-left", "78px"); //8
                } else {
                    sidebar.css("left", "0");
                    $('#page-aside').css("left", "265px");
                    $('.dashboard-wrapper').css("margin-left", "264px");
                }
                isSidebarVisible = !isSidebarVisible;
            }
        });





        $('.aside-nav .nav li a').click(function() {
            $('.aside-nav .nav li').removeClass('active');
            $(this).parent('li').addClass('active');
            $('.main-content').hide();

            let targetId = $(this).attr('href');

            $(targetId).show();

            return false;
        });

        $('.aside-nav .nav li a[href="#assign_project"]').click(function() {
            $('.main-content').hide();
            $('#assign_project').show();
            return false;
        });

        setTimeout(function() {
            $('.alert-success').fadeOut();
        }, 15000);






    });

    function triggerFileInput(inputId) {
        $(`#${inputId}`).val('');
        document.getElementById(inputId).click();
        $(".dashboard-spinner").show();
    }
    $(document).on('click', '.deckImgDeleteBtn', function(event) {
        event.preventDefault();
        let deckId = $(this).data('id');
        let deleteUrl = `${baseUrl}/ship/deleteDeck/${deckId}`
        let confirmMsg = "Are you sure you want to delete this deck?";

        confirmDelete(deleteUrl, confirmMsg, function(response) {
            // Success callback
            $('.deckView').html();
            $('.deckView').html(response.html);
        });
    });
    $(document).on('click', '.deckImgEditBtn', function() {
        let deckId = $(this).data('id');
        let deckName = $(`#deckTitle_${deckId}`).text();
        $("#deckEditFormId").val(deckId);
        $("#name").val(deckName);
        $("#deckEditFormModal").modal('show');
    });
    $('#deckEditForm').submit(function(event) {
        event.preventDefault();

        let formData = $(this).serialize();

        let form = $(this);
        let action = $(this).attr('action');
        $.ajax({
            type: 'POST',
            url: action,
            data: formData,
            success: function(response) {
                let deckData = response.deck;
               
                if (response.isStatus) {
                    successMsg(response.message);
                    $(`#deckTitle_${deckData.id}`).text(deckData.name);
                    form.trigger('reset');
                    $("#deckEditFormModal").modal('hide');
                } else {
                    errorMsg(response.message);
                }
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    });
