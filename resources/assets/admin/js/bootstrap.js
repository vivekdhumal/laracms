import Lodash from 'lodash';

import JQuery from 'jQuery';

import 'bootstrap-sass';

import Vue from 'vue';

import VueRouter from 'vue-router';

import Axios from 'axios';

import 'bootstrap-sass';

import 'sweetalert';

window._ = Lodash;

window.$ = window.jQuery = JQuery;

window.Vue = Vue;

Vue.use(VueRouter);

window.axios = Axios;

window.axios.defaults.headers.common = {
    'X-CSRF-TOKEN': window.Laravel.csrfToken,
    'X-Requested-With': 'XMLHttpRequest'
};

/* Creating custom event dispatcher *you can only listen and fire event through new vue instance */
window.Event = new class {
	constructor() {
		this.vue = new Vue();
	}

	fire(event, data = null) {
		this.vue.$emit(event, data);
	}

	listen(event, callback) {
		this.vue.$on(event, callback);
	}
};
