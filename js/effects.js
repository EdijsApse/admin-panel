$(document).ready(function(){
    $(".send_message").click(function(){
        $(".send_message_container").fadeIn("fast");
    })
    $(".cancel").click(function(){
        $(".send_message_container").fadeOut("fast");
    })
    $(".sent_message").click(function(){
        $(".sent_message_container").fadeIn("fast");
    })
    $(".close_sent_messages").click(function(){
        $(".sent_message_container").fadeOut("fast");
    })
})