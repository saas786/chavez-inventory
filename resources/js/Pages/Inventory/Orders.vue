<template>
	<v-container fill-height>
		<order-table></order-table>
	</v-container>
</template>

<script>
import OrderTable from "../../components/order/OrderTable.vue";
import InventoryLayout from "./../../Shared/InventoryLayout";
import Layout from "./../../Shared/Layout";

export default {
	props: ["orders"],

	components: { OrderTable },

	layout: (h, page) => {
		return h(Layout, [h(InventoryLayout, [page])]);
	},
};
</script>
