<template>
	<v-card> Hello, {{ component.name }}! </v-card>
</template>

<script>
export default {
	props: ["item"],

	mounted() {
		//Map item props to the default
		this.resetComponent();
	},

	data() {
		return {
			component: {
				name: "",
				keyboard_component_type_id: 0,
				layout_id: 0,
				stock: "",
				price: ""
			}
		};
	},
	methods: {
		resetComponent() {
			Object.keys(this.component).map(
				(key, value) => (this.component[key] = this.item[key])
			);
		}
	}
};
</script>

<style></style>
