<template>
    <form class="uk-form uk-form-stacked" v-validator="formIgnoreextensions" @submit.prevent="addignoreextension | valid">
        <div class="uk-modal-header">
            <h2>{{ 'Edit Excluded Extensions' | trans }}</h2>
        </div>
        <div class="uk-grid" data-uk-margin>
            <div class="uk-width-large-1-2">
                <input class="uk-input-large"
                       type="text"
                       placeholder="{{ 'Extension (e.g. css)' | trans }}"
                       name="excludedextension"
                       v-model="newExcludedExtension"
                       v-validate:required>
                <p class="uk-form-help-block uk-text-danger" v-show="formIgnoreurls.excludeextension.invalid">
                    {{ 'Invalid value.' | trans }}</p>
            </div>
            <div class="uk-width-large-1-2">
                <div class="uk-form-controls">
                    <span class="uk-align-right">
                        <button class="uk-button" @click.prevent="addignoreextension | valid">
                            {{ 'Add' | trans }}
                        </button>
                    </span>
                </div>
            </div>
        </div>
    </form>
    <hr />
    <div class="uk-alert" v-if="!config.exclusions.ignore_ext.length">{{ 'You can add your first extension-exclusion using the input field above. Go ahead!' | trans }}</div>
    <ul class="uk-list uk-list-line uk-form" v-if="config.exclusions.ignore_ext.length">
        <li v-for="excludedext in config.exclusions.ignore_ext">
            <input class="uk-input-large"
                   type="text"
                   placeholder="{{ 'Extension' | trans }}"
                   v-model="excludedext">
            <span class="uk-align-right">
                <button @click="removeext(excludedext)" class="uk-button uk-button-danger"><i class="uk-icon-remove"></i></button>
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
			newExcludedExtension: '',
		}
	},

	methods: {

		addignoreextension: function add(e) {

			e.preventDefault();
			if (!this.newExcludedExtension || this.extMatch(this.newExcludedExtension)) return;

			this.config.exclusions.ignore_ext.push(this.newExcludedExtension);
			this.newExcludedExtension = ''
		},

		removeext: function (ext) {
			this.config.exclusions.ignore_ext.$remove(ext);
		},

		extMatch: function (ext) {
			return this.config.exclusions.ignore_ext.filter(function (result) {
				return result == ext;
			}).length > 0;
		}
	}
}

</script>