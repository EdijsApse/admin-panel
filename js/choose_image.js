$(document).ready(function() {
    $("#file_upload").change(function(event){//If Input value changes
        var tempPath = URL.createObjectURL(event.target.files[0]);//Temporary file path
        $("#profile_image").fadeOut("fast", function(){//selecting image
			$(this).attr("src", tempPath);//no need for siblings(), because this = $(#fileUpload).siblings(img)
			$(this).fadeIn("fast");	
		});
	});
});