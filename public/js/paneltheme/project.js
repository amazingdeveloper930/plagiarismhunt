var BASE_URL = $("#base_url").val();
jQuery.fn.sortElements = (function() {

    var sort = [].sort;

    return function(comparator, getSortable) {

        getSortable = getSortable || function() { return this; };

        var placements = this.map(function() {

            var sortElement = getSortable.call(this),
                parentNode = sortElement.parentNode,

                // Since the element itself will change position, we have
                // to have some way of storing its original position in
                // the DOM. The easiest way is to have a 'flag' node:
                nextSibling = parentNode.insertBefore(
                    document.createTextNode(''),
                    sortElement.nextSibling
                );

            return function() {

                if (parentNode === this) {
                    throw new Error(
                        "You can't sort elements if any one is a descendant of another."
                    );
                }

                // Insert before flag:
                parentNode.insertBefore(this, nextSibling);
                // Remove flag:
                parentNode.removeChild(nextSibling);

            };

        });

        return sort.call(this, comparator).each(function(i) {
            placements[i].call(getSortable.call(this));
        });

    };

})();


$(document).ready(function() {


    function toggleFullScreen() {
        if ((document.fullScreenElement && document.fullScreenElement !== null) ||
            (!document.mozFullScreen && !document.webkitIsFullScreen)) {
            if (document.documentElement.requestFullScreen) {
                document.documentElement.requestFullScreen();
            } else if (document.documentElement.mozRequestFullScreen) {
                document.documentElement.mozRequestFullScreen();
            } else if (document.documentElement.webkitRequestFullScreen) {
                document.documentElement.webkitRequestFullScreen(Element.ALLOW_KEYBOARD_INPUT);
            }
        } else {
            if (document.cancelFullScreen) {
                document.cancelFullScreen();
            } else if (document.mozCancelFullScreen) {
                document.mozCancelFullScreen();
            } else if (document.webkitCancelFullScreen) {
                document.webkitCancelFullScreen();
            }
        }
    }

    function sw_simple_alert(type, message) {
        Swal.fire({
            type: type,
            title: message,
            showConfirmButton: true,
        });
    }

    $("#upload-button").click(function() {
        $("#file-input").trigger('click');
    });

    $("#upload-form").on('change', '#file-input', function() {
        if ($('#file-input').val() != "") {
            $("#upload-button").prop('disabled', true);
            var request = new XMLHttpRequest();
            var formdata = new FormData(document.getElementById('upload-form'));
            request.open('post', '/check_file');
            request.addEventListener("load", transferComplete);
            request.send(formdata);
        }
    });

    function transferComplete(data) {

        console.log(data.currentTarget.response);
        var responsedata = $.parseJSON(data.currentTarget.response);
        if (responsedata.status == 'success') {
            $("#upload-button").prop('disabled', false);
            var email = $("#project-email").val();
            if (email == '') {
                swal({
                    title: 'Enter your email to get check results',
                    input: 'email',
                    inputPlaceholder: 'Example@email.xxx',
                    showCancelButton: true,
                    confirmButtonText: 'Submit',
                    showLoaderOnConfirm: true,
                    preConfirm: (email) => {
                        return fetch('/set-email/email/' + email + '/token/' + responsedata.token)
                            .then(response => {
                                if (response.status == 'error') {
                                    throw new Error(response.error_code)
                                }
                                return response.json()
                            })
                            .catch(error => {
                                sw_simple_alert('error', 'Network Error!');
                            })
                    },
                    allowOutsideClick: () => !Swal.isLoading()
                }).then((result) => {
                    if (result.value) {
                        // Swal.fire({
                        //     position: 'center-middle',
                        //     type: 'success',
                        //     title: 'Thanks, check your inbox now - results are sent to you',
                        //     showConfirmButton: true,

                        // })
                        location.href = result.value.url;
                    } else if (result.dismiss === Swal.DismissReason.cancel) {
                        deleteFile(responsedata.token);
                    }
                })
            } else {
                location.href = BASE_URL + "/email-set-verify/" + email + "/token/" + responsedata.token;
            }

        } else {
            sw_simple_alert('error', responsedata.error_code);
        }
    }

    $(".btn-action").click(function() {
        var vm = $(this);
        var token = vm.attr('data-process');
        var element = $(".widget_plag_good_box[data-process=" + token + "]");
        if (element == null) {
            sw_simple_alert("error", "There is no such element");
        }
        if (element.attr('data-status') == '1') {
            sw_simple_alert("error", "We are checking now.<br/> Please wait for a few minutes");
            return;
        }
        if (element.attr('data-method-isactived') == 0) {
            sw_simple_alert("error", "This check method is not available now.<br/> Comming soon!");
            return;
        }
        if (element.attr('data-status') == '0' && element.attr('data-markable') == '0') {
            Swal.fire({
                title: 'This check is locked',
                text: "To open this checker, you should unlock all checker",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Visit Payment Page'
            }).then((result) => {
                if (result.value) {
                    location.href = BASE_URL + "/payment/" + $("#project-token").val() + "/mode/1";
                }
            })
        }

        if (element.attr('data-status') == '2' && element.attr('data-detailshowable') == '0') {
            Swal.fire({
                title: 'This report is locked',
                text: "To view this report, you should open detailed report",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Visit Payment Page'
            }).then((result) => {
                if (result.value) {
                    location.href = "../payment/" + $("#project-token").val() + "/mode/2";
                }
            })
        }

    });


    $("#btn-payment-checkothers").click(function() {
        var vm = $(this);
        location.href = vm.attr('href');
    });

    $(".btn-payment-openreport").click(function() {
        var vm = $(this);
        location.href = vm.attr('href');
    });


    getProjectStatus();
    interval = window.setInterval(getProjectStatus, SECONDGAP);

});

