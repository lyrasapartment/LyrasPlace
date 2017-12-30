var ViewModels = ViewModels || {};
function CustomerViewModel() {
	this.customers = ko.observableArray([]);
	this.totalNum = ko.observable();
	this.chosenCustomer = ko.observable();
	this.defaultCustomer = document.getElementById ("defaultCustomer").value || "";
	this.defaultTrID = document.getElementById ("defaultTrID").value || "";
	this.name = ko.observable();

	this.displayedCustomers = ko.computed(function () {
		return this.customers();
	}, this);

	this.resetCustomer = function () {
		this.callToServer(2);
		//this.defaultTrID = document.getElementById ("defaultCustomer").value || "";
		//this.defaultCustomer =  document.getElementById ("defaultTrID").value || "";
		this.chosenCustomer(null);
	}.bind(this);

	this.selectCustomer = function () {
		this.callToServer();
		this.customers
	}.bind(this);


	this.callToServer = function (type) {
		var self = this;
		console.log("inside callToServer", self);
		var Query= {};
		Query.defaultCustomer = document.getElementById ("defaultCustomer").value || "";
		Query.Search = document.getElementById ("trCustSearch").value || "";
		Query.Type = type;

		var request = $.ajax({
			url: '../jquery/TrEdit_Ajax.php',
		    type: 'post',
		    data: {"query" : JSON.stringify(Query)},
		    dataType:"json"
		});
		
		request.then(function(customers) {
			console.log(customers);
			self.customers(customers);
			self.defaultCustomer(customers.CustomerNo);
			this.name(customers.CFirstName + ' ' + customers.CLastName);
			
		});

	}.bind(this);

}

$(document).ready(function () {
	ViewModels.CustomerViewModel = new CustomerViewModel();
	ko.applyBindings(ViewModels.CustomerViewModel);
	ViewModels.CustomerViewModel.resetCustomer();
	// console.log("customers", ViewModels.TransactionViewModel.customers());
})