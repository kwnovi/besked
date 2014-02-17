
			            
			$(document).ready(function(){
			   var height = window.innerHeight - $("#B1").outerHeight(true);
			   $("#B2").css("max-height", height + 'px');

			   var Theight = window.innerHeight ;
			   $("#B4").css("max-height", Theight + 'px');

			   	var secondHeight = window.innerHeight - $("#prof").outerHeight(true) - $('#chatbar').outerHeight(true);
			   	$("#conver").css("height", secondHeight + 'px');
			   
			});


			function showContact() {
				$("#contact-list").show();
				$("#msg-list").hide();

			}

			function showMsg() {
				$("#msg-list").show();
				$("#contact-list").hide();
			}


