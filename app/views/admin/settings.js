window.settings = {

	el: '#settings',

	data: {
		config: $data.config,
		newExcludedExtension: '',
		newExcludedUrl: ''
	},

	ready: function () {
		this.$watch ('config.unauthorized.type', function (type) {
			if (type === 'redirect') {
				this.config.unauthorized.response = 301;
			}
			if (type === 'html') {
				this.config.unauthorized.response = 401;
			}
		});

		this.$watch ('config.forbidden.type', function (type) {
			if (type === 'redirect') {
				this.config.forbidden.response = 301;
			}
			if (type === 'html') {
				this.config.forbidden.response = 403;
			}
		});

		this.$watch ('config.notfound.type', function (type) {
			if (type === 'redirect') {
				this.config.notfound.response = 301;
			}
			if (type === 'html') {
				this.config.notfound.response = 404;
			}
		});

	},

	methods: {

		save: function () {
			this.$http.post ('admin/redirect/save', {config: this.config}, function () {
				this.$notify ('Settings saved.');
			}).error (function (data) {
				this.$notify (data, 'danger');
			});
		},

		editExcludedExtensions: function () {
			this.$refs.excludedextensions.open();
		},

		editExcludedUrls: function () {
			this.$refs.excludedurls.open();
		}
	},
	components: {
		'excludedextensions-list': require('../../components/excludedextensions-list.vue'),
		'excludedurls-list': require('../../components/excludedurls-list.vue'),
	}
};

Vue.ready (window.settings);