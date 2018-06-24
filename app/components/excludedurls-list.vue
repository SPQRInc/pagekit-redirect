<template>
    <form class="uk-form uk-form-stacked" v-validator="formIgnoreurls" @submit.prevent="addignoreurl | valid">
        <div class="uk-modal-header">
            <h2>{{ 'Edit Excluded URLs' | trans }}</h2>
        </div>
        <div class="uk-grid" data-uk-margin>
            <div class="uk-width-large-1-2">
                <input class="uk-input-large"
                       type="text"
                       placeholder="{{ 'URL' | trans }}"
                       name="excludedurl"
                       v-model="newExcludedUrl"
                       v-validate:required>
                <p class="uk-form-help-block uk-text-danger" v-show="formIgnoreurls.excludeurl.invalid">
                    {{ 'Invalid value.' | trans }}</p>
            </div>
            <div class="uk-width-large-1-2">
                <div class="uk-form-controls">
                    <span class="uk-align-right">
                        <button class="uk-button" @click.prevent="addignoreurl | valid">
                            {{ 'Add' | trans }}
                        </button>
                    </span>
                </div>
            </div>
        </div>
    </form>
    <hr />
    <div class="uk-alert"
         v-if="!config.exclusions.ignore_url.length">{{ 'You can add your first URL-exclusion using the input field above. Go ahead!' | trans }}
    </div>
    <ul class="uk-list uk-list-line uk-form" v-if="config.exclusions.ignore_url.length">
        <li v-for="excludedurl in config.exclusions.ignore_url">
            <input class="uk-input-large"
                   type="text"
                   placeholder="{{ 'URL' | trans }}"
                   v-model="excludedurl">
            <span class="uk-align-right">
                <button @click="removeurl(excludedurl)" class="uk-button uk-button-danger">
                    <i class="uk-icon-remove"></i>
                </button>
            </span>
        </li>
    </ul>
    <div class="uk-modal-footer uk-text-right">
        <button class="uk-button uk-button-link uk-modal-close"
                type="button">{{ 'Close' | trans }}
        </button>
    </div>
</template>

<script>

module.exports = {
	props: ['config', 'form'],

	data: function () {
		return {
			config: '',
			newExcludedUrl: ''
		}
	},

	methods: {

		addignoreurl: function add(e) {

			e.preventDefault();
			if (!this.newExcludedUrl || this.urlMatch(this.newExcludedUrl)) return;

			this.config.exclusions.ignore_url.push(this.newExcludedUrl);
			this.newExcludedUrl = ''
		},

		removeurl: function (url) {
			this.config.exclusions.ignore_url.$remove(url);
		},

		urlMatch: function (url) {
			return this.config.exclusions.ignore_url.filter(function (result) {
				return result == url;
			}).length > 0;
		}

	}
}

</script>