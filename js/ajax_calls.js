$(document).ready(function(){
    $("button[name='confirm_changes']").click(function(){
        var user_id = $("input[name='user_id']").val();
            name_field = $("input[name='new_name']").val(),
            email_field = $("input[name='new_email']").val(),
            role_field = $("select[name='new_role']").val(),
            password_field = $("input[name='new_password']").val(),
            confirm_password_field = $("input[name='confirm_password']").val();
        $.ajax({
            method:"POST",
            url:"ajax_requests.php",
            data:{
                purpose:"change_user",
                user_id:user_id,
                new_name:name_field,
                new_email:email_field,
                new_role:role_field,
                new_password:password_field,
                new_password_confirm:confirm_password_field,
            },
            error:function(xhr){
                $(".notification > .message_container").html(xhr.responseText);
                $(".notification").fadeIn("fast");
                add_close_event();
            },
            success:function(xhr){
            },
            complete:function(xhr){
                $(".notification > .message_container").html(xhr.responseText);
                $(".notification").fadeIn("fast");
                add_close_event();
            }
        })
    })
    $("button[name='delete_user']").click(function(){
        var user_id = $("input[name='user_id']").val();
        $.ajax({
            method:"POST",
            url:"ajax_requests.php",
            data:{
                purpose:"delete_user",
                user_id:user_id,
            },
            error:function(xhr){
                $(".notification > .message_container").html(xhr.responseText);
                $(".notification").fadeIn("fast");
                add_close_event();
            },
            success:function(xhr){
            },
            complete:function(xhr){
                $(".notification > .message_container").html(xhr.responseText);
                $(".notification").fadeIn("fast");
                add_close_event();
            }
        })
    })
    $("button[name='registrate']").click(function(){
        var user_name = $("#user_name").val(),
            user_email = $("#email").val(),
            user_password = $("#password").val();
        $.ajax({
            method:"POST",
            url:"ajax_requests.php",
            data:{
                purpose:"registrate",
                user_name:user_name,
                user_email:user_email,
                user_password:user_password
            },
            error:function(xhr){
                $(".notification > .message_container").html(xhr.responseText);
                $(".notification").fadeIn("fast");
                add_close_event();
            },
            success:function(xhr){
            },
            complete:function(xhr){
                $(".notification > .message_container").html(xhr.responseText);
                $(".notification").fadeIn("fast");
                add_close_event();
            }
        })
    })
    $("input[name='search_user']").keyup(function(e){
        var user_input = $(this).val(),
            presed_key = e.which;
        console.log(presed_key);
        if(user_input == ""){
            user_input = " ";
        }
        if(presed_key == 8 || presed_key == 46){
            //e.preventDefault();//Kas notiek ja tiek dzēsta ievades laukā esošā vērtība
        }
        $.ajax({
            method:"POST",
            url:"ajax_requests.php",
            data:{
                purpose:"get_users",
                user_name:user_input
            },
            error:function(){

            },
            success:function(xhr){
            },
            complete:function(xhr){
                var users,
                    display_user = false;
                try{
                    users = JSON.parse(xhr.responseText);
                    display_user = true;
                }
                catch(errors){
                    $(".retrieved_users").html(xhr.responseText);
                }
                if(display_user == true){
                    $(".retrieved_users").html("");
                    for(var i=0; i < users.length; i++){
                        dsiplay_user(users[i]);
                    }
                }
            }
        })
    })
})
function add_close_event(){
    $(".close").click(function(){
        var messages = $(".message_container");
        if(messages.length >= 1){
            $(".notification").fadeOut("fast");
        }
        else{
            $(this).parent(".message_container").fadeOut("fast");    
        }
    })
}
function dsiplay_user(user_object){
    var user_container = document.createElement("div"),
        user_name = document.createElement("p"),
        user_image = document.createElement("img");
        $(user_container).addClass("user");
        $(user_name).text(user_object.usr_name);
        $(user_image).attr("src",user_object.usr_image);
        $(user_container).append(user_image, user_name);
        $(".retrieved_users").prepend(user_container);
}