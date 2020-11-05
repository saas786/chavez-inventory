<template>
	<div>
		<!-- <cable-panel :price="total" :colors="colors"></cable-panel> -->
		<v-stepper v-model="step">
			<v-stepper-header>
				<v-stepper-step :complete="step > 1" step="1">Layout</v-stepper-step>
				<v-divider></v-divider>
				<v-stepper-step :complete="step > 2" step="2">Switches</v-stepper-step>
				<v-divider></v-divider>
				<v-stepper-step :complete="step > 3" step="3">Keycaps</v-stepper-step>
				<v-divider></v-divider>
				<v-stepper-step :complete="step > 4" step="4">Cable</v-stepper-step>
				<v-divider></v-divider>
				<v-stepper-step :complete="step > 5" step="5">Plate</v-stepper-step>
				<v-divider></v-divider>
				<v-stepper-step :complete="step > 6" step="6">Case</v-stepper-step>
				<v-divider></v-divider>
				<v-stepper-step :complete="step > 7" step="7"
					>Customer Details</v-stepper-step
				>
				<v-divider></v-divider>
				<v-stepper-step :complete="step > 8" step="8">Review</v-stepper-step>
				<v-divider></v-divider>
				<v-stepper-step :complete="step > 9" step="9">Done!</v-stepper-step>
			</v-stepper-header>
			<v-progress-linear v-if="ordering"></v-progress-linear>
			<v-stepper-items>
				<v-stepper-content step="1">
					<v-card>
						<v-card-title>Layout</v-card-title>
						<v-card-text>
							<v-row class="px-3 pb-2">
								<v-btn
									block
									height="150px"
									class="full"
									@click="layoutSelect(1)"
									:disabled="layoutDisable(1)"
								>
									<div class="d-flex flex-column">
										<span class="text-h4">
											Full-size
										</span>
										<span v-if="layoutDisable(1)" class="error--text"
											>Components Out of Stock</span
										>
									</div>
								</v-btn>
							</v-row>
							<v-row>
								<v-col>
									<v-btn
										block
										height="150px"
										@click="layoutSelect(2)"
										:disabled="layoutDisable(2)"
									>
										<div class="d-flex flex-column">
											<span class="text-h4">
												1800-compact
											</span>
											<span v-if="layoutDisable(2)" class="error--text"
												>Components Out of Stock</span
											>
										</div>
									</v-btn>
								</v-col>
								<v-col>
									<v-btn
										block
										height="150px"
										@click="layoutSelect(3)"
										:disabled="layoutDisable(3)"
										><div class="d-flex flex-column">
											<span class="text-h4">
												Tenkeyless
											</span>
											<span v-if="layoutDisable(3)" class="error--text"
												>Components Out of Stock</span
											>
										</div></v-btn
									>
								</v-col>
								<v-col>
									<v-btn
										block
										height="150px"
										@click="layoutSelect(4)"
										:disabled="layoutDisable(4)"
										><div class="d-flex flex-column">
											<span class="text-h4">
												75%
											</span>
											<span v-if="layoutDisable(4)" class="error--text"
												>Components Out of Stock</span
											>
										</div></v-btn
									>
								</v-col>
							</v-row>
							<v-row>
								<v-col>
									<v-btn
										block
										height="150px"
										@click="layoutSelect(5)"
										:disabled="layoutDisable(5)"
										><div class="d-flex flex-column">
											<span class="text-h4">
												60%
											</span>
											<span v-if="layoutDisable(5)" class="error--text"
												>Components Out of Stock</span
											>
										</div></v-btn
									>
								</v-col>
								<v-col>
									<v-btn
										block
										height="150px"
										@click="layoutSelect(6)"
										:disabled="layoutDisable(6)"
										><div class="d-flex flex-column">
											<span class="text-h4">
												40%
											</span>
											<span v-if="layoutDisable(6)" class="error--text"
												>Components Out of Stock</span
											>
										</div></v-btn
									>
								</v-col>
								<v-col>
									<v-btn
										block
										height="150px"
										@click="layoutSelect(7)"
										:disabled="layoutDisable(7)"
										><div class="d-flex flex-column">
											<span class="text-h4">
												20%
											</span>
											<span v-if="layoutDisable(7)" class="error--text"
												>Components Out of Stock</span
											>
										</div></v-btn
									>
								</v-col>
							</v-row>
						</v-card-text>
						<v-card-actions></v-card-actions>
					</v-card>
				</v-stepper-content>
			</v-stepper-items>
			<v-stepper-items>
				<v-stepper-content step="2">
					<customize-panel
						:layout="keyboard.layout"
						:items="components[0]"
						:price="total"
						:select_id="keyboard.switch"
						@step-back="step--"
						@step-forward="step++"
						@select-update="keyboard.switch = $event"
					></customize-panel>
				</v-stepper-content>
			</v-stepper-items>
			<v-stepper-items>
				<v-stepper-content step="3"
					><customize-panel
						:layout="keyboard.layout"
						:items="components[1]"
						:price="total"
						:select_id="keyboard.keycap"
						@step-back="step--"
						@step-forward="step++"
						@select-update="keyboard.keycap = $event"
					></customize-panel
				></v-stepper-content>
			</v-stepper-items>
			<v-stepper-items>
				<v-stepper-content step="4">
					<cable-panel
						:price="total"
						:colors="colors"
						@step-back="step--"
						@step-forward="step++"
						@select-update="keyboard.cable = $event"
					></cable-panel>
				</v-stepper-content>
			</v-stepper-items>
			<v-stepper-items>
				<v-stepper-content step="5">
					<customize-panel
						:layout="keyboard.layout"
						:items="plateOptions"
						:price="total"
						:select_id="keyboard.plate"
						@step-back="step--"
						@step-forward="step++"
						@select-update="keyboard.plate = $event"
					></customize-panel>
				</v-stepper-content>
			</v-stepper-items>
			<v-stepper-items>
				<v-stepper-content step="6">
					<customize-panel
						:layout="keyboard.layout"
						:items="caseOptions"
						:price="total"
						:select_id="keyboard.case"
						@step-back="step--"
						@step-forward="step++"
						@select-update="keyboard.case = $event"
					></customize-panel>
				</v-stepper-content>
			</v-stepper-items>
			<v-stepper-items>
				<v-stepper-content step="7">
					<v-card>
						<v-card-title>Customer Details</v-card-title>
						<v-card-text class="text-center">
							<v-row>
								<v-col cols="1">
									<v-btn class="full-height" @click="step--"
										><v-icon>mdi-arrow-left</v-icon></v-btn
									>
								</v-col>
								<v-col cols="10">
									<v-row>
										<v-text-field
											label="Customer Name"
											v-model="customer.name"
										></v-text-field>
									</v-row>
									<v-row>
										<v-text-field
											label="Messenger ID"
											persistent-hint
											v-model="customer.messenger"
											hint="Your messenger username"
										></v-text-field>
									</v-row>
									<v-row>
										<v-textarea
											label="Additional Requests"
											v-model="customer.remarks"
										></v-textarea>
									</v-row>
								</v-col>
								<v-col cols="1">
									<v-btn
										class="full-height"
										:disabled="!customerValid"
										@click="step++"
										color="primary"
										><v-icon>mdi-arrow-right</v-icon></v-btn
									>
								</v-col>
							</v-row>
						</v-card-text>
					</v-card>
				</v-stepper-content>
			</v-stepper-items>
			<v-stepper-items>
				<v-stepper-content step="8">
					<v-card>
						<v-card-title>Review</v-card-title>
						<v-card-text>
							<v-row>Total Price: {{ total }}</v-row>
							<v-row>
								<v-simple-table>
									<thead>
										<tr>
											<th colspan="2">
												Customer Details
											</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td>Name</td>
											<td>{{ customer.name }}</td>
										</tr>
										<tr>
											<td>Messenger ID</td>
											<td>{{ customer.messenger }}</td>
										</tr>
										<tr>
											<td>Remarks</td>
											<td>{{ customer.remarks }}</td>
										</tr>
									</tbody>
								</v-simple-table>
							</v-row>
							<v-row>
								<v-simple-table>
									<tbody>
										<tr>
											<td></td>
											<td></td>
										</tr>
									</tbody>
								</v-simple-table>
							</v-row>
						</v-card-text>
						<v-card-actions> </v-card-actions>
					</v-card>
				</v-stepper-content>
			</v-stepper-items>
			<v-stepper-items>
				<v-stepper-content step="9"></v-stepper-content>
			</v-stepper-items>
		</v-stepper>
		<!-- <v-list>
			<v-list-item v-for="component in components" v-bind:key="component.id">
				<v-list-item-title>{{ component.name }}</v-list-item-title>
			</v-list-item>
		</v-list> -->
	</div>
