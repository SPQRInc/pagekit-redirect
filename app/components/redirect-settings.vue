<template>
    <div class="uk-form uk-form-horizontal">
        <h1>{{ 'Redirect Settings' | trans }}</h1>
        <div class="uk-form-row">
            <label for="form-redirect" class="uk-form-label">{{ 'URL' | trans }}</label>
            <div class="uk-form-controls">
               <input-link id="form-redirect" class="uk-form-width-medium" :link.sync="package.config.url"></input-link>
            </div>
        </div>
        <div class="uk-form-row uk-margin-top">
            <div class="uk-form-controls">
                <button class="uk-button uk-button-primary" @click="save">{{ 'Save' | trans }}</button>
            </div>
        </div>
    </div>
</template>

<script>

module.exports = {

	settings: true,

	props: ['package'],

	methods: {
		save: function save() {
			this.$http.post ('admin/system/settings/config', {
				name: 'spqr/redirect',
				config: this.package.config
			}).then (function () {
				this.$notify ('Settings saved.', '');
			}).catch (function (response) {
				this.$notify (response.message, 'danger');
			}).finally (function () {
				this.$parent.close ();
			});
		}
	}
};

window.Extensions.components['redirect-settings'] = module.exports;
</script>