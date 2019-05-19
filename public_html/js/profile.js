var register_user_div = $("#register_user_div");
var upload_blueprint_div = $("#upload_blueprint_div");
var user_info_div = $("#user_info_div");

$("#register_user").click(function() {
    upload_blueprint_div.slideUp();
    user_info_div.slideUp();
    register_user_div.slideDown();
});

$("#upload_blueprint").click(function() {
    register_user_div.slideUp();
    user_info_div.slideUp();
    upload_blueprint_div.slideDown();
});

$("#user_info").click(function() {
    upload_blueprint_div.slideUp();
    register_user_div.slideUp();
    user_info_div.slideDown();
});