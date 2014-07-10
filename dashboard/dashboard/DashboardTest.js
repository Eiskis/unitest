
(function (root) {

	var DashboardTest = function () {
		var self = this;

		// Ko properties
		self.class = ko.observable('');
		self.duration = ko.observable(0);
		self.file = ko.observable('');
		self.line = ko.observable(0);
		self.message = ko.observable('');
		self.method = ko.observable('');
		self.status = ko.observable('');
		self.injections = ko.observableArray();



		// Shortcuts

		self.failed = ko.computed(function () {
			return self.status() === 'failed';
		}).extend({throttle: 1});
		self.passed = ko.computed(function () {
			return self.status() === 'passed';
		}).extend({throttle: 1});
		self.skipped = ko.computed(function () {
			return self.status() === 'skipped';
		}).extend({throttle: 1});

		self.roundedDuration = ko.computed(function () {
			var threshold = 1000*1000;
			return (Math.round(self.duration() * threshold) / threshold);
		}).extend({throttle: 1});

		self.name = ko.computed(function () {
			return self.method();
		}).extend({throttle: 1});
		self.suiteName = ko.computed(function () {
			return self.class();
		}).extend({throttle: 1});



		// Load data from JSON
		self.load = function (data) {
			if (is.hash(data)) {

				// Properties
				var properties = ['class', 'duration', 'file', 'line', 'message', 'method', 'status', 'injections'];
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