</template>

<script>
import CustomizePanel from "./KeyboardCustomizePanel";
import CablePanel from "./CableCustomizePanel";
export default {
	components: {
		CustomizePanel,
		CablePanel
	},
	mounted() {
		axios.get("/inventory/components/colors").then(res => {
			this.colors = res.data;
		});
	},
	props: ["components"],
	computed: {
		total() {
			const types = ["switch", "keycap", "plate", "case"];
			let keyboardPrice = 0;

			if (this.components.length < 4) return 0;

			types.forEach((value, index) => {
				// console.log(value, index);
				let comp = this.components[index].filter(
					item => item.id == this.keyboard[value]
				);
				if (!!comp[0]) keyboardPrice += parseFloat(comp[0].price);
			});

			return keyboardPrice;
		},
		caseOptions() {
			if (this.components.length < 4) return [];

			return this.components[3].filter(
				c => c.layout_id == this.keyboard.layout
			);
		},
		plateOptions() {
			if (this.components.length < 4) return [];
			return this.components[2].filter(
				c => c.layout_id == this.keyboard.layout
			);
		},
		customerValid() {
			return (
				this.customer.name != "" &&
				this.customer.messenger != "" &&
				this.customer.remarks != ""
			);
		}
	},
	data() {
		return {
			colors: [],
			ordering: false,
			step: 1,
			keyboard: {
				layout: 1,
				switch: 0,
				keycap: 0,
				cable: {},
				plate: 0,
				case: 0
			},
			customer: {
				name: "",
				messenger: "",
				remarks: ""
			}
		};
	},
	methods: {
		layoutSelect(id) {
			this.keyboard.layout = id;
			this.step++;
		},
		layoutDisable(id) {
			if (this.components.length < 4) return true;

			let cases = this.components[3].filter(c => c.layout_id == id);
			let plates = this.components[2].filter(c => c.layout_id == id);

			return cases.length <= 0 || plates.length <= 0;
		},
		findComponent(id) {
			this.components.forEach(type => {
				type.forEach(c => {
					if (c.id == id) return c;
				});
			});
		}
	}
};
</script>

<style>
.full {
	background: url("https://custom-mech-kbd.s3-ap-northeast-1.amazonaws.com/static/header.jpg");
	background-size: cover;
	background-attachment: scroll;
}
.full-height {
	height: 100% !important;
}
</style>
