$(document).ready(function() {
	//document.getElementById("trCredit").value = "0.00";
	//document.getElementById("trDebit").value = "0.00";
	
	var x = document.getElementById("trDesc");
	var trDescVal1 = x.options[x.selectedIndex].value;

	switch(trDescVal1) {
		case "Payment":
		$( "#trDebit" ).prop( "disabled", true );
		$( "#trCredit" ).prop( "disabled", false );
		$('.debt').hide();
		break;
		case "Room Fee":
		case "Foam Fee":
		$('.debt').show();
		$( "#trDebit" ).prop( "disabled", false );
		$( "#trCredit" ).prop( "disabled", true );

		break;
		default: break;
	}
	
	$("#trDesc").change( function() {
	var e = document.getElementById("trDesc");
	var trDescVal = e.options[e.selectedIndex].value;
	switch(trDescVal) {
		case "Payment":
		document.getElementById("trDebit").value = "0.00";
		$('.debt').hide();
		$( "#trDebit" ).prop( "disabled", true );
		$( "#trCredit" ).prop( "disabled", false );
		break;
		case "Room Fee":
		case "Foam Fee":
		document.getElementById("trCredit").value = "0.00";
		$('.debt').show();
		$( "#trDebit" ).prop( "disabled", false );
		$( "#trCredit" ).prop( "disabled", true );
		break;
		case  "Cancellation":
		document.getElementById("trCredit").value = "0.00";
		document.getElementById("trDebit").value = "0.00";
		$( "#trDebit" ).prop( "disabled", false );
		$( "#trCredit" ).prop( "disabled", false );
		break;
		default: break;
	}
	
	});

});



function showUser(str) {

    if (str == "") {
        document.getElementById("trCustIDtd").innerHTML = "";
        return;
    } else { 
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("trCustIDtd").innerHTML = this.responseText;
            }
        };
        xmlhttp.open("GET","../jquery/TrAdd_Ajax.php?q="+str,true);
        xmlhttp.send();
    }
}


function showUser2(str) {
	if (str == "") {
		document.getElementById("trCustIDtd").innerHTML = "";
		return;
	} 
	else { 
		var e = document.getElementById ("trCustId");
		
		var strUser = e.options [e.selectedIndex].value;
		 if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }	
		 xmlhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			document.getElementById("custinfo").innerHTML = this.responseText;
			}
		};
		xmlhttp.open("GET","../jquery/TrAdd_Ajax2.php?q="+strUser,true);
		xmlhttp.send();
		document.getElementById ("trCustId2").value = document.getElementById ("trCustId").value;
	}
}



