
(function (root) {

	var Dashboard = function () {
		var self = this;

		/**
		* Ko properties
		*/
		self.confs = ko.observableArray();
		self.confEditor = ko.observable(false);
		self.name = ko.observable('Unitest Dashboard');
		self.selectedConf = ko.observable(0);

		/**
		* Toggle configs
		*/
		self.toggleConf = function (conf) {
			var current = self.conf();
			var confs = self.confs();

			for (var i = 0; i < confs.length; i++) {
				if (conf === confs[i]) {
					if (current !== conf) {
						self.selectedConf(i);
					} else if (self.confEditor()) {
						self.confEditor(false);
					} else {
						self.confEditor(true);
					}
				}
			}

		};

		/**
		* Computed
		*/
		self.conf = ko.computed(function () {
			var confs = self.confs();
			var conf = confs[self.selectedConf()];
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
			var conf2 = new DashboardConf();
			conf.load({
				autoUpdate: true,
				name: 'Test config',
				libPath: '',
				runnerPath: '../runner/',
				testsPath: '../tests/',
				injections: []
			});
			conf2.load({
				autoUpdate: false,
				name: 'Another config',
				libPath: '',
				runnerPath: '../runner/',
				testsPath: '../tests/',
				injections: [
					{
						name: 'foo',
						value: 'bar'
					}
				]
			});

			// Set new conf
			self.confs([conf, conf2]);
			self.selectedConf(0);

			// Bind
			ko.applyBindings(self, container);

			// Mark DOM loaded
			setTimeout(function () {
				$(container).find('.loading').toggleClass('loading loaded');
			}, 100);

			return self;
		};

		/**
		* Run all suites
		*/
		self.run = function () {
			var confs = self.confs();
			for (var i = 0; i < confs.length; i++) {
				if (confs[i].suite()) {
					confs[i].suite().run();
				}
			}
			return self;
		};

	};

	root.Dashboard = Dashboard;

})(window);
