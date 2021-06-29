<template>
	<v-data-table
		:headers="headers"
		:items="tableItems"
		class="w-100"
		item-key="id"
		show-expand
		show-select
		:expanded.sync="expanded"
		@click:row="expand"
	>
		<template v-slot:top="">
			<v-toolbar class="mb-2">
				<v-toolbar-title class="mr-8">Orders</v-toolbar-title>

				<v-toolbar-items> </v-toolbar-items>
			</v-toolbar>
		</template>
	</v-data-table>
</template>

<script>
import { Inertia } from "@inertiajs/inertia";

export default {
	components: {},
	computed: {
		tableItems() {
			return this.orders;
		},
	},
	props: ["orders"],
	data() {
		return {
			selected: [],
			expanded: [],
			headers: [
				{
					text: "Customer Name",
					value: "customer_name",
				},
				{
					text: "Messenger",
					value: "messenger_name",
				},
				{
					text: "Tracking ID",
					value: "tracking_id",
				},
				{
					text: "Status",
					value: "status",
				},
				{
					text: "Actions",
					value: "",
				},
			],
		};
	},
	methods: {
		expand(item) {
			if (this.expanded.includes(item)) {
				this.expanded.splice(this.expanded.indexOf(item), 1);
			} else this.expanded.push(item);
		},
	},
};
</script>

<style></style>
