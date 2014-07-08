
(function (root) {

	var DashboardConf = function () {
		var self = this;

		/**
		* Ko properties
		*/
		self.name = ko.observable('');
		self.runnerPath = ko.observable('../runner/');
		self.libPath = ko.observable('../lib/');
		self.testsPath = ko.observable('../tests/');
		self.injections = ko.observableArray();

		self.report = ko.observable({});
		self.suite = ko.observable();

		self.runnerAvailable = ko.observable(true);
		self.libAvailable = ko.observable(true);
		self.testsAvailable = ko.observable(true);



		/**
		* Injections as a hash
		*/
		self.injectionsAsHash = ko.computed(function () {
			var hash = {};
			var injections = self.injections();
			for (var i = 0; i < injections.length; i++) {
				hash[injections[i].name] = injections[i].value;
			}
			return hash;
		}).extend({throttle: 1});



		/**
		* Data to send to test runner
		*/
		self.postData = ko.computed(function () {
			return {
				path: self.testsPath(),
				injections: self.injectionsAsHash()
			};
		}).extend({throttle: 1});



		/**
		* Digest properties fom JSON
		*/
		self.load = function (data) {
			if (is.hash(data)) {

				// Properties
				var properties = ['name', 'runnerPath', 'libPath', 'testsPath', 'injections'];
				for (var i = 0; i < properties.length; i++) {
					var property = properties[i];
					if (is.set(data[property])) {
						self[property](data[property]);
					}
				}

			}

			return self;
		};



		/**
		* Ping for backend availability
		*/
		self.ping = function () {

			$.ajax({
				dataType: 'json',
				type: 'GET',
				url: self.runnerPath(),
				success: function (data, textStatus, jqXHR) {
				},
				error: function (jqXHR, textStatus, errorThrown) {
				},
				complete: function (jqXHR, textStatus) {
					self.runnerAvailable(jqXHR.status === 404 ? false : true);
				}
			});

			$.ajax({
				dataType: 'json',
				type: 'GET',
				url: self.libPath(),
				success: function (data, textStatus, jqXHR) {
				},
				error: function (jqXHR, textStatus, errorThrown) {
				},
				complete: function (jqXHR, textStatus) {
					self.libAvailable(jqXHR.status === 404 ? false : true);
				}
			});

			return self;
		};



		/**
		* Run tests via backend
		*/
		self.run = function () {
			var dfd = $.Deferred();

			$.ajax({
				dataType: 'json',
				type: 'POST',
				url: self.runnerPath(),
				data: self.postData(),
				success: function (data, textStatus, jqXHR) {
					self.testsAvailable(true);
					self.report(data);
					dfd.resolve();
				},
				error: function (jqXHR, textStatus, errorThrown) {
					self.testsAvailable(false);
					self.ping();
					dfd.reject();
				},
				complete: function (jqXHR, textStatus) {
				}
			});

			return dfd.promise();
		};

		/**
		* Ping backend availability when runner path changes
		*/
		self.subPingOnRunnerPath = self.runnerPath.subscribe(function (newValue) {
			self.ping();
		});

		/**
		* Run tests when path to tests changes
		*/
		self.subROnonPostData = self.postData.subscribe(function (newValue) {
			self.run();
		});

		/**
		* Generate suite objects when report is updated
		*/
		self.subGenerateSuitesOnReport = self.report.subscribe(function (newValue) {
			var suite = new DashboardSuite();
			suite.load(newValue);
			self.suite(suite);
		});

	};

	root.DashboardConf = DashboardConf;

})(window);
