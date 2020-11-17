<template>
	<v-form ref="updateCatalogItemForm">
		<v-card>
			<v-card-text>
				<v-row>
					<v-col cols="4">
						<v-row>
							<v-col>
								<v-img
									:src="image_url"
									min-height="200"
									max-height="200"
									:aspect-ratio="16 / 9"
								>
									<template v-slot:placeholder>
										<v-row
											class="fill-height ma-0"
											align="center"
											justify="center"
										>
											<v-icon size="100">mdi-camera</v-icon>
										</v-row>
									</template>
								</v-img>
								<v-file-input
									label="Keyboard Image"
									outlined
									prepend-icon="mdi-camera"
									accept="image/*"
									@change="imageUploadChange"
									v-model="catalog_item.image_url"
									class="mt-4"
									dense
								></v-file-input>
							</v-col>
						</v-row>
						<v-row>
							<v-col>
								<v-textarea
									outlined
									dense
									label="Description"
									v-model="catalog_item.description"
								>
								</v-textarea>
							</v-col>
						</v-row>
					</v-col>
					<v-col cols="8">
						<v-row>
							<v-col>
								<v-text-field
									outlined
									dense
									label="Item Name"
									:rules="rules.name"
									v-model="catalog_item.name"
								></v-text-field>
							</v-col>
							<v-col>
								<v-currency-field
									label="Price"
									v-model="catalog_item.price"
									outlined
									dense
									:rules="rules.price"
									prefix="₱"
								></v-currency-field>
							</v-col>
							<v-col>
								<v-select
									dense
									outlined
									:items="layoutOptions"
									v-model="keyboard.layout_id"
									:rules="rules.layout"
									label="Keyboard Layout"
								></v-select>
							</v-col>
						</v-row>
						<v-row>
							<v-col>
								<span class="text-h4">Keyboard Details</span>
							</v-col>
						</v-row>
						<v-row>
							<v-col>
								<v-select
									dense
									outlined
									:rules="rules.switch"
									label="Switch"
									v-model="keyboard.switch_id"
									:items="componentOptions(1)"
								></v-select>
							</v-col>
							<v-col>
								<v-select
									dense
									outlined
									:rules="rules.keycap"
									label="Keycaps"
									v-model="keyboard.keycap_id"
									:items="componentOptions(2)"
								></v-select>
							</v-col>
						</v-row>
						<v-row>
							<v-col>
								<v-text-field
									dense
									outlined
									label="Cable Length"
									v-model="keyboard.cable.cable_length"
								></v-text-field>
							</v-col>
							<v-col>
								<v-text-field
									dense
									outlined
									label="Coil Length"
									v-model="keyboard.cable.coil_length"
								></v-text-field>
							</v-col>
							<v-col>
								<v-select
									:items="primaryColorOptions"
									dense
									outlined
									:rules="rules.cable_color"
									label="Cable Color"
									v-model="keyboard.cable.color_id"
								></v-select>
							</v-col>
						</v-row>
						<v-row>
							<v-col>
								<v-checkbox
									v-model="keyboard.cable.detachable"
									label="Detachable?"
								></v-checkbox>
							</v-col>
							<v-col>
								<v-checkbox
									v-model="keyboard.cable.double_sleeved"
									label="Double Sleeved?"
								></v-checkbox>
							</v-col>
							<v-col>
								<v-select
									dense
									outlined
									label="Sleeve Color"
									:rules="rules.double_sleeved_color"
									:disabled="!keyboard.cable.double_sleeved"
									:items="doubleSleevedColorOptions"
									v-model="keyboard.cable.double_sleeve_color_id"
								></v-select>
							</v-col>
						</v-row>
						<v-row>
							<v-col>
								<v-select
									dense
									outlined
									label="Plate"
									v-model="keyboard.plate_id"
									:rules="rules.plate"
									:items="componentOptions(3)"
								></v-select>
							</v-col>
							<v-col>
								<v-select
									dense
									outlined
									label="Case"
									:rules="rules.case"
									v-model="keyboard.case_id"
									:items="componentOptions(4)"
								></v-select>
							</v-col>
						</v-row>
					</v-col>
				</v-row>
			</v-card-text>
			<v-card-actions class="justify-center">
				<v-btn color="success" outlined @click="updateItem">Update</v-btn>
			</v-card-actions>
		</v-card>
	</v-form>
</template>

