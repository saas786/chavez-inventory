<template>
	<v-card>
		<v-card-title>Edit Cable Colors</v-card-title>
		<v-card-text>
			<v-data-table :items="color_edit" :headers="headers" :loading="loading">
				<template v-slot:item.primary="{ item }">
					<v-simple-checkbox v-model="item.primary"></v-simple-checkbox>
				</template>
				<template v-slot:item.double="{ item }">
					<v-simple-checkbox v-model="item.double"></v-simple-checkbox>
				</template>
				<template v-slot:body.append="">
					<tr>
						<td>
							<v-text-field
								label="Name"
								:rules="[rules.required]"
								single-line
								v-model="newColor.name"
							></v-text-field>
						</td>
						<td>
							<v-text-field
								readonly
								label="Hex Code"
								single-line
								v-model="newColor.hexCode"
							>
								<template v-slot:append-outer>
									<v-dialog max-width="300">
										<template v-slot:activator="{ on, attrs }">
											<v-btn>
												<v-icon v-bind="attrs" v-on="on"
													>mdi-select-color</v-icon
												>
											</v-btn>
										</template>
										<v-card>
											<v-card-text>
												<v-color-picker
													v-model="newColor.hexCode"
													hide-mode-switch
													mode="hexa"
													class="my-4"
												></v-color-picker>
											</v-card-text>
										</v-card>
									</v-dialog>
								</template>
							</v-text-field>
						</td>
						<td>
							<v-simple-checkbox v-model="newColor.primary"></v-simple-checkbox>
						</td>
						<td>
							<v-simple-checkbox v-model="newColor.double"></v-simple-checkbox>
						</td>
						<td>
							<v-btn @click="addColor" :disabled="canAdd" color="primary"
								><v-icon>mdi-plus</v-icon></v-btn
							>
						</td>
					</tr>
				</template>
			</v-data-table>
		</v-card-text>
		<v-card-actions>
			<v-spacer></v-spacer>
			<v-btn color="success" @click="updateColors">Save</v-btn>
			<v-spacer></v-spacer>
		</v-card-actions>
	</v-card>
</template>

<script>
import { Inertia } from "@inertiajs/inertia";
export default {
	mounted() {
		this.loading = true;
		axios.get("/inventory/components/colors").then(res => {
			this.loading = false;
			this.color_edit = res.data.map(color => {
				return {
					name: color.name,
					hexCode: color.hex_code,
					primary: color.primary,
					double: color.double_sleeved
				};
			});
		});
	},
	computed: {
		canAdd() {
			return !(!!this.newColor.name && !!this.newColor.hexCode);
		}
	},
	data() {
		return {
			loading: false,
			color_edit: [],
			headers: [
				{
					text: "Name",
					value: "name"
				},
				{
					text: "Hex Code",
					value: "hexCode"
				},
				{
					text: "Single Sleeved",
					value: "primary"
				},
				{
					text: "Double Sleeved",
					value: "double"
				},
				{
					text: "",
					value: "actions"
				}
			],
			newColor: {
				name: "",
				hexCode: "",
				primary: false,
				double: false
			},
			rules: {
				required: value => !!value || "Required"
			}
		};
	},
	methods: {
		addColor() {
			this.color_edit.push(this.newColor);
			this.newColor = {
				name: "",
				hexCode: "",
				primary: false,
				double: false
			};
		},
		removeColor(ind) {
			this.color_edit.splice(ind, 1);
		},
		updateColors() {
			console.log(this.color_edit);
			const token = document.querySelector('meta[name="csrf-token"]');
			axios.post("/inventory/components/colors", this.color_edit).then(res => {
				this.$page.props.flash.success = "Colors updated!";
				this.$parent.$parent.$parent.$parent.$parent.$parent.$parent.$parent.flash_success = true;
			});
			// Inertia.post("/inventory/components/colors", this.color_edit);
		}
	}
};
</script>

<style></style>
