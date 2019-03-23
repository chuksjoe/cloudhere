$(document).ready(function(){
	$("#userForm").submit(function(e){
		removeFeedback();
		var errors = validateForm();
		if(errors == ""){
			return true;
		}else{
			provideFeedback(errors);
			e.preventDefault();
			return false;
		}
	});
	//Validation function
	function validateForm(){
		//set the error Array
		var errorFields = new Array();
		//check the required fields
		//for the name field
		if($("#fname").val() == ""){
			errorFields.push('fname');
		}
		if($("#lname").val() == ""){
			errorFields.push('lname');
		}
		//for the email field
		if($('#email').val() == ""){
			errorFields.push('email');
		}
		//check for the password
		if($('#password1').val() == ""){
			errorFields.push('password1');
		}
		if($('#password2').val() == ""){
			errorFields.push('password22');
		}
		//check for passwords match
		if($('#password2').val() != $('#password1').val()){
			errorFields.push('password2');
		}
		//check for email address
		if(!($('#email').val().indexOf(".") > 2) && ($('#email').val().indexOf("@"))){
			errorFields.push('email');
		}
		//check the phone number status
		if($('#phone').val() != ""){
			var phoneNo = $('#phone').val();
			phoneNo.replace(/[^0-9]/g, "");
			if(phoneNo.length < 10){
				errorFields.push("phone");
			}
		}
		if($('#gender').val() == ""){
			errorFields.push('gender');
		}
		if($('#dob').val() == ""){
			errorFields.push('dob');
		}

		return errorFields;
	}//End of validation function
	
	//Function to provide feedback to the visitor
	function provideFeedback(incomingErrors){
		for(var i = 0; i < incomingErrors.length; i++){
			$("#"+incomingErrors[i]).addClass("errorClass");
			$("#"+incomingErrors[i]+"Error").removeClass("errorFeedback");
		}
		//$("#errorDiv").html("Errors encountered:");
	}
	
	//function to remove feedback
	function removeFeedback(){
		$("#errorDiv").html("");
		$('input').each(function(){
			$(this).removeClass("errorClass");
		});
		$('.errorSpan').each(function(){
			$(this).addClass("errorFeedback");
		});
	}
});