<template>
    <div class="uk-grid pk-grid-large pk-width-sidebar-large uk-form-stacked" data-uk-grid-margin>
        <div class="pk-width-content">
            <div class="uk-form-row">
                <input class="uk-width-1-1 uk-form-large" type="text" name="title" :placeholder="'Enter Title' | trans"
                       v-model="target.title" v-validate:required>
                <p class="uk-form-help-block uk-text-danger"
                   v-show="form.title.invalid">{{ 'Title cannot be blank.' | trans }}</p>
            </div>
            <div class="uk-form-row">
                <input class="uk-width-1-1 uk-form-large" type="text" name="url" :placeholder="'Enter Target URL' | trans"
                       v-model="target.target_url" v-validate:required>
                <p class="uk-form-help-block uk-text-danger"
                   v-show="form.url.invalid">{{ 'Target URL cannot be blank.' | trans }}</p>
            </div>
        </div>
        <div class="pk-width-sidebar">
            <div class="uk-panel">
                <div class="uk-form-row">
                    <label for="form-slug" class="uk-form-label">{{ 'Slug' | trans }}</label>
                    <div class="uk-form-controls">
                        <input id="form-slug" class="uk-width-1-1" type="text" v-model="target.slug">
                    </div>
                </div>
                <div class="uk-form-row">
                    <label for="form-status" class="uk-form-label">{{ 'Status' | trans }}</label>
                    <div class="uk-form-controls">
                        <select id="form-status" class="uk-width-1-1" v-model="target.status">
                            <option v-for="(id, status) in data.statuses" :value="id">{{status}}</option>
                        </select>
                    </div>
                </div>
                <div class="uk-form-row">
                    <label for="form-response" class="uk-form-label">{{ 'HTTP Response' | trans }}</label>
                    <div class="uk-form-controls">
                        <select id="form-response" class="uk-form-width-large" v-model="target.data.response">
                            <option value="301">{{ '301' | trans }}</option>
                            <option value="302">{{ '302' | trans }}</option>
                            <option value="307">{{ '307' | trans }}</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

module.exports = {

	props: ['target', 'data', 'form'],

	section: {
		label: 'Target'
	}

};

</script>