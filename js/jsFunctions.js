function userRegistration(form, fname, lname, username, email, password, password2 )
			{
			//var fname =$("#fname").val();
			//var lname =$("#lname").val();
			//var username=$("#username").val();
			//var email =$("#email").val();
			//var password=$("#password").val();
			//var password2 =$("#password2").val();
			//var action= '2';
		  	
		  
		  if (fname.value == ''  || lname.value == ''   ||  username.value == ''  || email.value == ''  || password.value == ''  ||  password2.value == '') 
		  { form.fname.focus();
			$("#error").html("<span style='color: red'>Error: Please complete all fields</span>");
			return false;
			}
			var re = /^\w+$/;
			if(!re.test(username.value)){
				$("#error").html("<span style='color: red'>Username musT contain only letters, numbers or underscores.</span>");
				return false;
			}
			
			if(password.value != password2.value){
				$("#error").html("<span style='color: red'>Passwords do not match.</span>");
				return false;
			}
			
			
				var p= document.createElement("input");
				
				form.appendChild(p);
				p.name="p";
				p.type="hidden";
				p.value = hex_sha512(password.value);
				
				password.value="";
				password2.value="";
				
				form.submit();
				/*$.post("ajaxLogin.php",{email:email, p:p}, function(data){
						if(data){
							$("#error").html(data);
								}
						});*/
					return true;
				}
			
			
			
			/*$.post("ajaxNewUser.php",{action:action , fname:fname, lname:lname, username:username, email:email, password:password, password2:password2}, function(data){
			if(data){
			$("#error").html(data);
			}
			});
				
			
			}*/

	function logInform(form, email, password){
		if (email.value == ''  ||  password.value == ''  ) { 
			form.email.focus();
			$("#error").html("<span style='color: red'>Error: Please complete all fields</span>");
			return false;
			}
					
				var p= document.createElement("input");
				
				form.appendChild(p);
				p.name="p";
				p.type="hidden";
				p.value = hex_sha512(password.value);
				
				password.value="";
				
				var email = email.value;
				var password  = p.value;
				//form.submit();
				var formArray = [email, password];
				
				
			return formArray;
			}
			
		
	

	
(function($){
    $.fn.extend({
        donetyping: function(callback,timeout){
            timeout = timeout || 500; // 1 second default timeout
            var timeoutReference,
                doneTyping = function(el){
                    if (!timeoutReference) return;
                    timeoutReference = null;
                    callback.call(el);
                };
            return this.each(function(i,el){
                var $el = $(el);
                // Chrome Fix (Use keyup over keypress to detect backspace)
                // thank you @palerdot
                $el.is(':input') && $el.on('keyup keypress',function(e){
                    // This catches the backspace button in chrome, but also prevents
                    // the event from triggering too premptively. Without this line,
                    // using tab/shift+tab will make the focused element fire the callback.
                    if (e.type=='keyup' && e.keyCode!=8) return;
                    
                    // Check if timeout has been set. If it has, "reset" the clock and
                    // start over again.
                    if (timeoutReference) clearTimeout(timeoutReference);
                    timeoutReference = setTimeout(function(){
                        // if we made it here, our timeout has elapsed. Fire the
                        // callback
                        doneTyping(el);
                    }, timeout);
                }).on('blur',function(){
                    // If we can, fire the event since we're leaving the field
                    doneTyping(el);
                });
            });
        }
    });
})(jQuery);