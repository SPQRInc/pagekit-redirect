<?php $view->script( 'statistic-index', 'spqr/redirect:app/bundle/statistic-index.js', 'vue' ); ?>

<div id="statistics" class="uk-form" v-cloak>
    <div class="uk-margin uk-flex uk-flex-space-between uk-flex-wrap" data-uk-margin>
        <div class="uk-flex uk-flex-middle uk-flex-wrap" data-uk-margin>
	        <template v-if="!selected.length">
	            <h2 class="uk-margin-remove">{{ '{0} %count% Statistics|{1} %count% Statistic|]1,Inf[ %count% Statistics' | transChoice count {count:count} }}</h2>
		        <div class="uk-margin-left">
			        <ul class="uk-subnav pk-subnav-icon">
				        <li>
					        <a class="pk-icon-delete pk-icon-hover"
					           title="Delete all"
					           data-uk-tooltip="{delay: 500}"
					           @click="purge" v-confirm="'Delete all
					           Statistics?'"></a>
				        </li>
			        </ul>
		        </div>
	        </template>
            <template v-else>
                <h2 class="uk-margin-remove">{{ '{1} %count% Statistic selected|]1,Inf[ %count% Statistics selected' | transChoice selected.length {count:selected.length} }}</h2>
                <div class="uk-margin-left">
                    <ul class="uk-subnav pk-subnav-icon">
                        <li>
                            <a class="pk-icon-delete pk-icon-hover"
                               title="Delete"
                               data-uk-tooltip="{delay: 500}"
                               @click="remove" v-confirm="'Delete Statistics?'"></a>
                        </li>
                    </ul>
                </div>
            </template>
            <div class="pk-search">
                <div class="uk-search">
                    <input class="uk-search-field" type="text" v-model="config.filter.search" debounce="300">
                </div>
            </div>
        </div>
    </div>
    <div class="uk-overflow-container">
        <table class="uk-table uk-table-hover uk-table-middle">
            <thead>
            <tr>
                <th class="pk-table-width-minimum">
                    <input type="checkbox" v-check-all:selected.literal="input[name=id]" number></th>
                <th class="pk-table-min-width-200">{{ 'Target' | trans }}
                </th>
                <th class="pk-table-min-width-200">{{ 'URL' | trans }}
                </th>
                <th class="pk-table-min-width-200"
                    v-order:type="config.filter.order">{{ 'Type' | trans }}
                </th>
                <th class="pk-table-min-width-200"
                    v-order:date="config.filter.order">{{ 'Date' | trans }}
                </th>
            </tr>
            </thead>
            <tbody>
            <tr class="check-item" v-for="statistic in statistics" :class="{'uk-active': active(statistic)}">
                <td><input type="checkbox" name="id" :value="statistic.id"></td>
                <td>
                    <a :href="$url.route('admin/redirect/statistic/edit', {
                    id: statistic.id })">{{ statistic.target ? statistic.target.title :  'Not defined' | trans }}</a>
                </td>
                <td>
	                <ul class="uk-list uk-list-space">
		                <li><span class="uk-badge">{{ 'Called Url' | trans }}</span> {{ statistic.called_url ? statistic.called_url :  'Not defined' | trans }}</li>
		                <li><span class="uk-badge">{{ 'Url' | trans }}</span> {{ statistic.url.url ? statistic.url.url :  'Not defined' | trans }}</li>
	                </ul>
                </td>
                <td>
                    {{ statistic.response }}
                </td>
                <td>
                    {{ statistic.date | date }}
                </td>
            </tr>
            </tbody>
        </table>
    </div>
    
    <h3 class="uk-h1 uk-text-muted uk-text-center"
        v-show="statistics && !statistics.length">{{ 'No Statistics found.' | trans }}</h3>
    <v-pagination :page.sync="config.page" :pages="pages" v-show="pages > 1 || page > 0"></v-pagination>
</div>