<script>
import { Inertia } from "@inertiajs/inertia";
export default {
	props: ["components", "item"],
	mounted() {
		axios.get("/inventory/components/colors").then((res) => {
			this.colors = res.data;
		});
		console.log(this.item);

		this.resetItem();
	},
	computed: {
		layoutOptions() {
			return [
				{ value: 1, text: "Full" },
				{ value: 2, text: "1800-compact" },
				{ value: 3, text: "Tenkeyless" },
				{ value: 4, text: "75%" },
				{ value: 5, text: "60%" },
				{ value: 6, text: "40%" },
				{ value: 7, text: "20%" },
			];
		},
		primaryColorOptions() {
			return this.colors
				.filter((c) => c.primary)
				.map((c) => {
					return {
						value: c.id,
						text: c.name,
					};
				});
		},
		doubleSleevedColorOptions() {
			return this.colors
				.filter((c) => c.double_sleeved)
				.map((c) => {
					return {
						value: c.id,
						text: c.name,
					};
				});
		},
	},
	data() {
		return {
			image_url: "",
			catalog_item: {
				name: "",
				price: "",
				description: "",
				image_url: [],
			},
			rules: {
				name: [(v) => !!v || "Name is required."],
				price: [(v) => !!v || "Price is required."],
				layout: [(v) => !!v || "Layout is required."],
				switch: [(v) => !!v || "Switch is required."],
				keycap: [(v) => !!v || "Keycap is required."],
				cable: [(v) => !!v || "Cable length is required."],
				coil: [(v) => !!v || "Coil length is required."],
				cable_color: [(v) => !!v || "Cable color is required."],
				double_sleeved_color: [
					(v) =>
						(this.keyboard.cable.double_sleeved && !!v) ||
						!this.keyboard.cable.double_sleeved ||
						"Coil length is required.",
				],
				plate: [(v) => !!v || "Plate is required."],
				case: [(v) => !!v || "Case is required."],
			},
			keyboard: {
				layout_id: "",
				switch_id: "",
				keycap_id: "",
				plate_id: "",
				case_id: "",
				cable: {
					cable_length: 5,
					coil_length: 0,
					color_id: "",
					double_sleeved: false,
					double_sleeve_color_id: "",
					detachable: false,
				},
			},
			colors: [],
		};
	},
	methods: {
		resetItem() {
			this.catalog_item = {
				name: this.item.name,
				price: this.item.price,
				description: this.item.description,
				image_url: [],
			};

			this.image_url = this.item.url;

			this.keyboard = {
				layout_id: this.item.keyboard.layout_id,
				switch_id: this.item.keyboard.switch_id,
				keycap_id: this.item.keyboard.keycap_id,
				plate_id: this.item.keyboard.plate_id,
				case_id: this.item.keyboard.case_id,
				cable: {
					cable_length: this.item.keyboard.cable.cable_length,
					coil_length: this.item.keyboard.cable.coil_length,
					color_id: this.item.keyboard.cable.color_id,
					double_sleeved: this.item.keyboard.cable.double_sleeved,
					double_sleeve_color_id: this.item.keyboard.cable
						.double_sleeve_color_id,
					detachable: this.item.keyboard.cable.detachable,
				},
			};
		},
		imageUploadChange(e) {
			let pic = e;
			let reader = new FileReader();

			reader.addEventListener(
				"load",
				function () {
					this.image_url = reader.result;
				}.bind(this),
				false
			);

			if (pic) {
				if (/\.(jpe?g|png|gif)$/i.test(pic.name)) reader.readAsDataURL(pic);
			} else this.image_url = this.item.url;
		},
		updateItem() {
			console.log(`/inventory/catalog/${this.item.id}`);
			// Inertia.patch(`/inventory/catalog/${this.item.id}`, data);
			// return;
			if (!this.$refs.updateCatalogItemForm.validate()) return;

			let data = new FormData();

			data.append("layout_id", this.keyboard.layout_id);
			data.append("switch_id", this.keyboard.switch_id);
			data.append("keycap_id", this.keyboard.keycap_id);
			data.append("plate_id", this.keyboard.plate_id);
			data.append("case_id", this.keyboard.case_id);

			data.append("name", this.catalog_item.name);
			data.append("keyboard_id", this.item.keyboard_id);
			data.append("price", this.catalog_item.price);
			data.append("description", this.catalog_item.description);
			data.append("image_url", this.catalog_item.image_url);

			data.append("cable_length", this.keyboard.cable.cable_length);
			data.append("coil_length", this.keyboard.cable.coil_length);
			data.append("color_id", this.keyboard.cable.color_id);
			data.append("double_sleeved", this.keyboard.cable.double_sleeved);
			data.append(
				"double_sleeve_color_id",
				this.keyboard.cable.double_sleeve_color_id
			);
			data.append("detachable", this.keyboard.cable.detachable);
			data.append("_method", "PATCH");

			Inertia.post(`/inventory/catalog/${this.item.id}`, data);
		},
		componentOptions(type, layout = this.keyboard.layout_id) {
			let options;
			if (type < 3) options = this.components[type - 1];
			else if (layout != null)
				options = this.components[type - 1].filter(
					(c) => c.layout_id == layout
				);
			else options = [];

			return options.map((c) => {
				return {
					value: c.id,
					text: c.name,
				};
			});
		},
	},
};
</script>

<style></style>
