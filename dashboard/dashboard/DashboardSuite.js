
(function (root) {

	var DashboardSuite = function () {
		var self = this;

		// Ko properties
		self.class = ko.observable('');
		self.file = ko.observable('');
		self.line = ko.observable(0);

		self.failed = ko.observable(0);
		self.passed = ko.observable(0);
		self.skipped = ko.observable(0);
		self.total = ko.computed(function () {
			return self.failed() + self.passed() + self.skipped();
		});

		self.parents = ko.observableArray();
		self.tests = ko.observableArray();
		self.children = ko.observableArray();

		// Shortcuts
		self.name = ko.computed(function () {
			return self.class();
		});
		self.parentPath = ko.computed(function () {
			return self.parents().join(' &rsaquo; ');
		});

		// Tools
		self.allChildren = ko.computed(function () {
			var all = [];
			var children = self.children();
			for (var i = 0; i < children.length; i++) {
				var child = children[i];
				all.push(child);
				if (!is.empty(child.children())) {
					all = $.merge(all, child.allChildren());
				}
			}
			return all;
		});

		// Load data from JSON
		self.load = function (data) {
			if (is.hash(data)) {

				// Properties
				var properties = ['class', 'file', 'line', 'failed', 'passed', 'skipped', 'parents'];
				for (var i = 0; i < properties.length; i++) {
					var property = properties[i];
					if (is.set(data[property])) {
						self[property](data[property]);
					}
				}

				// Child suites
				if (is.set(data.children)) {
					var children = [];
					for (var j = 0; j < data.children.length; j++) {
						var child = new DashboardSuite();
						child.load(data.children[j]);
						children.push(child);
					}
					self.children(children);
				}

				// Tests
				if (is.set(data.tests)) {
					var tests = [];
					for (var testKey in data.tests) {
						tests.push(data.tests[testKey]);
					}
					self.tests(tests);
				}

			}

			return self;
		};

	};

	root.DashboardSuite = DashboardSuite;

})(window);
