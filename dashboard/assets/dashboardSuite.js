
(function (root) {

	var DashboardSuite = function () {
		var self = this;

		// Ko properties
		self.class = ko.observable('');
		self.file = ko.observable('');
		self.line = ko.observable(0);
		self.parents = ko.observableArray();

		self.failed = ko.observable(0);
		self.passed = ko.observable(0);
		self.skipped = ko.observable(0);

		self.tests = ko.observableArray();
		self.children = ko.observableArray();

	};

	

	root.DashboardSuite = DashboardSuite;

})(window);
