function successMsgWithRedirect(message, redirectURL) {
    swal({
        title: "Success",
        text: message,
        type: "success",
        confirmButtonColor: '#3085d6',
        timer: 5000
    }, function () {
        redirectPage(redirectURL);
    });
}

function errorMsgWithRedirect(message, redirectURL) {
    swal({
        title: "Error",
        text: message,
        type: "error",
        confirmButtonColor: '#3085d6',
        timer: 5000
    }, function () {
        redirectPage(redirectURL);
    });
}

function redirectPage(redirectURL) {
    window.location.href = redirectURL; // Replace with your target URL
}

function successMsg(message) {
    swal({
        title: "Success",
        text: message,
        type: "success",
        confirmButtonColor: '#3085d6',
        timer: 5000
    });
}

function errorMsg(message, title = "Error") {
    swal({
        title: title,
        text: message,
        type: "error",
        confirmButtonColor: '#3085d6',
        timer: 5000
    });
}
// 004f47
function confirmDeleteMethod(deleteUrl, confirmMsg, successCallback, errorCallback){
    var csrfToken = "{{ csrf_token() }}";
    swal({
        title: "Are you sure?",
        text: confirmMsg,
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#FD2900",
        cancelButtonColor: "#004f47",
        confirmButtonText: "Yes, delete it!",
        cancelButtonText: "Cancel",
        closeOnConfirm: false
    }, function (isConfirm) {
        if (isConfirm) {
            $.ajax({
                url: deleteUrl,
                method: 'DELETE',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},

                success: function (response) {
                    if (response.isStatus) {
                        swal("Deleted!", `${response.message}`, "success");
                        if (successCallback) {
                            successCallback(response);
                        }
                    } else {
                        swal("Unable to Delete!", `${response.message}`, "error");
                        if (errorCallback) {
                            errorCallback(response);
                        }
                    }
                },
                error: function (xhr, status, error) {
                    console.log("Error deleting record: " + error);
                    if (errorCallback) {
                        errorCallback({ message: error });
                    }
                }
            });
        }
    });
}

function confirmDelete(deleteUrl, confirmMsg, successCallback, errorCallback) {
    swal({
        title: "Are you sure?",
        text: confirmMsg,
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#FD2900",
        cancelButtonColor: "#004f47",
        confirmButtonText: "Yes, delete it!",
        cancelButtonText: "Cancel",
        closeOnConfirm: false
    }, function (isConfirm) {
        if (isConfirm) {
            $.ajax({
                url: deleteUrl,
                method: 'GET',
                success: function (response) {
                    if (response.isStatus) {
                        swal("Deleted!", `${response.message}`, "success");
                        if (successCallback) {
                            successCallback(response);
                        }
                    } else {
                        swal("Unable to Delete!", `${response.message}`, "error");
                        if (errorCallback) {
                            errorCallback(response);
                        }
                    }
                },
                error: function (xhr, status, error) {
                    console.log("Error deleting record: " + error);
                    if (errorCallback) {
                        errorCallback({ message: error });
                    }
                }
            });
        }
    });
}

function confirmDeleteWithElseIf(deleteUrl, confirmMsg, method=null,successCallback, errorCallback) {
    if(method == null){
        method = 'GET';
    }
    swal({
        title: "Are you sure?",
        text: confirmMsg,
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#FD2900",
        cancelButtonColor: "#004f47",
        confirmButtonText: "Yes, delete it!",
        cancelButtonText: "Cancel",
        closeOnConfirm: false
    }, function (isConfirm) {
        if (isConfirm) {
            $.ajax({
                url: deleteUrl,
                method: method,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Add CSRF token
                },
                success: function (response) {
                    if (response.isStatus) {
                        swal("Deleted!", `${response.message}`, "success");
                        if (successCallback) {
                            successCallback(response);
                        }
                    } else {
                        swal("Unable to Delete!", `${response.message}`, "error");
                        if (errorCallback) {
                            errorCallback(response);
                        }
                    }
                },
                error: function (xhr, status, error) {
                    console.log("Error deleting record: " + error);
                    if (errorCallback) {
                        errorCallback({ message: error });
                    }
                }
            });
        }
    });
}

