<template>
	<div>
		<v-card>
			<v-card-title>Total Price: ₱{{ price }}</v-card-title>
			<v-card-text>
				<v-row>
					<v-col cols="1">
						<v-btn class="full-height" @click="$emit('step-back')"
							><v-icon>mdi-arrow-left</v-icon></v-btn
						>
					</v-col>
					<v-col>
						<v-sheet class="pa-12 mx-12">
							<v-sparkline
								:gradient="cableGradient"
								gradient-direction="left"
								type="trend"
								auto-draw
								padding="10"
								height="50"
								smooth
								line-width="2"
								stroke-linecap="round"
								:value="cableLine"
							></v-sparkline
						></v-sheet>
						<v-row>
							<v-col cols="4">
								<v-row>
									<v-slider
										v-model="cable.cable_length"
										min="1"
										max="10"
										thumb-label
										:label="`Cable Length ${cable.cable_length} feet`"
									></v-slider>
								</v-row>
								<v-row>
									<v-slider
										v-model="cable.coil_length"
										min="0"
										:max="cable.cable_length"
										hint="Coil length"
										thumb-label
										:label="`Coil Length ${cable.coil_length} inches`"
									></v-slider>
								</v-row>
							</v-col>
							<v-col cols="3">
								<v-row>
									<v-checkbox
										label="Detachable?"
										v-model="cable.detachable"
									></v-checkbox>
								</v-row>
								<v-row>
									<v-checkbox
										label="Double Sleeved?"
										v-model="cable.double_sleeved"
									></v-checkbox>
								</v-row>
							</v-col>
							<v-col cols="4">
								<v-row>
									<v-select
										label="Cable Color"
										v-model="cable.color_id"
										:items="primaryColors"
										item-text="name"
										item-value="id"
									></v-select>
								</v-row>
								<v-row v-if="cable.double_sleeved">
									<v-select
										label="Sleeve Color"
										v-model="cable.double_sleeve_color_id"
										:items="sleeveColors"
										item-text="name"
										item-value="id"
									></v-select>
								</v-row>
							</v-col>
						</v-row>
					</v-col>
					<v-col cols="1">
						<v-btn
							class="full-height"
							@click="nextStep"
							color="priamry"
							:disabled="!valid"
							><v-icon>mdi-arrow-right</v-icon></v-btn
						>
					</v-col>
				</v-row>
			</v-card-text>
			<!-- <v-card-actions>
				<v-btn @click="$emit('step-back')" color="error">Back</v-btn>
				<v-btn @click="nextStep" color="secondary" :disabled="!valid"
					>Next</v-btn
				>
			</v-card-actions> -->
		</v-card>
	</div>
</template>

<script>
export default {
	props: ["colors", "price"],
	computed: {
		valid() {
			return (
				this.cable.color_id != "" &&
				(!this.cable.double_sleeved ||
					(this.cable.double_sleeved &&
						this.cable.double_sleeve_color_id != ""))
			);
		},
		primaryColor() {
			let color = this.colors.filter(c => c.id == this.cable.color_id)[0];
			// console.log("COLOR: ", color);
			if (!!color) return color;
			return {
				name: "No color",
				hex_code: "#FFF"
			};
		},
		sleeveColor() {
			let color = this.colors.filter(
				c => c.id == this.cable.double_sleeve_color_id
			)[0];
			// console.log("COLOR: ", color);
			if (!!color) return color;
			return this.primaryColor;
		},
		cableGradient() {
			if (!this.cable.double_sleeved) this.cable.double_sleeve_color_id = "";
			return [
				this.primaryColor.hex_code,
				this.sleeveColor.hex_code,
				this.sleeveColor.hex_code,
				this.sleeveColor.hex_code,
				this.primaryColor.hex_code
			];
		},
		primaryColors() {
			return this.colors.filter(color => color.primary == true);
		},
		sleeveColors() {
			return this.colors.filter(color => color.double_sleeved == true);
		},
		cableLine() {
			// return [0, 2, 5, 9, 5, 10, 3, 5, 0, 0, 1, 8, 2, 9, 0];
			let values = [1, 1, 1];
			for (let x = 1; x <= this.cable.coil_length; x++) {
				// const add = x % 2 == 0 ? 2 : 0;
				values.push(2);
				values.push(0);
				values.push(1);
			}
			for (let x = 0; x < this.cable.cable_length - this.cable.coil_length; x++)
				for (let y = 0; y < 3; y++) values.push(1);
			values.push(1);
			values.push(1);
			values.push(1);
			return values;
		}
	},
	data() {
		return {
			cable: {
				cable_length: 5,
				coil_length: 0,
				color_id: "",
				double_sleeved: false,
				double_sleeve_color_id: "",
				detachable: false
			}
		};
	},
	methods: {
		nextStep() {
			this.$emit("step-forward");
			this.$emit("select-update", this.cable);
		}
	}
};
</script>
