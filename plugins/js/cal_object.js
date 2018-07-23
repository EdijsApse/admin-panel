function calendar_object(){
	this.date_now = new Date();//Main Date
	this.current_day = this.date_now.getDay();//Gets current day (0 - 6)
	//this.current_day most be static, so thats why i dont define it as function with return value
	this.month_notations = ["Janvāris","Februāris","Marts","Aprīlis","Maijs", "Jūnijs", "Jūlijs", "Augusts","Septembris","Oktobris","Novembris","Decembris"];//Month names
	this.day_notations = ["P","O","T","C","Pk","S","Sv"];//Day names
	this.get_year = function(){
		return this.date_now.getFullYear();
	}
	//No need to make set_year function, JS is smart enough to update year automatically :))
	this.get_month = function(){//Need to be as function, otherwise this.date_now month is not updating
		return this.date_now.getMonth();//Return month from core date
	}
	this.set_month = function(month){//Set month to this.date_now
		var current_month = this.get_month(),
			new_month;
		new_month = current_month + month;// + 1 || - 1 from current month
		this.date_now.setMonth(new_month);//Sets this.date_now month
	}
	this.get_month_first_day = function(){
		var temp_date = new Date();//Temp date so we dont change this.date_now, which we will need to get current date from
		temp_date.setFullYear(this.get_year(), this.get_month(), 1);
		return temp_date.getDay();//Returns 0-6 (0 = Sunday, 1 = Monday ......)
	}
	this.get_all_month_days = function(){//Will return number = how many days are in this.date_now month
		var temp_date = new Date();
		temp_date.setFullYear(this.get_year(), this.get_month() + 1, 0);
		// +1 to this.date_now month because 0(date) means that JS will get prev months last date(possible day 30,31...)
		return temp_date.getDate();
	}
	this.get_month_last_day = function(){//Returns this.date_now months last day (0-6)
		var temp_date = new Date();
		temp_date.setFullYear(this.get_year(), this.get_month(), this.get_all_month_days());
		return temp_date.getDay();
	}
	this.get_first_week_empty_days = function(){//return how many empety days are in 1st week
		var first_day = this.get_month_first_day(),
		empty_days = 0;//How many empty days are in first week
		if(first_day == 0){
			first_day = 7;//Sunday
		}
		//If months first day is 3(Wednesday), loop will work 2 times
		//i=1 so day where is 1st date wont count as empty day
		for(var i=1; i < first_day; i++){
			empty_days++;
		}
		return empty_days;			
	}
	this.get_last_week_empty_days = function(){//return how many empety days are in last week
		var last_day = this.get_month_last_day(),
		empty_days = 7;//7 = days in week
		if(last_day == 0){//If Sunday
			empty_days = 0;
		}
		else{
			empty_days = empty_days - last_day;//Divide 7 by last day and we get how many empty days are in last week
		}
		return empty_days;			
	}
	this.get_full_weeks = function(){//Return how many weeks are in month (In array)
		var all_empty_days = this.get_first_week_empty_days() + this.get_last_week_empty_days(),
			all_full_days = this.get_all_month_days(),
			all_days,
			week_array = [],//Will need for AngularJS ng-repeat
			full_weeks;
			all_days = all_empty_days + all_full_days;
			full_weeks = all_days / 7;
			for (var i = 0; i < full_weeks; i++){
				week_array.push(i+1);//Wont start from 0
			}
			return week_array;
	}
	this.get_month_days_array = function(){//Returns one big array which contains empty days and real days
		var first_empty_days = this.get_first_week_empty_days(),
			full_days = this.get_all_month_days(),
			last_empty_days = this.get_last_week_empty_days(),
			date = 1,//Manualy will count days
			calendar_array = [];
			for(var i = 0; i < first_empty_days; i++){
				calendar_array.push("");//Push 1st weeks empty days into array
			}
			for(var j = 0; j < full_days; j++){
				calendar_array.push(date);//Push real dates into array
				date++;
			}
			for(var k = 0; k < last_empty_days; k++){
				calendar_array.push("");
			}
			return calendar_array;
	}
	//I will create draw_calendar function which will create object for AngularJS, because i will use AngularJS ng-repeat to 'draw' calendar from object, but you can use pure JS to 'draw' calendar based on object which this method will return
	this.draw_calendar = function(){
		var weeks = this.get_full_weeks(),
			days = this.get_month_days_array(),
			events = this.get_events(),//events is used to call only function, function doesnt return anything
			calendar_array_for_drawing = [];
		for(var i = 0; i < weeks.length; i++){
			var week = {};
			week.id = i+1;
			week.days = [];
			for (var j = 0; j < 7; j++){
				week.days.push(days[j]);
			}
			days.splice(0, 7);//Splice first week (Remove from array so we can push next 7 days)
			calendar_array_for_drawing.push(week);
		}
		return calendar_array_for_drawing;
	}
	this.get_events = function(){
		var month = this.get_month() + 1,//+1 Cuz JS getMonth() 0-11
			year = this.get_year();
			month = converter(month.toString());
		$(".event").css("visibility","hidden");
		$.ajax({
			method:"POST",
			url:"plugins/get_events.php",
			data:{
				event_month:month,
				event_year:year
			},
			success: function(){
				
			},
			error: function(){
				
			},
			complete: function(xhr){
				var ajax_response,
					days = $(".day"),
					events = false;//No events by default
				try{
					ajax_response = JSON.parse(xhr.responseText);//If JS can parse response, it means there is events, so
					events = true;//Events is true
				}
				catch(err){
					console.log(xhr.responseText);
				}
				if(events == true){
					$(days).each(function(index, element) {//For Each Day (td in table)
						var day = $(element).text(),
							day_splited_arr;
						if(day.length == 1 && day != ""){
							day = '0' + day;//need to add 0 in front, cuz in db dates start with 0
						}
						for(var i = 0; i < ajax_response.length; i++){//For each event in month
							event_day = ajax_response[i].usr_regdate;//Gets lesson date
							day_splited_arr = event_day.split("-");//Splits it
							if(day_splited_arr[2] == day){//Compare to table cell(date)
								$(element).siblings(".event").css("visibility","visible");
								$(element).parent().css("box-shadow","0px 0px 2px 1px #fc3f45");
							}
						}
					});
				}
				else{
					console.log("No Events");
				}
				$("#loading-container").fadeOut("fast", add_effects());//Adding mouse hover effects, otherwise when changing months, effects disappear
			}
		});
	}
	this.get_day_event = function(selected_day){
		//Without .toString(), js .length propertie isnt working
		var date = converter(selected_day.toString()),
			month = this.get_month()+1,
			year = this.get_year();
			month = converter(month.toString());
		$.ajax({
			method:"POST",
			url:"ajax_requests.php",
			data:{
				purpose:"day_event",
				correct_date:year + "-" + month + "-" + date
			},
			success: function(){
				
			},
			error: function(){
				
			},
			complete: function(xhr){
				var user_arr,
					exit_script = false;
				try{
					user_arr = JSON.parse(xhr.responseText);
				}
				catch(errors){
					$(".notification > .message_container").html(xhr.responseText);
                	$(".notification").fadeIn("fast");
					add_close_event();
					exit_script = true;
				}
				if(exit_script != true){
					for(var i=0; i<user_arr.length; i++){
						var user = document.createElement("div"),
							image_container = document.createElement("div"),
							image = document.createElement("img"),
							user_detail = document.createElement("div"),
							name = document.createElement("p"),
							role = document.createElement("p");
							$(image_container).addClass("user_image");
							$(image).attr("src",user_arr[i].usr_image);
							$(user_detail).addClass("user_details");
							$(name).html(user_arr[i].usr_name);
							$(role).html(user_arr[i].role_name);
							$(user_detail).append(name,role);
							$(image_container).append(image);
							$(user).addClass("user");
							$(user).append(image_container).append(user_detail);
							$(".days_registered_users").append(user);
					}
					$(".event_container").fadeIn("fast");
					$(".event_container").click(function(){
						$(".days_registered_users > .user").remove();
						$(this).fadeOut();
					});
				}
			}
		});
	}
}
function converter(number){//Adds 0 in front of number if needed (FOR database Only)
	var date = number;
	if(date.length == 1){
		date = '0' + date;
	}
	return date;
}