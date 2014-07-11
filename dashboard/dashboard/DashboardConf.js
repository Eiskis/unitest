
(function (root) {

	var DashboardConf = function () {
		var self = this;

		self.defaults = {
			name: 'My config'
		};

		/**
		* Ko properties
		*/
		self.autoUpdate = ko.observable(true);
		self.name = ko.observable(self.defaults.name);
		self.libPath = ko.observable('');
		self.runnerPath = ko.observable('');
		self.testsPath = ko.observable('');
		self.injections = ko.observableArray();

		self.report = ko.observable({});
		self.suite = ko.observable();

		self.runnerAvailable = ko.observable(true);
		self.updating = ko.observable(false);



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
			var data = {
				path: self.testsPath(),
				injections: self.injectionsAsHash()
			};
			if (self.libPath()) {
				data.lib = self.libPath();
			}
			return data;
		}).extend({throttle: 1});



		/**
		* Digest properties fom JSON
		*/
		self.load = function (data) {
			if (is.hash(data)) {

				// Properties
				var properties = ['autoUpdate', 'name', 'runnerPath', 'libPath', 'testsPath', 'injections'];
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
		* Run tests via backend
		*/
		self.run = function () {
			var dfd = $.Deferred();

			self.updating(true);

			$.ajax({
				dataType: 'json',
				type: 'POST',
				url: self.runnerPath(),
				data: self.postData(),
				success: function (data, textStatus, jqXHR) {
					self.runnerAvailable(true);
					self.report(data);
					dfd.resolve();
				},
				error: function (jqXHR, textStatus, errorThrown) {
					self.runnerAvailable(jqXHR.status === 400 ? true : false);
					dfd.reject();
				},
				complete: function (jqXHR, textStatus) {
					self.updating(false);
				}
			});

			return dfd.promise();
		};

		/**
		* Run tests when path to tests changes
		*/
		self.subRunOnonPostData = self.postData.subscribe(function (newValue) {
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

		/**
		* Name validation
		*/
		self.validateName = function (newValue) {
			if (is.empty(newValue) || !is.string(newValue)) {
				self.name(self.defaults.name);
			}
			
		};
		self.subValidateName = self.name.subscribe(self.validateName);

	};

	root.DashboardConf = DashboardConf;

})(window);
