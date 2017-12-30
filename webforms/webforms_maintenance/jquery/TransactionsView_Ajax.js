
function showUser3(page) {
	var Query = {};
		Query.Search = document.getElementById ("trCustSearch").value || "";
		Query.DateFrom = document.getElementById ("trDateFrom").value;
		Query.DateTo = document.getElementById ("trDateTo").value;
		Query.Start = (page-1) * 10;
		Query.End = (page  * 10) - 1;
		console.log(Query.Start, Query.End);
	
	$.ajax({
	   url: '../jquery/TrView_Ajax.php',
	   type: 'post',
	   data: {"query" : JSON.stringify(Query)},
	   success: function(response) {
		   
		   let customers = JSON.parse(response);
		   
		   console.log(customers);
		   viewmodel.TransactionViewModel(TransactionViewModel);
	   }
	});
	
}

