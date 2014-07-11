
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
		* Selected conf object
		*/
		self.conf = ko.computed(function () {
			var confs = self.confs();
			var conf = confs[self.selectedConf()];
			return conf ? conf : null;
		}).extend({throttle: 1});

		/**
		* Editor visible
		*/
		self.showConfEditor = ko.computed(function () {
			return self.confEditor() || !self.conf() || !self.conf().suite();
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
				runnerPath: '../json/',
				testsPath: '../tests/',
				injections: []
			});
			conf2.load({
				autoUpdate: false,
				name: 'Another config',
				libPath: '',
				runnerPath: '../json/',
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

		/**
		* Toggle configs
		*/
		self.toggleConf = function (conf) {
			var current = self.conf();
			var confs = self.confs();

			for (var i = 0; i < confs.length; i++) {
				if (conf === confs[i]) {

					// Changing
					if (current !== conf) {
						self.selectedConf(i);

					// Already selected, toggle visibility
					} else if (self.conf() && self.conf().suite()) {
						self.confEditor((self.confEditor() ? false : true));
					}

					break;
				}
			}
			return self;
		};

		/**
		* New conf
		*/
		self.addConf = function (data) {

			// Create new conf object
			var conf = new DashboardConf();
			conf.load(data);

			// Add conf to app, select it for editing
			self.confs.push(conf);
			self.toggleConf(conf);

			return self;
		};

	};

	root.Dashboard = Dashboard;

})(window);
