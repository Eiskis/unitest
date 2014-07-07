
(function (root) {

	var DashboardTest = function () {
		var self = this;

		// Ko properties
		self.class = ko.observable('');
		self.file = ko.observable('');
		self.line = ko.observable(0);
		self.message = ko.observable('');
		self.method = ko.observable('');
		self.status = ko.observable('');
		self.injections = ko.observableArray();

		self.failed = ko.observable(function () {
			return self.status() === 'failed';
		});
		self.passed = ko.observable(function () {
			return self.status() === 'passed';
		});
		self.skipped = ko.observable(function () {
			return self.status() === 'skipped';
		});

		// Shortcuts
		self.name = ko.computed(function () {
			return self.method();
		});
		self.suiteName = ko.computed(function () {
			return self.class();
		});

		// Load data from JSON
		self.load = function (data) {
			if (is.hash(data)) {

				// Properties
				var properties = ['class', 'file', 'line', 'message', 'method', 'status', 'injections'];
				for (var i = 0; i < properties.length; i++) {
					var property = properties[i];
					if (is.set(data[property])) {
						self[property](data[property]);
					}
				}

			}

			return self;
		};

	};

	root.DashboardTest = DashboardTest;

})(window);
