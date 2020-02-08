//this makes the document safe for non-javascript users. if javascript is disabled, i don't add the css display:none
//to the elements that needs fadeIn, hence i don't break the site for who does not have javascript support
$(document).ready(function () {
    $(".toHide").css("display","none");
})
