<template>
	<div>
		<!-- <cable-panel :price="total" :colors="colors"></cable-panel> -->
		<v-stepper v-model="step">
			<v-stepper-header>
				<v-stepper-step :complete="step > 1" step="1">
					{{ step > 1 ? layoutName : "Layout" }}
				</v-stepper-step>
				<v-divider></v-divider>
				<v-stepper-step
					:complete="step > 2"
					:editable="keyboard.switch != ''"
					step="2"
				>
					{{
						keyboard.switch != ""
							? findComponent(keyboard.switch).name
							: "Switches"
					}}
				</v-stepper-step>
				<v-divider></v-divider>
				<v-stepper-step
					:complete="step > 3"
					:editable="keyboard.keycap != ''"
					step="3"
				>
					{{
						keyboard.keycap != ""
							? findComponent(keyboard.keycap).name
							: "Keycaps"
					}}
				</v-stepper-step>
				<v-divider></v-divider>
				<v-stepper-step
					:complete="step > 4"
					step="4"
					:editable="!!keyboard.cable.color_id"
					>Cable</v-stepper-step
				>
				<v-divider></v-divider>
				<v-stepper-step
					:complete="step > 5"
					step="5"
					:editable="keyboard.plate != ''"
				>
					{{
						keyboard.plate != "" ? findComponent(keyboard.plate).name : "Plates"
					}}
				</v-stepper-step>
				<v-divider></v-divider>
				<v-stepper-step
					:complete="step > 6"
					step="6"
					:editable="keyboard.case != ''"
				>
					{{
						keyboard.case != "" ? findComponent(keyboard.case).name : "Cases"
					}}
				</v-stepper-step>
				<v-divider></v-divider>
				<v-stepper-step :complete="step > 7" step="7"
					>Customer Details</v-stepper-step
				>
				<v-divider></v-divider>
				<v-stepper-step :complete="step > 8" step="8">Review</v-stepper-step>
				<v-divider></v-divider>
				<v-stepper-step :complete="step > 9" step="9">Done!</v-stepper-step>
			</v-stepper-header>
			<v-progress-linear v-if="ordering" indeterminate></v-progress-linear>
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
										<span class="text-h4"> Full-size </span>
										<span v-if="layoutDisable(1)" class="error--text h6"
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
											<span class="text-h4"> 1800-compact </span>
											<span v-if="layoutDisable(2)" class="error--text h6"
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
											<span class="text-h4"> Tenkeyless </span>
											<span v-if="layoutDisable(3)" class="error--text h6"
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
											<span class="text-h4"> 75% </span>
											<span v-if="layoutDisable(4)" class="error--text h6"
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
											<span class="text-h4"> 60% </span>
											<span v-if="layoutDisable(5)" class="error--text h6"
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
											<span class="text-h4"> 40% </span>
											<span v-if="layoutDisable(6)" class="error--text h6"
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
											<span class="text-h4"> 20% </span>
											<span v-if="layoutDisable(7)" class="error--text h6"
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

				<v-stepper-content step="4">
					<cable-panel
						:price="total"
						:colors="colors"
						@step-back="step--"
						@step-forward="step++"
						@select-update="keyboard.cable = $event"
					></cable-panel>
				</v-stepper-content>

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

				<v-stepper-content step="8">
					<v-card v-if="!ordering">
						<v-card-title>Review</v-card-title>
						<v-card-text>
							<v-row>
								<span class="h3 mx-auto"
									>Total Price:
									<span class="primary--text">
										&#8369;{{
											Math.round((total + Number.EPSILON) * 100) / 100
										}}
									</span></span
								>
							</v-row>
							<v-row>
								<v-col>
									<v-simple-table>
										<thead>
											<tr>
												<th colspan="2">Customer Details</th>
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
									<v-container class="mt-4">
										<v-row>
											<v-btn
												x-large
												color="primary"
												class="mx-auto"
												@click="order"
												>Order</v-btn
											>
										</v-row>

										<v-row class="mt-4">
											<v-btn
												small
												class="mx-auto"
												color="secondary"
												outlined
												@click="reset"
												>Restart</v-btn
											>
										</v-row>
									</v-container>
								</v-col>

								<v-col>
									<v-simple-table>
										<thead>
											<tr>
												<th colspan="2">Components</th>
												<th>Price</th>
											</tr>
										</thead>
										<tbody>
											<tr>
												<td>Layout</td>
												<td colspan="2">{{ layoutName }}</td>
											</tr>
											<tr>
												<td>Switch</td>
												<td>{{ findComponent(keyboard.switch).name }}</td>
												<td>{{ findComponent(keyboard.switch).price }}</td>
											</tr>
											<tr>
												<td>Keycap</td>
												<td>{{ findComponent(keyboard.keycap).name }}</td>
												<td>{{ findComponent(keyboard.keycap).price }}</td>
											</tr>
											<tr>
												<td>Cable</td>
												<td>{{ findComponent(keyboard.switch).name }}</td>
												<td>{{ findComponent(keyboard.switch).price }}</td>
											</tr>
											<tr>
												<td>Plate</td>
												<td>{{ findComponent(keyboard.plate).name }}</td>
												<td>{{ findComponent(keyboard.plate).price }}</td>
											</tr>
											<tr>
												<td>Case</td>
												<td>{{ findComponent(keyboard.case).name }}</td>
												<td>{{ findComponent(keyboard.case).price }}</td>
											</tr>
										</tbody>
									</v-simple-table>
								</v-col>
							</v-row>
						</v-card-text>
						<v-card-actions> </v-card-actions>
					</v-card>
					<v-card v-else>
						<v-card-title class="justify-center display-2"
							>Ordering...</v-card-title
						>
						<v-card-text>
							<v-row class="justify-center">
								<v-progress-circular
									indeterminate
									color="primary"
									:size="300"
									:width="10"
								></v-progress-circular>
							</v-row>
						</v-card-text>
					</v-card>
				</v-stepper-content>

				<v-stepper-content step="9">
					<v-card v-if="!errors">
						<v-card-title class="display-1 justify-center"
							>Order successful!</v-card-title
						>
						<v-card-text>
							<v-row class="justify-center"
								><v-icon color="success" size="300"
									>mdi-check-circle</v-icon
								></v-row
							>
							<v-row class="text-h4 justify-center"
								>Thank you for ordering from us!</v-row
							>
							<v-row class="text-subtitle-1 justify-center">
								Your tracking id is
								<input type="hidden" id="tracking_id" :value="tracking_id" />
								<span class="primary--text ml-1"> {{ tracking_id }}</span>
							</v-row>
						</v-card-text>
					</v-card>
					<v-card v-if="errors">
						<v-card-title class="display-1 justify-center">Error</v-card-title>
						<v-card-text>
							<v-row class="justify-center"
								><v-icon color="error" size="300"
									>mdi-alert-circle</v-icon
								></v-row
							>
							<v-row class="text-h4 justify-center"
								>Something went wrong in the ordering process!</v-row
							>
							<v-row class="text-subtitle-1 justify-center">
								Try again later.
							</v-row>
						</v-card-text>
					</v-card>
				</v-stepper-content>
			</v-stepper-items>
		</v-stepper>
	</div>
