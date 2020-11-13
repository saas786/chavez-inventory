/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require("./bootstrap");

import { App, plugin } from "@inertiajs/inertia-vue";
import Vue from "vue";
import vuetify from "./plugins/vuetify";
import { Inertia } from "@inertiajs/inertia";
import VCurrencyField from "v-currency-field";

Vue.use(plugin);
// Vue.use(Vuetify)

//Import v-currency-field
Vue.use(VCurrencyField, {
	locale: "en-US",
	decimalLength: 2,
	autoDecimalMode: true,
	min: null,
	max: null,
	defaultValue: 0,
	valueAsInteger: false,
	allowNegative: true,
});

Vue.mixin({
	methods: {
		inertiaVisit: function (link) {
			Inertia.visit(link);
		},
		inertiaMessages() {
			let message = {};
			return messages;
		},
		laravelErrorBag(field, errorBag = "default") {
			if (!this.$page.props.error.hasOwnProperty(errorBag)) {
				return null;
			}

			if (this.$page.props.error[errorBag].hasOwnProperty(field)) {
				return this.$page.props.error[errorBag][field][0];
			}

			return null;
		},
	},
});

const el = document.getElementById("app");

new Vue({
	vuetify,
	render: (h) =>
		h(App, {
			props: {
				initialPage: JSON.parse(el.dataset.page),
				resolveComponent: (name) => require(`./Pages/${name}`).default,
			},
		}),
}).$mount(el);
