<template>
	<v-container>
		<v-row class="flex-column" v-if="!order">
			<v-text-field v-model="trackingId" label="Tracking ID"></v-text-field>
			<v-btn color="primary" :href="`/check/${trackingId}`"> Check Order</v-btn>
		</v-row>
		<v-container v-if="order">
			<v-row style="width: 100%" class="justify-center">
				<div class="text-h2">Hello, {{ order.customer_name }}</div>
			</v-row>
			<v-row style="width: 100%" class="justify-center flex-column">
				<div class="text-h4" align="center">
					{{ currentStatus.string }}
					<span :class="`${currentStatus.color}--text`">
						{{ currentStatus.status }}
					</span>
				</div>
				<div class="text-subtitle-1" align="center">
					{{ currentStatus.subtitle }}
				</div>
			</v-row>
			<v-row class="justify-center mt-5">
				<div class="text-h5">Item Details</div>
			</v-row>
			<v-row class="justify-center">
				<order-details :item="order.orderable"></order-details>
			</v-row>
		</v-container>
	</v-container>
</template>

<script>
import Layout from "./../../Shared/Layout";
import ShopLayout from "./../../Shared/ShopLayout";
import OrderDetails from "../../components/order/OrderDetails";

export default {
	components: { OrderDetails },
	props: ["content", "order"],
	computed: {
		currentStatus() {
			return this.status.filter((s) => s.status == this.order.status)[0];
		},
	},

	layout: (h, page) => {
		return h(Layout, [h(ShopLayout, [page])]);
	},

	data: () => ({
		trackingId: "",
		status: [
			{
				status: "Pending",
				string: "Your order is currently ",
				subtitle:
					"Please wait warmly as we process your order. We will contact your messenger when we've accepted your order.",
				color: "warning",
			},
			{
				status: "Rejected",
				string: "Our apologies, but your order has been ",
				subtitle: "",
				color: "error",
			},
			{
				status: "Accepted",
				string: "Your order has been ",
				subtitle: "Please wait warmly as we make your keyboard.",
				color: "success",
			},
			{
				status: "Delivered",
				string: "Your order has been ",
				subtitle: "Enjoy your keyboard!",
				color: "primary",
			},
		],
	}),
};
</script>
