<template>
	<v-dialog max-width="1200">
		<template v-slot:activator="{ on, attrs }">
			<v-btn text color="primary" v-bind="attrs" v-on="on">Add Item</v-btn>
		</template>
		<v-card>
			<v-card-title>Create Catalog Item</v-card-title>
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
									v-model="catalog_item.name"
								></v-text-field>
							</v-col>
							<v-col
								><v-text-field
									label="Price"
									v-model="catalog_item.price"
									outlined
									dense
									prefix="PHP"
								></v-text-field
							></v-col>
							<v-col>
								<v-select
									dense
									outlined
									:items="layoutOptions"
									v-model="keyboard.layout_id"
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
								<v-select dense outlined label="Switch"></v-select>
							</v-col>
							<v-col>
								<v-select dense outlined label="Keycaps"></v-select>
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
									:disabled="!keyboard.cable.double_sleeved"
									:items="doubleSleevedColorOptions"
									v-model="keyboard.cable.double_sleeve_color_id"
								></v-select>
							</v-col>
						</v-row>
						<v-row>
							<v-col>
								<v-select dense outlined label="Plate"></v-select>
							</v-col>
							<v-col>
								<v-select dense outlined label="Case"></v-select>
							</v-col>
						</v-row>
					</v-col>
				</v-row>
			</v-card-text>
			<v-card-actions class="justify-center">
				<v-btn color="success" outlined>Save</v-btn>
			</v-card-actions>
		</v-card>
	</v-dialog>
</template>

<script>
export default {
	mounted() {
		axios.get("/inventory/components/colors").then((res) => {
			this.colors = res.data;
		});
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
			image_url: "https://bad.src/not/valid",
			catalog_item: {
				name: "",
				price: "",
				description: "",
				image_url: [],
			},
			keyboard: {
				layout_id: "",
				switch_id: "",
				keycap_id: "",
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
		imageUploadChange(e) {
			let pic = e;
			console.log(pic);
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
			} else this.image_url = "https://bad.src/not/valid";
		},
	},
};
</script>

<style>
.picture_input {
	width: 400px;
	height: 400px;
}
</style>
