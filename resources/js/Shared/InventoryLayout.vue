<template>
	<v-container fill-height ma-0 class="align-start">
		<v-row>
			<v-col cols="2">
				<v-navigation-drawer permanent class="primary">
					<v-list-item link @click="inertiaVisit('/inventory')">
						<v-list-item-content>
							<v-list-item-title class="title"> Inventory </v-list-item-title>
						</v-list-item-content>
					</v-list-item>

					<v-divider></v-divider>

					<v-list nav>
						<v-list-item
							v-for="item in items"
							:key="item.title"
							link
							text
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
					</v-container>
					<slot v-if="!page_status" />
				</v-container>
			</v-col>
		</v-row>
		<v-footer absolute> HEllo </v-footer>
	</v-container>
</template>

<script>
import { Inertia } from "@inertiajs/inertia";

export default {
	computed: {
		page_status: function () {
			return this.$parent.$parent.$parent.page_status;
		},
	},

	mounted() {},

	data() {
		return {
			items: [
				{ title: "Components", link: "/inventory/components" },
				{ title: "Catalog", link: "/inventory/catalog" },
				{ title: "Orders", link: "/inventory/orders" },
				{ title: "About & FAQs", link: "/inventory/about_faqs" },
			],
			right: null,
			overlay: true,
		};
	},

	methods: {},
};
</script>

<style>
.full-height {
	height: 80vh;
}
</style>
