
(function (root) {

	var Dashboard = function () {
		var self = this;

		/**
		* Ko properties
		*/
		self.name = ko.observable('Unitest Dashboard');
		self.confs = ko.observableArray();
		self.selectedConf = ko.observable(0);
		self.confEditor = ko.observable(false);

		/**
		* Toggle configs
		*/
		self.toggleConf = function (i) {
			var original = self.selectedConf();

			// Select
			if (self.selectedConf() !== i) {
				self.selectedConf(i);
			}

			// If value didn't change, toggle editor visibility
			if (original === self.selectedConf()) {
				if (self.confEditor()) {
					self.confEditor(false);
				} else {
					self.confEditor(true);
				}
			}

		};

		/**
		* Computed
		*/
		self.conf = ko.computed(function () {
			var conf = self.confs()[self.selectedConf()];
			return conf ? conf : null;
		}).extend({throttle: 1});

		/**
		* Validate selected conf
		*/
		self.subValidateSelectedConf = self.selectedConf.subscribe(function (newValue) {
			if (newValue !== 0) {
				var confs = self.confs();
				if (is.empty(confs) || !is.set(confs[newValue])) {
					self.selectedConf(0);
				}
			}
		});

		/**
		* Startup
		*/
		self.init = function (container) {

			// New conf
			var conf = new DashboardConf();
			conf.load({
				name: 'Conf 1',
				lib: '../lib/',
				runner: '../runner/',
				tests: '../tests/',
				injections: []
			});

			// Set new conf
			self.confs([conf]);
			self.selectedConf(0);

			conf.run();

			// Bind
			ko.applyBindings(self, container);

			// Mark DOM loaded
			setTimeout(function () {
				$(container).find('.loading').toggleClass('loading loaded');
			}, 100);

			return self;
		};

	};

	root.Dashboard = Dashboard;

})(window);
