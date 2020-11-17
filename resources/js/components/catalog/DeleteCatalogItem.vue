<template>
	<v-dialog max-width="500">
		<template v-slot:activator="{ on, attrs }">
			<v-btn text v-bind="attrs" v-on="on" color="error">Delete Items</v-btn>
		</template>
		<v-card>
			<v-card-title>Are you sure?</v-card-title>
			<v-card-text
				>You have selected
				<span class="primary--text">{{ selected.length }}</span>
				items</v-card-text
			>
			<v-card-actions class="justify-center">
				<v-btn
					color="error"
					:disabled="selected.length == 0"
					@click="deleteItems"
					>Delete</v-btn
				>
			</v-card-actions>
		</v-card>
	</v-dialog>
</template>

<script>
import { Inertia } from "@inertiajs/inertia";
export default {
	props: ["selected"],
	methods: {
		deleteItems() {
			Inertia.post("/inventory/catalog", {
				_method: "DELETE",
				ids: this.selected,
			});
		},
	},
};
</script>

<style></style>
