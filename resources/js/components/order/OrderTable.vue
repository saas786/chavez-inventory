<template>
	<v-data-table
		:headers="headers"
		:items="tableItems"
		style="width: 100%"
		item-key="id"
		show-expand
		show-select
		:expanded.sync="expanded"
	>
		<!-- Get rid of select all -->
		<template v-slot:header.data-table-select> </template>
		<!-- Select Option -->
		<template v-slot:item.data-table-select="{ item }">
			<v-checkbox v-model="selected" :value="item.id"></v-checkbox>
		</template>

		<!-- Top Bar -->
		<template v-slot:top="">
			<v-toolbar class="mb-2">
				<v-toolbar-title class="mr-8">Orders</v-toolbar-title>

				<v-toolbar-items>
					<v-dialog max-width="500">
						<template v-slot:activator="{ on, attrs }">
							<v-btn text v-bind="attrs" v-on="on" color="primary"
								>Update Status</v-btn
							>
						</template>
						<v-card>
							<v-card-title>Are you sure?</v-card-title>
							<v-card-text>
								<v-select
									:items="statusOptions"
									label="Status"
									v-model="status"
								></v-select>

								You have selected
								<span class="primary--text">{{ selected.length }}</span>
								items
							</v-card-text>
							<v-card-actions class="justify-center">
								<v-btn
									:color="statusColor"
									:disabled="selected.length == 0 || status == ''"
									@click="updateStatus"
									>Update</v-btn
								>
							</v-card-actions>
						</v-card>
					</v-dialog>
				</v-toolbar-items>
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
		statusColor() {
			const options = {
				Pending: "warning",
				Rejected: "error",
				Accepted: "success",
				Delivered: "primary",
			};

			console.log(options[this.status]);

			return options[this.status];
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
			],
			status: "",
			statusOptions: ["Pending", "Rejected", "Accepted", "Delivered"],
		};
	},
	methods: {
		expand(item) {
			if (this.expanded.includes(item)) {
				this.expanded.splice(this.expanded.indexOf(item), 1);
			} else this.expanded.push(item);
		},
		updateStatus() {
			Inertia.post("/inventory/orders/status", {
				ids: this.selected,
				value: this.status,
			});
		},
	},
};
</script>

<style></style>
