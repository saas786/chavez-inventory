<template>
	<v-stepper v-model="step">
		<v-stepper-header>
			<v-stepper-step :complete="step > 1" step="1">Layout</v-stepper-step>
			<v-stepper-step :complete="step > 2" step="2">Switches</v-stepper-step>
			<v-stepper-step :complete="step > 3" step="3">Keycaps</v-stepper-step>
			<v-stepper-step :complete="step > 4" step="4">Cable</v-stepper-step>
			<v-stepper-step :complete="step > 5" step="5">Plate</v-stepper-step>
			<v-stepper-step :complete="step > 6" step="6">Case</v-stepper-step>
			<v-stepper-step :complete="step > 7" step="7"
				>Customer Details</v-stepper-step
			>
			<v-stepper-step :complete="step > 8" step="8">Done!</v-stepper-step>
		</v-stepper-header>
	</v-stepper>
</template>

<script>
export default {
	props: ["components"],
	computed: {
		caseOptions() {
			return [];
		},
		plateOptions() {
			return [];
		}
	},
	data() {
		return {
			step: 1,
			keyboard: {
				layout: 1,
				switch: 0,
				keycap: 0,
				cable: {
					length: 0,
					coil: 0,
					color: ""
				},
				plate: 0,
				case: 0
			}
		};
	}
};
</script>

<style></style>
