
(function (root) {

	var Dashboard = function () {
		var self = this;

		// Ko properties
		self.title = ko.observable('Unitest Dashboard');

		self.runnerAvailable = ko.observable(true);
		self.runnerPath = ko.observable('../runner/');
		self.runnerUndoPath = ko.observable('');

		self.specAvailable = ko.observable(true);
		self.specPath = ko.observable('../tests/');

		self.injections = ko.observableArray();
		self.report = ko.observable({});
		self.suite = ko.observable();



		// Injections as a hash
		self.injectionsAsHash = ko.computed(function () {
			var hash = {};
			var injections = self.injections();
			for (var i = 0; i < injections.length; i++) {
				hash[injections[i].name] = injections[i].value;
			}
			return hash;
		}).extend({throttle: 1});

		// Data to send to test runner
		self.postData = ko.computed(function () {

			// Prefix relative spec path so runner understands it
			var specPath = self.specPath();
			if (specPath.substr(0, 1) !== '/') {
				specPath = self.runnerUndoPath() + specPath;
			}

			return {
				path: specPath,
				injections: self.injectionsAsHash()
			};
		});



		// Startup
		self.init = function (container) {
			ko.applyBindings(self, container);
			return self.run();
		};

		// Ping for backend availability
		self.ping = function () {
			var dfd = $.Deferred();

			$.ajax({
				dataType: 'json',
				type: 'GET',
				url: self.runnerPath(),
				success: function (data, textStatus, jqXHR) {
					dfd.resolve();
				},
				error: function (jqXHR, textStatus, errorThrown) {
					dfd.reject();
				},
				complete: function (jqXHR, textStatus) {
					self.runnerAvailable(jqXHR.status === 404 ? false : true);
				}
			});

			return dfd.promise();
		};

		// Run tests via backend
		self.run = function () {
			var dfd = $.Deferred();

			$.ajax({
				dataType: 'json',
				type: 'POST',
				url: self.runnerPath(),
				data: self.postData(),
				success: function (data, textStatus, jqXHR) {
					self.specAvailable(true);
					self.report(data);
					dfd.resolve();
				},
				error: function (jqXHR, textStatus, errorThrown) {
					self.specAvailable(false);
					self.ping();
					dfd.reject();
				},
				complete: function (jqXHR, textStatus) {
				}
			});

			return dfd.promise();
		};

		// Run tests when spec path changes
		self.runnerPath.subscribe(function (newValue) {
			self.ping();
		});
		self.specPath.subscribe(function (newValue) {
			self.run();
		});

		// Generate suite objects when report is updated
		self.report.subscribe(function (newValue) {
			var suite = new DashboardSuite();
			suite.load(newValue);
			self.suite(suite);
		});

	};

	root.Dashboard = Dashboard;

})(window);
