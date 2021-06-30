<template>
	<v-app>
		<v-snackbar
			v-model="flash_success"
			color="success"
			top
			pa-4
			transition="slide-y-transition"
		>
			<span class="black--text">{{ $page.props.flash.success }}</span>
		</v-snackbar>
		<v-snackbar
			v-model="flash_error"
			color="error"
			top
			pa-4
			vertical
			transition="slide-y-transition"
		>
			<!-- <span v-for="err in $page.props.error" v-bind:key="err">
				<v-list-item v-for="message in err" v-bind:key="message">
					<v-list-item-content>{{ message[0] }}</v-list-item-content>
				</v-list-item>
			</span> -->
			<span v-for="bag in $page.props.flash.errors" v-bind:key="bag.bag">
				<span v-for="message in bag.message" v-bind:key="message.name">
					<v-list-item v-for="err in message.content" v-bind:key="err">
						{{ err }}
					</v-list-item>
				</span>
			</span>
		</v-snackbar>
		<v-app-bar
			dark
			app
			shrink-on-scroll
			prominent
			src="http://d1bn13w6l50iio.cloudfront.net/static/header.jpg"
			v-bind:class="[page_status ? '' : 'mb-2']"
		>
			<template v-slot:img="{ props }">
				<v-img
					v-bind="props"
					gradient="to top right, rgba(0,0,0,.4), rgba(0,0,0,.7)"
				></v-img>
			</template>
			<v-toolbar-title>Custom Mech KBD</v-toolbar-title>
			<v-spacer></v-spacer>
			<v-toolbar-items>
				<v-btn @click="inertiaVisit('/')" text> Home </v-btn>
				<v-btn @click="inertiaVisit('/shop')" text> Shop </v-btn>
				<v-btn @click="inertiaVisit('/custom')" text> Custom </v-btn>
				<v-btn @click="inertiaVisit('/about')" text> About Us </v-btn>
				<v-btn @click="inertiaVisit('/faq')" text> FAQ </v-btn>
				<v-btn @click="inertiaVisit('/check')" text> Check </v-btn>
				<v-menu offset-x offset-y open-on-hover>
					<template v-slot:activator="{ on, attrs }">
						<v-btn
							text
							v-if="$page.props['auth.user']"
							v-bind="attrs"
							v-on="on"
							@click="inertiaVisit('/inventory/components')"
						>
							Welcome, {{ $page.props["auth.user"].name }}
						</v-btn>
					</template>
					<v-list>
						<v-list-item link @click="inertiaVisit('/inventory/components')">
							<v-list-item-title>Components</v-list-item-title>
						</v-list-item>
						<v-list-item link @click="inertiaVisit('/inventory/catalog')">
							<v-list-item-title>Prebuilt Orders</v-list-item-title>
						</v-list-item>
						<v-list-item link @click="inertiaVisit('/inventory/orders')">
							<v-list-item-title>Orders</v-list-item-title>
						</v-list-item>
						<v-list-item link @click="inertiaVisit('/inventory/about_faqs')">
							<v-list-item-title>About & FAQs</v-list-item-title>
						</v-list-item>
						<v-list-item link @click="logoutUser">
							<v-list-item-title>Logout</v-list-item-title>
						</v-list-item>
					</v-list>
				</v-menu>
			</v-toolbar-items>
		</v-app-bar>
		<v-main class="overflow-y-hidden main">
			<slot />
		</v-main>
	</v-app>
</template>

<script>
import { Inertia } from "@inertiajs/inertia";
import axios from "axios";

export default {
	data: () => ({
		page_status: true,
		app_bar_img_url: "https://cdn.vuetifyjs.com/images/backgrounds/vbanner.jpg",
		flash_success: false,
		flash_error: false,
	}),

	mounted() {
		axios
			.get("https://api.unsplash.com/photos/4IxPVkFGJGI", {
				headers: {
					Authorization:
						"Client-ID 3LkI5pmvOcEs72PtTZFbsnoX_n2jDpBDa0JOXh4OJbU",
				},
			})
			.then((response) => {
				// this.app_bar_img_url = response.data.urls.full;
				this.page_status = false;
			});

		Inertia.on("start", (event) => {
			this.page_status = true;
		});
		Inertia.on("success", (event) => {
			this.flash_success = !!this.$page.props.flash.success;
			this.flash_error = Object.keys(this.$page.props.error).length != 0;
			this.page_status = false;
		});
	},

	methods: {
		logoutUser: function () {
			axios.post("/logout");
			Inertia.visit("/");
		},
	},
};
</script>

<style></style>
