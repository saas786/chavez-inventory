<template>
	<v-container>
		<v-toolbar>
			<v-toolbar-title class="mr-8">Controls</v-toolbar-title>
			<v-toolbar-items>
				<create-catalog-item></create-catalog-item>
			</v-toolbar-items>
		</v-toolbar>
	</v-container>
</template>

<script>
import InventoryLayout from "./../../Shared/InventoryLayout";
import Layout from "./../../Shared/Layout";
import CreateCatalogItem from "./../../components/catalog/CreateCatalogItem";

export default {
	components: { CreateCatalogItem },
	layout: (h, page) => {
		return h(Layout, [h(InventoryLayout, [page])]);
	},
};
</script>
