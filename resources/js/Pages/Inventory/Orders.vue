<template>
	<v-container fill-height> Hello </v-container>
</template>

<script>
import InventoryLayout from "./../../Shared/InventoryLayout";
import Layout from "./../../Shared/Layout";

export default {
	props: ["orders"],

	layout: (h, page) => {
		return h(Layout, [h(InventoryLayout, [page])]);
	},
};
</script>
