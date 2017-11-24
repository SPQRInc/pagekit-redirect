<template>
    <div class="uk-form uk-form-horizontal">
        <h1>{{ 'Redirect Settings' | trans }}</h1>
        <div class="uk-form-row">
            <label class="uk-form-label">{{ 'Enable Unauthorized Redirection' | trans }}</label>
            <div class="uk-form-controls uk-form-controls-text">
                <input type="checkbox" v-model="package.config.unauthorized.enabled">
            </div>
        </div>

        <div class="uk-form-row" v-if="package.config.unauthorized.enabled">
            <label for="form-redirect-unauthorized" class="uk-form-label">{{ 'Unauthorized URL' | trans }}</label>
            <div class="uk-form-controls">
                <input-link id="form-redirect-unauthorized" class="uk-form-width-medium" :link.sync="package.config.unauthorized.url"></input-link>
            </div>
        </div>
        <div class="uk-form-row">
            <label class="uk-form-label">{{ 'Enable Forbidden Redirection' | trans }}</label>
            <div class="uk-form-controls uk-form-controls-text">
                <input type="checkbox" v-model="package.config.forbidden.enabled">
            </div>
        </div>

        <div class="uk-form-row" v-if="package.config.forbidden.enabled">
            <label for="form-redirect-forbidden" class="uk-form-label">{{ 'Forbidden URL' | trans }}</label>
            <div class="uk-form-controls">
                <input-link id="form-redirect-forbidden" class="uk-form-width-medium" :link.sync="package.config.forbidden.url"></input-link>
            </div>
        </div>
        <div class="uk-form-row">
            <label class="uk-form-label">{{ 'Enable Not Found Redirection' | trans }}</label>
            <div class="uk-form-controls uk-form-controls-text">
                <input type="checkbox" v-model="package.config.notfound.enabled">
            </div>
        </div>
        <div class="uk-form-row" v-if="package.config.notfound.enabled">
            <label for="form-redirect-notfound" class="uk-form-label">{{ 'Not Found URL' | trans }}</label>
            <div class="uk-form-controls">
                <input-link id="form-redirect-notfound" class="uk-form-width-medium" :link.sync="package.config.notfound.url"></input-link>
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