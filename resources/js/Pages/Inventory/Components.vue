<template>
	<v-container class="overflow-hidden">
		<component-create
			:comp_types="comp_types"
			:layouts="layouts"
			:componentAdd="componentAdd"
		/>
		<v-toolbar>
			<v-toolbar-title class="mr-8">Controls</v-toolbar-title>
			<v-toolbar-items>
				<v-btn color="primary" text @click="showAdd"> Add </v-btn>
				<v-dialog max-width="600">
					<template v-slot:activator="{ on, attrs }">
						<v-btn color="success" text v-bind="attrs" v-on="on">Stock</v-btn>
					</template>
					<v-card>
						<v-card-title>How much stock do you want to add?</v-card-title>
						<v-card-subtitle
							>You are editing
							{{ table.selected.length }} items.</v-card-subtitle
						>
						<v-card-text>
							<v-slider
								dense
								v-model="stockAdd"
								thumb-label
								color="secondary"
								min="-50"
								max="50"
							></v-slider>
							<!-- {{ stockAdd }} -->
						</v-card-text>
						<v-card-actions>
							<v-spacer></v-spacer>
							<v-btn
								color="success"
								:disabled="!table.selected.length"
								outlined
								large
								@click="updateStock"
								>Update Stocks</v-btn
							>
							<v-spacer></v-spacer>
						</v-card-actions>
					</v-card>
				</v-dialog>
				<v-dialog max-width="600">
					<template v-slot:activator="{ on, attrs }">
						<v-btn color="error" text v-bind="attrs" v-on="on">Delete</v-btn>
					</template>
					<v-card>
						<v-card-title>Are you sure?</v-card-title>
						<v-card-subtitle
							>You are about to delete
							{{ table.selected.length }} items.</v-card-subtitle
						>
						<v-card-actions>
							<v-spacer></v-spacer>
							<v-btn
								color="error"
								:disabled="!table.selected.length"
								large
								@click="deleteComponents"
								>Delete Components</v-btn
							>
							<v-spacer></v-spacer>
						</v-card-actions>
					</v-card>
				</v-dialog>
				<color-edit></color-edit>
			</v-toolbar-items>
			<v-spacer></v-spacer>
			<!-- {{ this.table.expanded.map(v => v.id) }} -->
			{{ this.table.selected }}
			<!-- <v-checkbox v-model="table.groupByType" hide-details class="mr-2" label="Group by Type"></v-checkbox> -->
			<v-text-field
				hide-details
				single-line
				label="Search"
				v-model="table.search"
			></v-text-field>
		</v-toolbar>
		<v-data-table
			show-group-by
			:headers="table.headers"
			:items="items"
			:search="table.search"
			:expanded.sync="table.expanded"
			@click:row="expandRow"
			item-key="id"
			class="mt-12"
			show-select
		>
			<template v-slot:expanded-item="{ headers, item }">
				<td :colspan="headers.length" class="primary darken-3">
					<component-update
						:item="toUpdate(item)"
						:comp_types="comp_types"
						:layouts="layouts"
					></component-update>
				</td>
			</template>
			<template v-slot:item.Name="{ item }">
				<v-tooltip bottom v-if="item.url === null">
					<template v-slot:activator="{ on, attrs }">
						<span v-bind="attrs" v-on="on">{{ item.Name }}</span>
					</template>
					No image
				</v-tooltip>
				<v-dialog max-width="800" v-else>
					<template v-slot:activator="{ on: dialog, attrs }">
						<v-tooltip bottom>
							<template v-slot:activator="{ on: tooltip }">
								<span v-bind="attrs" v-on="{ ...tooltip, ...dialog }"
									>{{ item.Name }} <v-icon>mdi-camera</v-icon></span
								>
							</template>
							Click to see image.
						</v-tooltip>
					</template>
					<v-img
						:src="item.url"
						max-width="800"
						lazy-src="https://via.placeholder.com/800"
					></v-img>
				</v-dialog>
			</template>

			<template v-slot:header.data-table-select> </template>
			<template v-slot:item.data-table-select="{ item }">
				<v-checkbox @click.stop="select(item.id)"></v-checkbox>
			</template>
		</v-data-table>
	</v-container>
</template>

<script>
import InventoryLayout from "./../../Shared/InventoryLayout";
import Layout from "./../../Shared/Layout";
import ComponentCreate from "./../../components/ComponentCreate";
import ComponentUpdate from "./../../components/ComponentUpdate";
import ColorEdit from "./../../components/ColorEdit";
import { Inertia } from "@inertiajs/inertia";

export default {
	components: {
		ComponentCreate,
		ComponentUpdate,
		ColorEdit,
	},

	props: ["components", "comp_types", "layouts"],

	mounted() {
		// this.table.expanded = [this.components[0]];
	},

	computed: {
		items() {
			return this.components.map((comp) => {
				return {
					id: comp.id,
					Name: comp.name,
					layout_id: comp.layout_id,
					Layout: !!comp.layout ? comp.layout.name : "",
					keyboard_component_type_id: comp.keyboard_component_type_id,
					Type: comp.keyboard_component_type.name,
					Stock: comp.stock,
					Price: comp.price,
					url: comp.url,
				};
			});
		},
	},

	data() {
		return {
			stockAdd: 0,
			table: {
				selected: [],
				search: "",
				expanded: [1],
				headers: [
					{
						text: "Name",
						value: "Name",
						groupable: false,
					},
					{
						text: "Type",
						value: "Type",
					},
					{
						text: "Layout",
						value: "Layout",
					},
					{
						text: "Price",
						value: "Price",
						groupable: false,
					},
					{
						text: "Stock",
						value: "Stock",
						groupable: false,
					},
				],
			},
			componentAdd: false,
		};
	},

	layout: (h, page) => {
		return h(Layout, [h(InventoryLayout, [page])]);
	},

	watch: {
		table() {
			console.log("CHANGED TABLE");
		},
	},

	methods: {
		toUpdate(item) {
			return {
				id: item.id,
				name: item.Name,
				layout_id: item.layout_id,
				keyboard_component_type_id: item.keyboard_component_type_id,
				stock: item.Stock,
				price: item.Price,
				image: [],
			};
		},
		expandRow(item) {
			let { expanded } = this.table;
			if (expanded.includes(item)) {
				expanded.splice(expanded.indexOf(item), 1);
			} else expanded.push(item);
		},
		select(id) {
			// console.log("SELECTED");
			let { selected } = this.table;
			// console.log(selected);
			if (selected.includes(id)) {
				// console.log("SPLICING");
				selected.splice(selected.indexOf(id), 1);
			} else selected.push(id);
		},
		showAdd() {
			// this.components = {},
			this.componentAdd = true;
		},
		amazonS3(id) {
			console.log("HELLO WORLD!");
		},
		updateStock() {
			Inertia.post("/inventory/components/stock", {
				ids: this.table.selected,
				value: this.stockAdd,
			});
		},
		deleteComponents() {
			// axios.delete("/inventory/components/stock", {
			// 	data: {
			// 		componentIds: this.table.selected,
			// 		_token: document.head.querySelector('meta[name="csrf-token"]').content
			// 	}
			// });
			// console.log(this.table.selected);
			// Inertia.delete("/inventory/components/", {
			// 	ids: this.table.selected,
			// });
			this.$inertia.post("/inventory/components/", {
				ids: this.table.selected,
				_method: "DELETE",
				// _token: document.head.querySelector('meta[name="csrf-token"]').content,
			});
		},
	},
};
</script>