var SECONDGAP = 20000;

var interval = null;

function getProjectStatus() {
    var project_status_url = $("#project-status-url").val();
    var do_analysis_url = $('#do-analysis-url').val();
    $.ajax({
        type: 'get',
        dataType: "json",
        url: project_status_url,
        data: {
            _token: "{{ csrf_token() }}"
        },
        success: function(response) {
            if (response.status == "success") {
                var processes = response.data.processes;
                var project = response.data.project;
                var processesForChecking = [];

                for (var index = 0; index < processes.length; index++) {
                    var ele = $('.widget_plag_good_box[data-process=' + processes[index].processing_token + ']');

                    if (processes[index].status + "" == "0") {
                        if (processes[index].markable + "" == "1") {

                            if (ele.attr('data-method-isactived') != 0) {
                                processesForChecking.push(processes[index].processing_token);
                                processes[index].status = 1;
                                processes[index].mark = 0;
                            }
                        }
                    }


                    ele.attr("data-status", "" + processes[index].status);
                    ele.attr("data-markable", "" + processes[index].markable);
                    ele.attr("data-detailshowable", "" + processes[index].detailshowable);
                    ele.attr("data-mark", "" + processes[index].mark);

                    if (processes[index].status + "" == "1") {
                        $('.widget_plag_good_box[data-process=' + processes[index].processing_token + '] .status').text("processing...");
                    }
                    if (processes[index].status + "" == "2") {
                        $('.widget_plag_good_box[data-process=' + processes[index].processing_token + '] .rate').text(processes[index].mark + "%");
                    }


                }

                $('.widget_plag_good_box').sortElements(function(a, b) {

                    var contentA = parseInt($(a).attr('data-mark'));
                    var contentB = parseInt($(b).attr('data-mark'));
                    var contentA_1 = parseInt($(a).attr('data-status'));
                    var contentB_1 = parseInt($(b).attr('data-status'));
                    if (contentA_1 != 2 && contentB_1 == 2)
                        return 1;
                    if (contentA_1 == 2 && contentB_1 != 2)
                        return -1;
                    return (contentA < contentB) ? 1 : (contentA > contentB) ? -1 : 0;
                });

                if (processesForChecking.length > 0) {
                    for (var index_1 = 0; index_1 < processesForChecking.length; index_1++) {

                        var current_process_token = processesForChecking[index_1];
                        var project_token = $("#project-token").val();
                        $.ajax({
                            type: 'GET',
                            url: BASE_URL + '/project/do-analysis/' + project_token + "/" + current_process_token,

                            success: function(response1) {

                            },
                            error: function(jqXhr1, textStatus1, errorThrown1) {
                                var error_ele = $('.widget_plag_good_box[data-process=' + current_process_token + ']');
                                error_ele.attr("data-status", "3");
                                error_ele.attr("data-mark", "0");
                            }
                        });
                    }
                }


            } else if (response.status == "error") {
                Swal.fire({
                        position: 'center-middle',
                        type: 'error',
                        title: 'Error',
                        text: response.error_code,
                        showConfirmButton: false,
                        timer: 1500
                    })
                    // if(interval != null)
                    // {
                    //   clearInterval(interval);
                    // }
            }
        },
        error: function(jqXhr, textStatus, errorThrown) {
            Swal.fire({
                position: 'center-middle',
                type: 'error',
                title: 'Network Error!',
                showConfirmButton: false,
                timer: 1500
            })
        }
    });


}