<template>
	<div style="height: 100%">
		<inertia-head>
			<title>Inventory</title>
		</inertia-head>
		<v-container class="mt-0 pt-0">
			<v-row class="flex-grow-1" style="height: 100%">
				<v-col cols="2" class="pt-0 mt-0" style="height: 100%">
					<v-navigation-drawer permanent class="primary">
						<v-list-item>
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
		</v-container>
		<v-footer absolute>Hello world</v-footer>
	</div>
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
