<template>
    <form class="uk-form uk-form-stacked" v-validator="formUrl" @submit.prevent = "add | valid">
        <div class="uk-form-row">
            <div class="uk-grid" data-uk-margin>
                <div class="uk-width-large-2-3">
                    <input class="uk-input-large"
                           type="text"
                           placeholder="{{ 'URL' | trans }}"
                           name="url"
                           v-model="newUrl.url"
                           v-validate:required>
                    <p class="uk-form-help-block uk-text-danger" v-show="formUrl.value.invalid">
                        {{ 'Invalid value.' | trans }}</p>
                </div>
                <div class="uk-width-large-1-3">
                    <div class="uk-form-controls">
                        <span class="uk-align-right">
                            <button class="uk-button" @click.prevent = "add | valid">
                                {{ 'Add' | trans }}
                            </button>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <hr/>
    <div class="uk-alert"
         v-if="!data.target.url.length">{{ 'You can add your first url using the input field above. Go ahead!' | trans }}
    </div>
    <div class="uk-form-row" v-if="data.target.url.length" v-for="url in data.target.url">
        <div class="uk-grid" data-uk-margin>
            <div class="uk-width-large-2-3">
                <input id="form-url{{$index}}" class="uk-input-large"
                       type="text"
                       placeholder="{{ 'URL' | trans }}"
                       v-model="url.url">
            </div>
            <div class="uk-width-large-1-3">
                <span class="uk-align-right">
                    <button class="uk-button uk-button-danger" @click.prevent = "remove(url)">
                        <i class="uk-icon-remove"></i>
                    </button>
                </span>
            </div>
        </div>
    </div>
</template>

<script>

module.exports = {

	section: {
		label: 'URL',
		priority: 100
	},

	props: ['data'],

	data: function () {
		return {
			data: this.data,
			newUrl: {
				'url': ''
			}
		}
	},

	methods: {
		add: function add(e) {

			e.preventDefault();
			if (!this.newUrl || !this.newUrl.url) return;
			this.data.target.url.push({
				url: this.newUrl.url
			});

			this.newUrl = {
				url: ''
			};

		},
		remove: function (url) {
			this.data.target.url.$remove(url);
		}
	}
};

window.redirecttarget.components['target-url'] = module.exports;

</script>