$(document).ready(function() {
	$("#trAddForm").submit(function(e) {
		removeFeedback();
		var errors = validateForm1();
		if(errors == "") {
			return true;
		}
		else {
			provideFeedback(errors);
			e.preventDefault();
			return false;
		}
	});
	function validateForm1() {
		var errorFields = new Array();
		
		//Check required fields have something in them
		if ($('#trCustId').val() == "") {
			errorFields.push('trCustId');
		}
		if ($('#trDebit').val() == "") {
			errorFields.push('trDebit');
		}

		if ($('#trCredit').val() == "") {
			errorFields.push('trCredit');
		}
		
		if ($('#trDesc').val() == "") {
			errorFields.push('trDesc');
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