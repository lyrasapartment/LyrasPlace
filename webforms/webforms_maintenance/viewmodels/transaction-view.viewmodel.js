var ViewModels = ViewModels || {};
function TransactionViewModel() {
	this.transactions = ko.observableArray([]);
	this.totalNum = ko.observable();
	this.page = ko.observable(1);
	this.minPage = ko.observable();
	this.maxPage = ko.observable();
	//this.All = ko.observable(true);
	//this.count = ko.observable();

	this.pages = ko.computed(function () {
		var total = Math.ceil(this.totalNum() / 10);
		var arr = [], i=1;
		while(total--){
			arr.push(i);
			i++;
		}
		var min = this.page() - (this.page()%10);		
		if(this.page()%10==0) {
			min-=10;
		}
		var max = min +10;
		
		var arr = _.slice(arr, min, max);
		this.minPage = min;
		this.maxPage = max;

		console.log("asdasd", arr);
		return arr;
	}, this);

	//displayed transactions based on page.
	this.displayedTransactions = ko.computed(function () {
		var max = this.page() * 10;		
		var min = max -10;

		// this.transactions(_.slice(this.transactions(), min, max)); 
		//just return a new array instead of modifying transactions
		return _.slice(this.transactions(), min, max);
	}, this);

	this.goToPreviousPage = function () {
		if(this.page() > 1){
			var newPage = this.page() - 1;
			
			//this.callToServer();
			this.page(newPage);
			//this.totalNum(this.count);


		} 
	}.bind(this);

	this.goToPage = function (page) {	
		//this.callToServer(page-(page%10),page-(page%10)+10,true);
		//this.callToServer();
		this.page(page);
		//this.totalNum(this.count);
	}.bind(this);

	this.jumpToPage = function (page) {	
		limit = Math.ceil(this.totalNum() / 10);
		var input = document.getElementById ("pageSearch").value || "";
		if(input=="" || input < 1) {
			input = 1;
		}
		else if(input > limit) {
			input = limit;
		}

		this.goToPage(input);
		//this.totalNum(this.count);
	}.bind(this);

	this.goToFirstPage = function () {
		this.goToPage(1);
	}.bind(this);

	this.goToLastPage = function () {
		limit = Math.ceil(this.totalNum() / 10);
		this.goToPage(limit);
	}.bind(this);

	this.goToNextPage = function () {
		if(this.page() < Math.ceil(this.totalNum() / 10)){
			var newPage = this.page() + 1;
			//this.callToServer();
			this.page(newPage);
			//this.callToServer(newPage-(newPage%10),newPage-(newPage%10)+10,true);
			//this.totalNum(this.count);

		}
	}.bind(this);
	

	this.callToServer = function () {
		var self = this;
		console.log("inside callToServer", self);
		var Query= {};
		Query.Search = document.getElementById ("trCustSearch").value || "";
		Query.DateFrom = document.getElementById ("trDateFrom").value;
		Query.DateTo = document.getElementById ("trDateTo").value;
		//Query.Options = document.getElementById ("TrOptions").value;

		var request = $.ajax({
		   url: '../jquery/TrView_Ajax.php',
		   type: 'post',
		   data: {"query" : JSON.stringify(Query)},
		   dataType:"json"
		});
		
		request.then(function(transactions) {
			console.log(transactions);
			self.transactions(transactions);
			self.totalNum(transactions.length);
			self.goToPage(1);
		});

	}.bind(this);

}

$(document).ready(function () {
	ViewModels.TransactionViewModel = new TransactionViewModel();
	ko.applyBindings(ViewModels.TransactionViewModel);
	// console.log("transactions", ViewModels.TransactionViewModel.transactions());
})