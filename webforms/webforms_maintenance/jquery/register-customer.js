$(document).ready(function() {
	$("#userForm".submit(function(e) {
		removeFeedback();
		var errors = validateForm();
		if(errors == "") {
			return true;
		}
		else {
			provideFeedback(errors);
			e.preventDefault();
			return false;
		}
	});
	function validateForm() {
		var errorFields = new Array();
		
		//Check required fields have something in them
		if ($('#uname').val() == "") {
			errorFields.push('uname');
		}
		if ($('#lname').val() == "") {
			errorFields.push('lname');
		}
		if ($('#fname').val() == "") {
			errorFields.push('fname');
		}
		if ($('#accountType').val() == "") {
			errorFields.push('accountType');
		}
		if ($('#email').val() == "") {
			errorFields.push('email');
		}
		if ($('#password1').val() == "") {
			errorFields.push('password1');
		}
		//check passwords match
		if ($('#password2').val() != $('#password2').val()) {
			errorFields.push('password2');
		}
		//very basic e-mail check, just an @ symbol
		if (!($('#email').val().indexOf(".") > 2) && ($('#email').val().indexOf("@"))) {
			errorFields.push('email');
		}
		if ($('#phone').val() != "") {
			var phoneNum = $('#phone').val()
			phoneNum.replace(/[^0-9]/g, "");
			if (phoneNum.length != 10) {
				errorFields.push('phone');
			}
		}
		return errorFields;
	} //end function validateForm
	
	function provideFeedback(incomingErrors) {
		for (var i=0;i<incomingErrors.length;i++) {
			$("#"+incomingErrors[i]).addClass("errorClass");
			$("#"+incomingErrors[i]+"Error").removeClass("errorFeedback");
		}
		$("#errorDiv").html("Errors encountered");
	}
	
	function removeFeedback() {
		$("#errorDiv").html("");
		$('input').each(function() {
			$(this).removeClass("errorClass");
		});
		$('.errorSpan').each(function() {
			$(this).addClass("errorFeedback");
		});
	}
	
});