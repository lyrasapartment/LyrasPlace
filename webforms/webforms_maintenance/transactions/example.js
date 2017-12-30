function AppViewModel(customers) {
    this.firstName = ko.observable("Bert");
    this.lastName =  ko.observable("Bertington");
    
    this.fullName = ko.computed(function(){
        return this.firstName() + " " + this.lastName();
    }, this);
    
    this.customers = ko.observableArray(customers);
}

// Activates knockout.js
ko.applyBindings(new AppViewModel());