<template>
	<v-form ref="form" v-model="valid" @submit.prevent="updateComponent">
		<v-card class="my-5">
			<v-card-text>
				<v-row>
					<v-col>
						<v-text-field
							v-model="form.name"
							label="Name"
							:rules="rules.name"
							required
						></v-text-field>
						<!-- {{ form.name }} -->
					</v-col>
					<v-col>
						<v-select
							:items="component_type_options"
							:rules="rules.keyboard_component_type_id"
							label="Type"
							v-model="form.keyboard_component_type_id"
						></v-select>
						<!-- {{ form.keyboard_component_type_id }} -->
					</v-col>
				</v-row>
				<v-row>
					<v-col>
						<v-select
							:items="layout_options"
							label="Layout"
							:disabled="layout_disabled"
							:rules="rules.layout_id"
							v-model="form.layout_id"
						></v-select>
						<!-- {{ form.layout_id }} -->
					</v-col>
				</v-row>
				<v-row>
					<v-col>
						<v-file-input
							label="Image"
							show-size
							counter
							v-model="form.image"
							accept="image"
						>
						</v-file-input>
						</div>
					</v-col>
					<v-col>
						<v-text-field
							type="number"
							step="0.01"
							label="Price"
							:rules="rules.price"
							v-model="form.price"
						></v-text-field>
					</v-col>
					<v-col>
						<v-text-field
							type="number"
							step="1"
							label="Stock"
							v-model="form.stock"
							:rules="rules.stock"
						></v-text-field>
						<!-- {{ form.stock }} -->
					</v-col>
				</v-row>
			</v-card-text>
			<v-card-actions>
				<v-btn outlined color="error" @click="resetComponent">Reset</v-btn>
				<v-btn :disabled="!valid" type="submit" color="success">Update</v-btn>
			</v-card-actions>
		</v-card>
	</v-form>
</template>

<script>
import { Inertia } from "@inertiajs/inertia";
export default {
	props: ["item", "comp_types", "layouts"],

	mounted() {
		//Map item props to the default
    // setInterval(this.resetComponent(), 2000);
    this.resetComponent();
	},

	computed: {
		component_type_options() {
			return this.comp_types.map(comp => {
				return { value: comp.id, text: comp.name };
			});
		},
		layout_options() {
			return this.layouts.map(layout => {
				return { value: layout.id, text: layout.name };
			});
		},
		layout_disabled() {
			if (this.form.keyboard_component_type_id < 3) {
				this.form.layout_id = null;
				return true;
			}
			return false;
		}
	},

	data() {
		return {
			valid: true,
			form: {
				name: "",
				keyboard_component_type_id: 0,
				layout_id: 0,
				stock: "",
        price: "",
        image: [],
			},
			rules: {
				name: [
					v => !!v || "Name is required",
					v =>
						(v && v.length <= 255) || "Name must be less than 255 characters."
				],
				keyboard_component_type_id: [
					v => !!v || "Type is required",
					v => (v && v < 6 && v > 0) || "Select a valid type."
				],
				layout_id: [
					v => {
						if (
							!!this.form.layout_id &&
							this.form.keyboard_component_type_id >= 3
						)
							return true;
						if (this.form.keyboard_component_type_id <= 2) return true;
						return "Layout is required.";
          }
          // v => !!this.form.layout_id && this.form.keyboard_component_type_id || this.form.keyboard_component_type_id <= 2 || "Layout is required.",
				],
				stock: [
					v =>
						(Number.isInteger(Number(v)) && v >= 0) ||
						"Stock must be a positive whole number."
				],
				price: [v => Number(v) >= 0 || "Price must not be negative."],
			}
		};
	},
	methods: {
		resetComponent() {
			Object.keys(this.form).map(
				(key, value) => (this.form[key] = this.item[key])
			);
		},
		updateComponent() {
			const valid = this.$refs.form.validate();

			if (!valid) return;

			let data = new FormData();

			data.append("name", this.form.name);
			data.append(
				"keyboard_component_type_id",
				this.form.keyboard_component_type_id
			);
			data.append("layout_id", this.form.layout_id);
			data.append("stock", this.form.stock);
			data.append("price", this.form.price);
      data.append("image", this.form.image);
      // data.append("_method", "PUT");

      // console.log(data);
      // console.log( this.form);

			// // console.log(data);

      const url = `/inventory/components/${this.item.id}`;

			// this.$inertia.put(url, data);
			Inertia.post(`/inventory/components/${this.item.id}`, data);
		}
	}
};
</script>

<style>
.border-radius-0 {
	border-radius: 0;
}
</style>
