<?php $view->script('settings', 'spqr/redirect:app/bundle/settings.js', [
    'vue',
    'input-link',
    'editor'
]); ?>

<div id="settings" class="uk-form uk-form-horizontal" v-cloak>
	<div class="uk-grid pk-grid-large" data-uk-grid-margin>
		<div class="pk-width-sidebar">
			<div class="uk-panel">
				<ul class="uk-nav uk-nav-side pk-nav-large"
				    data-uk-tab="{ connect: '#tab-content' }">
					<li>
						<a><i class="pk-icon-large-settings uk-margin-right"></i> {{ 'General' | trans }}</a>
					</li>
					<li>
						<a><i class="pk-icon-large-pin uk-margin-right"></i> {{	'Redirection' | trans }}</a>
					</li>
					<li>
						<a><i class="uk-icon-bar-chart uk-margin-right"></i> {{ 'Statistics' | trans }}</a>
					</li>
					<li>
						<a><i class="pk-icon-large-lock-file uk-margin-right"></i> {{ 'Exclusions' | trans }}</a>
					</li>
					<li><a><i class="pk-icon-large-cone uk-margin-right"></i> {{ 'Info' | trans }}</a></li>
				</ul>
			</div>
		</div>
		<div class="pk-width-content">
			<ul id="tab-content" class="uk-switcher uk-margin">
				<li>
					<div class="uk-margin uk-flex uk-flex-space-between uk-flex-wrap"
					     data-uk-margin>
						<div data-uk-margin>
							<h2 class="uk-margin-remove">{{ 'General' | trans }}</h2>
						</div>
						<div data-uk-margin>
							<button class="uk-button uk-button-primary"
							        @click.prevent="save">{{ 'Save' | trans }}
							</button>
						</div>
					</div>
					<div class="uk-form-row">
						<label for="form-response" class="uk-form-label">{{ 'Default Response' | trans }}</label>
						<div class="uk-form-controls">
							<select id="form-response"
							        class="uk-form-width-medium"
							        v-model="config.response">
								<option value="301">{{ '301' | trans }}</option>
								<option value="302">{{ '302' | trans }}</option>
								<option value="307">{{ '307' | trans }}</option>
							</select>
						</div>
					</div>
				</li>
				<li>
					<div class="uk-margin uk-flex uk-flex-space-between uk-flex-wrap"
					     data-uk-margin>
						<div data-uk-margin>
							<h2 class="uk-margin-remove">{{ 'Redirection' | trans }}</h2>
						</div>
						<div data-uk-margin>
							<button class="uk-button uk-button-primary"
							        @click.prevent="save">{{ 'Save' | trans }}
							</button>
						</div>
					</div>
					<div class="uk-form-row uk-margin">
						<label class="uk-form-label">{{ 'Enable Unauthorized Handling' | trans }}</label>
						<div class="uk-form-controls uk-form-controls-text">
							<input type="checkbox"
							       v-model="config.unauthorized.enabled">
						</div>
					</div>
					<div v-if="config.unauthorized.enabled">
						<div class="uk-form-row uk-margin">
							<label for="form-unauthorized-frontend-only"
							       class="uk-form-label">{{ 'Activate On Frontend Only' | trans }}</label>
							<div class="uk-form-controls uk-form-controls-text">
								<input id="form-form-unauthorized-frontend-only" type="checkbox"
								       v-model="config.unauthorized.frontend_only">
							</div>
						</div>
						<div class="uk-form-row uk-margin">
							<label for="form-unauthorized-type"
							       class="uk-form-label">{{ 'Type' | trans }}</label>
							<div class="uk-form-controls">
								<select id="form-unauthorized-type"
								        class="uk-form-width-large" v-model="config.unauthorized.type">
									<option value="redirect">{{ 'Redirect' | trans }}</option>
									<option value="html">{{ 'Show HTML' | trans }}</option>
								</select>
							</div>
						</div>
						<div class="uk-form-row uk-margin"
						     v-if="config.unauthorized.type == 'redirect'">
							<label for="form-redirect-unauthorized"
							       class="uk-form-label">{{ 'Unauthorized URL' | trans }}</label>
							<div class="uk-form-controls">
								<input-link id="form-redirect-unauthorized"
								            class="uk-form-width-medium"
								            :link.sync="config.unauthorized.url"></input-link>
							</div>
						</div>
						<div class="uk-form-row" v-if="config.unauthorized.type == 'redirect'">
							<label for="form-unauthorized-response"
							       class="uk-form-label">{{ 'Response' | trans }}</label>
							<div class="uk-form-controls">
								<select id="form-unauthorized-response"
								        class="uk-form-width-large" v-model="config.unauthorized.response">
									<option value="301">{{ '301' | trans }}</option>
									<option value="302">{{ '302' | trans }}</option>
									<option value="307">{{ '307' | trans }}</option>
								</select>
							</div>
						</div>
						<div class="uk-form-row uk-margin"  v-if="config.unauthorized.type == 'html'">
							<label class="uk-form-label">{{ 'HTML' | trans }}</label>
							<div class="uk-form-controls uk-form-controls-text">
								<v-editor type="code" :value.sync="config.unauthorized.html"></v-editor>
							</div>
						</div>
						<div class="uk-form-row uk-margin" v-if="config.unauthorized.type == 'html'">
							<label for="form-unauthorized-response"
							       class="uk-form-label">{{ 'Response' | trans }}</label>
							<div class="uk-form-controls">
								<select id="form-unauthorized-response"
								        class="uk-form-width-large" v-model="config.unauthorized.response">
									<option value="401">{{ '401' | trans }}</option>
									<option value="403">{{ '403' | trans }}</option>
									<option value="404">{{ '404' | trans }}</option>
									<option value="410">{{ '410' | trans }}</option>
									<option value="418">{{ '418' | trans }}</option>
									<option value="451">{{ '451' | trans }}</option>
								</select>
							</div>
						</div>
					</div>
					<div class="uk-form-row uk-margin">
						<label class="uk-form-label">{{ 'Enable Forbidden Handling' |	trans }}</label>
						<div class="uk-form-controls uk-form-controls-text">
							<input type="checkbox"
							       v-model="config.forbidden.enabled">
						</div>
					</div>
					<div v-if="config.forbidden.enabled">
						<div class="uk-form-row uk-margin">
							<label for="form-forbidden-frontend-only"
							       class="uk-form-label">{{ 'Activate On Frontend Only' | trans }}</label>
							<div class="uk-form-controls uk-form-controls-text">
								<input id="form-form-forbidden-frontend-only"
								       type="checkbox"
								       v-model="config.forbidden.frontend_only">
							</div>
						</div>
						<div class="uk-form-row uk-margin">
							<label for="form-forbidden-type"
							       class="uk-form-label">{{ 'Type' | trans }}</label>
							<div class="uk-form-controls">
								<select id="form-forbidden-type"
								        class="uk-form-width-large"
								        v-model="config.forbidden.type">
									<option value="redirect">{{ 'Redirect' | trans }}</option>
									<option value="html">{{ 'Show HTML' | trans }}</option>
								</select>
							</div>
						</div>
						<div class="uk-form-row uk-margin"
						     v-if="config.forbidden.type == 'redirect'">
							<label for="form-redirect-forbidden"
							       class="uk-form-label">{{ 'Forbidden URL' | trans }}</label>
							<div class="uk-form-controls">
								<input-link id="form-redirect-forbidden"
								            class="uk-form-width-medium"
								            :link.sync="config.forbidden.url"></input-link>
							</div>
						</div>
						<div class="uk-form-row uk-margin" v-if="config.forbidden.type == 'redirect'">
							<label for="form-forbidden-response"
							       class="uk-form-label">{{ 'Response' | trans }}</label>
							<div class="uk-form-controls">
								<select id="form-forbidden-response"
								        class="uk-form-width-large"
								        v-model="config.forbidden.response">
									<option value="301">{{ '301' | trans }}</option>
									<option value="302">{{ '302' | trans }}</option>
									<option value="307">{{ '307' | trans }}</option>
								</select>
							</div>
						</div>
						<div class="uk-form-row uk-margin"  v-if="config.forbidden.type == 'html'">
							<label class="uk-form-label">{{ 'HTML' | trans }}</label>
							<div class="uk-form-controls uk-form-controls-text">
								<v-editor type="code" :value.sync="config.forbidden.html"></v-editor>
							</div>
						</div>
						<div class="uk-form-row" v-if="config.forbidden.type ==	'html'">
							<label for="form-forbidden-response"
							       class="uk-form-label">{{ 'Response' | trans }}</label>
							<div class="uk-form-controls">
								<select id="form-forbidden-response"
								        class="uk-form-width-large"
								        v-model="config.forbidden.response">
									<option value="401">{{ '401' | trans }}</option>
									<option value="403">{{ '403' | trans }}</option>
									<option value="404">{{ '404' | trans }}</option>
									<option value="410">{{ '410' | trans }}</option>
									<option value="418">{{ '418' | trans }}</option>
									<option value="451">{{ '451' | trans }}</option>
								</select>
							</div>
						</div>
					</div>
					<div class="uk-form-row uk-margin">
						<label class="uk-form-label">{{ 'Enable Notfound Handling' |	trans }}</label>
						<div class="uk-form-controls uk-form-controls-text">
							<input type="checkbox"
							       v-model="config.notfound.enabled">
						</div>
					</div>
					<div v-if="config.notfound.enabled">
						<div class="uk-form-row uk-margin">
							<label for="form-notfound-frontend-only"
							       class="uk-form-label">{{ 'Activate On Frontend Only' | trans }}</label>
							<div class="uk-form-controls uk-form-controls-text">
								<input id="form-form-notfound-frontend-only"
								       type="checkbox"
								       v-model="config.notfound.frontend_only">
							</div>
						</div>
						<div class="uk-form-row uk-margin">
							<label for="form-notfound-type"
							       class="uk-form-label">{{ 'Type' | trans }}</label>
							<div class="uk-form-controls">
								<select id="form-notfound-type"
								        class="uk-form-width-large"
								        v-model="config.notfound.type">
									<option value="redirect">{{ 'Redirect' | trans }}</option>
									<option value="html">{{ 'Show HTML' | trans }}</option>
								</select>
							</div>
						</div>
						<div class="uk-form-row uk-margin"
						     v-if="config.notfound.type == 'redirect'">
							<label for="form-redirect-notfound"
							       class="uk-form-label">{{ 'Notfound URL' | trans }}</label>
							<div class="uk-form-controls">
								<input-link id="form-redirect-notfound"
								            class="uk-form-width-medium"
								            :link.sync="config.notfound.url"></input-link>
							</div>
						</div>
						<div class="uk-form-row uk-margin" v-if="config.notfound.type == 'redirect'">
							<label for="form-notfound-response"
							       class="uk-form-label">{{ 'Response' | trans }}</label>
							<div class="uk-form-controls">
								<select id="form-notfound-response"
								        class="uk-form-width-large"
								        v-model="config.notfound.response">
									<option value="301">{{ '301' | trans }}</option>
									<option value="302">{{ '302' | trans }}</option>
									<option value="307">{{ '307' | trans }}</option>
								</select>
							</div>
						</div>
						<div class="uk-form-row uk-margin"  v-if="config.notfound.type == 'html'">
							<label class="uk-form-label">{{ 'HTML' | trans }}</label>
							<div class="uk-form-controls uk-form-controls-text">
								<v-editor type="code" :value.sync="config.notfound.html"></v-editor>
							</div>
						</div>
						<div class="uk-form-row uk-margin" v-if="config.notfound.type == 'html'">
							<label for="form-notfound-response"
							       class="uk-form-label">{{ 'Response' | trans }}</label>
							<div class="uk-form-controls">
								<select id="form-notfound-response"
								        class="uk-form-width-large"
								        v-model="config.notfound.response">
									<option value="401">{{ '401' | trans }}</option>
									<option value="403">{{ '403' | trans }}</option>
									<option value="404">{{ '404' | trans }}</option>
									<option value="410">{{ '410' | trans }}</option>
									<option value="418">{{ '418' | trans }}</option>
									<option value="451">{{ '451' | trans }}</option>
								</select>
							</div>
						</div>
					</div>
				</li>
				<li>
					<div class="uk-margin uk-flex uk-flex-space-between uk-flex-wrap"
					     data-uk-margin>
						<div data-uk-margin>
							<h2 class="uk-margin-remove">{{ 'Statistics' | trans }}</h2>
						</div>
						<div data-uk-margin>
							<button class="uk-button uk-button-primary"
							        @click.prevent="save">{{ 'Save' | trans }}
							</button>
						</div>
					</div>
					<div class="uk-form-row">
						<label for="form-collectstatistics"
						       class="uk-form-label">{{ 'Collect Statistics' | trans }}</label>
						<div class="uk-form-controls uk-form-controls-text">
							<input id="form-collectstatistics" type="checkbox"
							       v-model="config.statistics.collect_statistics">
						</div>
					</div>
					<div v-if="config.statistics.collect_statistics"
					     class="uk-form-row">
						<label for="form-collectreferrer"
						       class="uk-form-label">{{ 'Collect Referrer' | trans }}</label>
						<div class="uk-form-controls uk-form-controls-text">
							<input id="form-collectreferrer" type="checkbox"
							       v-model="config.statistics.collect_referrer">
						</div>
					</div>
					<div v-if="config.statistics.collect_statistics"
					     class="uk-form-row">
						<label for="form-collectcalledurl"
						       class="uk-form-label">{{ 'Collect Called URL' | trans }}</label>
						<div class="uk-form-controls uk-form-controls-text">
							<input id="form-collectcalledurl" type="checkbox"
							       v-model="config.statistics.collect_called_url">
						</div>
					</div>
					<div v-if="config.statistics.collect_statistics"
					     class="uk-form-row">
						<label for="form-collectip"
						       class="uk-form-label">{{ 'Collect IPs' | trans }}</label>
						<div class="uk-form-controls uk-form-controls-text">
							<input id="form-collectip" type="checkbox"
							       v-model="config.statistics.collect_ip">
						</div>
					</div>
				</li>
				<li>
					<div class="uk-margin uk-flex uk-flex-space-between uk-flex-wrap"
					     data-uk-margin>
						<div data-uk-margin>
							<h2 class="uk-margin-remove">{{ 'Exclusions' | trans }}</h2>
						</div>
						<div data-uk-margin>
							<button class="uk-button uk-button-primary"
							        @click.prevent="save">{{ 'Save' | trans }}
							</button>
						</div>
					</div>
					<div class="uk-form-row">
						<label for="form-excludedextensions"
						       class="uk-form-label">{{ 'Excluded Extensions' | trans}}</label>
						<div class="uk-form-controls uk-form-controls-text">
							<p class="uk-form-controls-condensed">
								<a class="uk-button"
								   @click.prevent="editExcludedExtensions()"><i class="uk-icon-list"></i>
								</a>
							</p>
						</div>
					</div>
					<div class="uk-form-row">
						<label for="form-excludedextensions"
						       class="uk-form-label">{{ 'Excluded URLs' | trans}}</label>
						<div class="uk-form-controls uk-form-controls-text">
							<p class="uk-form-controls-condensed">
								<a class="uk-button"
								   @click.prevent="editExcludedUrls()"><i class="uk-icon-list"></i>
								</a>
							</p>
						</div>
					</div>
				</li>
				<li>
					<div class="uk-margin uk-flex uk-flex-space-between uk-flex-wrap"
					     data-uk-margin>
						<div data-uk-margin>
							<h2 class="uk-margin-remove">{{ 'Info' | trans }}</h2>
						</div>
						<div data-uk-margin>
							<button class="uk-button uk-button-primary"
							        @click.prevent="save">{{ 'Save' | trans }}
							</button>
						</div>
					</div>
					<div class="uk-form-row">
						<label class="uk-form-label">{{ 'Getting help' | trans }}</label>
						<div class="uk-form-controls uk-form-controls-text">
							<div class="uk-panel uk-panel-box">
								<p>{{ 'You have problems using this extension? Join the Pagekit community forum.' | trans }}</p>
								<a class="uk-button uk-width-1-1 uk-button-large"
								   href="https://pagekit-forum.org"
								   target="_blank">Pagekit Forum</a>
							</div>
						</div>
					</div>
					<div class="uk-form-row">
						<label class="uk-form-label">{{ 'Donate' | trans }}</label>
						<div class="uk-form-controls uk-form-controls-text">
							<div class="uk-panel uk-panel-box">
								<p>{{ 'Do you like my extensions? They are free. Of course I would like to get a donation, so if you want to, please open the donate link. You may find three possibilities to donate: PayPal, Patreon and Coinhive.' | trans }} </p>
								<a class="uk-button uk-button-large uk-width-1-1 uk-button-primary"
								   href="https://spqr.wtf/support-me"
								   target="_blank">{{ 'Donate' | trans }}</a>
							</div>
						</div>
					</div>
				</li>
			</ul>
		</div>
	</div>
	<v-modal v-ref:excludedextensions>
		<excludedextensions-list :config.sync="config" :form="form"></excludedextensions-list>
	</v-modal>
	<v-modal v-ref:excludedurls>
		<excludedurls-list :config.sync="config" :form="form"></excludedurls-list>
	</v-modal>
</div>