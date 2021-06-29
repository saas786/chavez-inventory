<template>
	<v-data-table
		:headers="headers"
		single-select
		item-key="id"
		show-expand
		show-select
		:expanded.sync="expanded"
		@click:row="expand"
	>
		<template v-slot:top="props">
			<v-toolbar class="mb-2">
				<v-toolbar-title class="mr-8">Orders</v-toolbar-title>

				<v-toolbar-items> </v-toolbar-items>
			</v-toolbar>
		</template>

		<template v-slot:expanded-item="{ item }">
			<td colspan="6">
				<catalog-item-details
					:components="components"
					:item="item"
				></catalog-item-details>
			</td>
		</template>
	</v-data-table>
</template>

<script>
import { Inertia } from "@inertiajs/inertia";

export default {
	components: {},
	computed: {},
	props: [],
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
					value: "messenger",
				},
				{
					text: "Tracking ID",
					value: "track_id",
				},
				{
					text: "Status",
					value: "status",
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
