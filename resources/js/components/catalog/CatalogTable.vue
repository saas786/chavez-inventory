<template>
	<v-data-table
		:headers="headers"
		:items="prebuilt_orders"
		single-select
		item-key="id"
		show-expand
		show-select
		:expanded.sync="expanded"
		@click:row="expand"
	>
		<template v-slot:top="props">
			<v-toolbar class="mb-2">
				<v-toolbar-title class="mr-8">Catalog</v-toolbar-title>

				<v-toolbar-items>
					<create-catalog-item :components="components"></create-catalog-item>
					<delete-catalog-item :selected="selected"></delete-catalog-item>
				</v-toolbar-items>
			</v-toolbar>
		</template>

		<template v-slot:item.keyboard_id="{ item }">
			{{ item.keyboard_id }}
		</template>

		<template v-slot:item.data-table-select="{ item }">
			<v-checkbox v-model="selected" :value="item.id"></v-checkbox>
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
import CreateCatalogItem from "./CreateCatalogItem";
import DeleteCatalogItem from "./DeleteCatalogItem";
import CatalogItemDetails from "./CatalogItemDetails";

export default {
	components: { DeleteCatalogItem, CreateCatalogItem, CatalogItemDetails },
	computed: {
		items() {
			return this.prebuilt_orders.map((order) => {
				return {
					id: order.id,
					Name: order.name,
					Price: order.price,
					image_url: order.image_url,
					Description: order.description,
					keyboard_id: order.keyboard_id,
				};
			});
		},
	},
	props: ["prebuilt_orders", "components"],
	data() {
		return {
			selected: [],
			expanded: [],
			headers: [
				{
					text: "Name",
					value: "name",
				},
				{
					text: "Price",
					value: "price",
				},
				{
					text: "Description",
					value: "description",
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
