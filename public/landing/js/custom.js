// JavaScript Document
jQuery('#custom-owl').owlCarousel({
    loop: true,
    margin: 10,
    nav: true,
    responsive: {
        0: {
            items: 1
        },
        600: {
            items: 1
        },
        1000: {
            items: 1
        }
    }
});


// plugins

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

// customize



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

function deleteFile(project_token) {
    $.ajax({
        type: "GET",
        dataType: "json",
        url: '/deletefile/' + project_token,
        success: function(response) {

        }
    })
}

function transferComplete(data) {

    console.log(data.currentTarget.response);
    var responsedata = $.parseJSON(data.currentTarget.response);
    if (responsedata.status == 'success') {
        $("#upload-button").prop('disabled', false);

        swal({
            title: 'Enter your email to get check results',
            input: 'email',
            inputPlaceholder: 'Example@email.xxx',
            showCancelButton: true,
            confirmButtonText: 'Submit',
            showLoaderOnConfirm: true,
            preConfirm: (email) => {
                return fetch(`/set-email/email/${email}/token/${responsedata.token}`)
                    .then(response => {
                        if (response.status == 'error') {
                            throw new Error(response.error_code)
                        }
                        return response.json()
                    })
                    .catch(error => {
                        Swal.showValidationMessage(
                            `Request failed: ${error}`
                        )
                    })
            },
            allowOutsideClick: () => !Swal.isLoading()
        }).then((result) => {
            if (result.value) {
                // Swal.fire({
                //   position: 'center-middle',
                //   type: 'success',
                //   title: 'Thanks, check your inbox now - results are sent to you',
                //   showConfirmButton: true,

                // })
                location.href = result.value.url;
            } else if (result.dismiss === Swal.DismissReason.cancel) {
                debugger;
                deleteFile(responsedata.token);
            }
        })

    }
}
$("#check-text-btn").on('click', function() {
    var text = $("#exampleFormControlTextarea1").val();
    if (text == '') {
        sw_simple_alert('warning', 'Please enter the text.');
        return;
    }
    if (text.length < 50) {
        sw_simple_alert('warning', 'Text length is too short.<br/>It should be at least 50');
        return;
    }
    $('.file-upload-content').submit();
});

function textCounter(e, t, n) {
    var u = document.getElementById(t);
    if (e.value.length > n)
        return e.value = e.value.substring(0, n), !1;
    u.innerText = n - e.value.length + " characters left"
}

window.onscroll = function() { scrollFunction() };

function scrollFunction() {
    if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
        document.getElementById("to-top").style.display = "block";
    } else {
        document.getElementById("to-top").style.display = "none";
    }
}

// When the user clicks on the button, scroll to the top of the document
function topFunction() {
    document.body.scrollTop = 0;
    document.documentElement.scrollTop = 0;
}