</template>

<script>
import CustomizePanel from "./KeyboardCustomizePanel";
import CablePanel from "./CableCustomizePanel";
import { Inertia } from "@inertiajs/inertia";
export default {
	components: {
		CustomizePanel,
		CablePanel,
	},
	mounted() {
		axios.get("/inventory/components/colors").then((res) => {
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
					(item) => item.id == this.keyboard[value]
				);
				if (!!comp[0]) keyboardPrice += parseFloat(comp[0].price);
			});

			return keyboardPrice;
		},
		caseOptions() {
			if (this.components.length < 4) return [];

			return this.components[3].filter(
				(c) => c.layout_id == this.keyboard.layout
			);
		},
		plateOptions() {
			if (this.components.length < 4) return [];
			return this.components[2].filter(
				(c) => c.layout_id == this.keyboard.layout
			);
		},
		customerValid() {
			const validComp =
				this.keyboard.switch != "" &&
				this.keyboard.keycap != "" &&
				this.keyboard.case != "" &&
				this.keyboard.plate != "";

			return (
				this.customer.name != "" && this.customer.messenger != "" && validComp
			);
		},
		layoutName() {
			switch (this.keyboard.layout) {
				case 1:
					return "Full-size";
					break;
				case 2:
					return "1800-compact";
					break;
				case 3:
					return "Tenkeyless";
					break;
				case 4:
					return "75%";
					break;
				case 5:
					return "60%";
					break;
				case 6:
					return "40%";
					break;
				case 7:
					return "20%";
					break;
				default:
					return "Error";
					break;
			}
		},
	},
	data() {
		return {
			colors: [],
			ordering: false,
			errors: false,
			step: 1,
			tracking_id: "the tracking id",
			keyboard: {
				layout: 1,
				switch: 0,
				keycap: 0,
				cable: {},
				plate: 0,
				case: 0,
			},
			customer: {
				name: "",
				messenger: "",
				remarks: "",
			},
		};
	},
	methods: {
		copyToClipboard() {
			console.log("HELLO");
			let copy = document.querySelector("#tracking_id");
			copy.setAttribute("type", "text");
			copy.select;
			document.execCommand("copy");
			copy.setAttribute("type", "hidden");
			window.getSelection().removeAllRanges();
		},
		order() {
			this.ordering = true;
			axios
				.post("/custom", {
					keyboard: this.keyboard,
					customer: this.customer,
				})
				.then(({ data }) => {
					this.tracking_id = data["tracking_id"];
					this.step++;
					this.ordering = false;
					this.errors = false;
				})
				.catch((error) => {
					this.step++;
					this.ordering = false;
					this.errors = true;
				});

			// Inertia.post("/custom", {
			// 	keyboard: this.keyboard,
			// 	customer: this.customer
			// }).then(res => {
			// 	console.log(res);
			// });
		},
		reset() {
			this.step = 1;
			this.keyboard = {
				layout: 1,
				switch: 0,
				keycap: 0,
				cable: {},
				plate: 0,
				case: 0,
			};
		},
		layoutSelect(id) {
			this.keyboard.layout = id;
			this.step++;
		},
		layoutDisable(id) {
			if (this.components.length < 4) return true;

			let cases = this.components[3].filter((c) => c.layout_id == id);
			let plates = this.components[2].filter((c) => c.layout_id == id);

			return cases.length <= 0 || plates.length <= 0;
		},
		findComponent(id) {
			// console.log(id);
			let comp = 0;
			this.components.forEach((type) => {
				// console.log(type);
				type.forEach((c) => {
					// console.log(c);
					if (c.id == id) {
						// console.log(c);
						comp = c;
					}
				});
			});
			if (comp == 0)
				return {
					name: "Error",
					price: 0,
				};
			return comp;
		},
	},
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
