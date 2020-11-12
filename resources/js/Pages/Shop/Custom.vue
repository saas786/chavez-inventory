<template>
	<keyboard-customize :components="components"></keyboard-customize>
</template>

<script>
import Layout from "./../../Shared/Layout";
import ShopLayout from "./../../Shared/ShopLayout";
import KeyboardCustomize from "./../../components/KeyboardCustomize";

export default {
	props: ["components"],

	components: {
		KeyboardCustomize
	},

	layout: (h, page) => {
		return h(Layout, [h(ShopLayout, [page])]);
	},

	mounted() {}
};
</script>
