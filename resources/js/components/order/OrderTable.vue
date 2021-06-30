<template>
	<v-data-table
		:headers="headers"
		:items="tableItems"
		class="w-100"
		item-key="id"
		show-expand
		style="width: 100%"
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

		<!-- Custom Template for Type of Order -->
		<template v-slot:item.orderable_type="{ item }">
			<td>
				{{
					item.orderable_type == "App\\Models\\CustomOrder"
						? "Custom"
						: "Prebuilt"
				}}
			</td>
		</template>

		<!-- Custom Template for Messenger Name -->
		<template v-slot:item.messenger_name="{ item }">
			<td>
				<v-tooltip bottom>
					<template v-slot:activator="{ on, attrs }">
						<a
							v-bind="attrs"
							v-on="on"
							class="app-link text-decoration-none"
							target="_blank"
							:href="`https://www.facebook.com/${item.messenger_name}`"
							>{{ item.messenger_name }}</a
						>
					</template>
					<span>Contact on facebook</span>
				</v-tooltip>
			</td>
		</template>

		<!-- Template for Expanded Rows -->
		<template v-slot:expanded-item="{ headers, item }">
			<td :colspan="headers.length">
				<order-details :item="item.orderable"></order-details>
				<!-- <component
					:is="
						item.orderable_type == `App\\Models\\CustomOrder`
							? `div`
							: `PrebuiltKeyboardDetails`
					"
					:item="item.orderable"
					readonly
				>
				</component> -->
			</td>
		</template>
	</v-data-table>
</template>

<script>
import { Inertia } from "@inertiajs/inertia";
import OrderDetails from "./OrderDetails";

export default {
	components: { OrderDetails },
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
					text: "Type",
					value: "orderable_type",
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
