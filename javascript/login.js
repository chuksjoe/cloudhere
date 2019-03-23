$(document).ready(function(){
	$("#loginForm").submit(function(e){
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
		
		//for the email field
		if($('#email').val() == ""){
			errorFields.push('email');
		}
		//check for the password
		if($('#password').val() == ""){
			errorFields.push('password');
		}
		
		//check for email address
		if(!($('#email').val().indexOf(".") > 2) && ($('#email').val().indexOf("@"))){
			errorFields.push('email');
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