import $ from 'jquery';
import 'bootstrap/dist/js/bootstrap.bundle.min'
import '../styles/app.scss';

require('@fortawesome/fontawesome-free/css/all.min.css');
require('@fortawesome/fontawesome-free/js/all.js');

// ===== TCHAT ===== //

let textarea = $("#modalMessageTextarea");

$(".open-modal-send-message").each(function(button) {
    $(this).on("click", function() {
        textarea.attr('data-message', $(this).data('message'));
    })
})

$("#modalMessageSend").on("click", function () {
    let message = textarea.val()
    if (message !== "") {
        let url = process.env.LOCAL_HOST + "/api/message";
        let data = {
            message: message,
            type : textarea.data('message')
        }
        fetch(url , {
            method: "POST",
            cache:"no-cache",
            credentials: "same-origin",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify(data)
        })
            .then(response => response.json())
            .then(data => {
                if(data.status === "success") {
                    location.reload();
                }else {
                    //manage error
                }

            })
            .catch((error) => {
                console.error('Error:', error);
            });
    }
    textarea.val('');
    $("#modalMessage").modal("hide");
})

// xxxxx TCHAT xxxxx //




