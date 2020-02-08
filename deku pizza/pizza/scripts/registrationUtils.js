$(document).ready( function() {
    fadeInOverlay();
    addEnterListener();
    $("#pwd, #pwd_ok").keyup(validatePwd);
});

function validatePwd() {
    var pw = document.getElementById("pwd").value;
    if(pw.length > 7) {
        if(pw == document.getElementById("pwd_ok").value) {
            $(".fa.fa-check").css("display","inline");
        } else {
            $(".fa.fa-check").css("display","none");
        }
    } else {
        $(".fa.fa-check").css("display","none");
    }
};

function fadeInOverlay() {
    $(".bg_overlay").fadeIn("fast").promise().done(fadeInLoginCard());
};

function fadeInLoginCard() {
    $("#signUpCard").fadeIn("slow");
};

function addEnterListener() {
    var inputs = document.getElementsByTagName("input");
    for (var i = 0; i < inputs.length; i++) {
        inputs[i].addEventListener("keyup", function(event) {
            event.preventDefault();
            if(event.keyCode === 13)
            document.getElementById("submit").click();
        });
    };
};
