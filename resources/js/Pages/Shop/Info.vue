<template>
	<div v-html="content"></div>
</template>

<script>
import Layout from "./../../Shared/Layout";
import ShopLayout from "./../../Shared/ShopLayout";

export default {
	props: ["content"],

	layout: (h, page) => {
		return h(Layout, [h(ShopLayout, [page])]);
	},

	mounted() {},
};
</script>
