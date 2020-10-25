<template>
	<v-container fill-height ma-0 class="align-start full-height">
		<v-row class="full-height">
			<v-col cols="2" fill-height>
				<v-navigation-drawer permanent class="pink darken-4 full-height">
					<v-list-item link @click="inertiaVisit('/inventory')">
						<v-list-item-content>
							<v-list-item-title class="title">
								Inventory
							</v-list-item-title>
							<v-list-item-subtitle>
								Notifications!
							</v-list-item-subtitle>
						</v-list-item-content>
					</v-list-item>

					<v-divider></v-divider>

					<v-list nav>
						<v-list-item
							v-for="item in items"
							:key="item.title"
							link
							@click="inertiaVisit(item.link)"
						>
							<v-list-item-content>
								<v-list-item-title>{{ item.title }}</v-list-item-title>
							</v-list-item-content>
						</v-list-item>
					</v-list>
				</v-navigation-drawer>
			</v-col>

			<v-col cols="10">
				<v-container class="scroll">
					<v-container
						v-if="page_status"
						fill-height
						class="align-center justify-center flex-column"
					>
						<v-progress-circular
							indeterminate
							:size="300"
							:width="10"
							color="primary"
						></v-progress-circular>
						<!-- <h1 class="display-1 mt-2">Loading...</h1> -->
					</v-container>
					<slot v-if="!page_status" />
				</v-container>
			</v-col>
		</v-row>
		<v-footer absolute>
			HEllo
		</v-footer>
	</v-container>
</template>

<script>
import { Inertia } from "@inertiajs/inertia";

export default {
	computed: {
		page_status: function() {
			return this.$parent.$parent.$parent.page_status;
		}
		// flashMessage(){
		//   return !!this.$page.props.flash.success;
		// },
	},

	mounted() {},

	data() {
		return {
			items: [
				{ title: "Components", link: "/inventory/components" },
				{ title: "Keyboards", link: "/inventory/keyboards" },
				{ title: "Prebuilt Orders", link: "/inventory/prebuilt_orders" },
				{ title: "Custom Orders", link: "/inventory/custom_orders" }
			],
			right: null,
			overlay: true
		};
	},

	methods: {}
};
</script>

<style></style>
