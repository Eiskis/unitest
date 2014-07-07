
(function (root) {

	var DashboardSuite = function () {
		var self = this;

		// Ko properties
		self.class = ko.observable('');
		self.injections = ko.observable({});

	};

	root.DashboardSuite = DashboardSuite;

})(window);
