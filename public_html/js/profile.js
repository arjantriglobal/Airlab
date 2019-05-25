var register_user_div = $("#register_user_div");
var user_info_div = $("#user_info_div");

$("#register_user").click(function() {
    user_info_div.slideUp();
    register_user_div.slideDown();
});

$("#user_info").click(function() {
    register_user_div.slideUp();
    user_info_div.slideDown();
});