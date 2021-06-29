<template>
	<v-card>
		<v-card-title
			>Total Price: &#8369;{{
				Math.round((price + Number.EPSILON) * 100) / 100
			}}</v-card-title
		>
		<v-card-text class="text-center">
			<v-row>
				<v-col
					cols="1"
					v-if="
						!(
							$vuetify.breakpoint.name == 'xs' ||
							$vuetify.breakpoint.name == 'sm'
						)
					"
				>
					<v-btn class="full-height" @click="$emit('step-back')"
						><v-icon>mdi-arrow-left</v-icon></v-btn
					>
				</v-col>
				<v-col class="col-md-10 col-sm-12">
					<v-container fluid>
						<v-row align="center" justify="center">
							<v-img
								lazy-src="https://via.placeholder.com/400"
								:src="image_url"
								contain
								:aspect-ratio="1 / 1"
								:max-height="imageDim"
								:max-width="imageDim"
							>
								<template v-slot:placeholder>
									<v-row
										class="fill-height ma-0"
										align="center"
										justify="center"
									>
										<v-progress-circular
											indeterminate
											color="grey lighten-5"
										></v-progress-circular>
									</v-row>
								</template>
							</v-img>
						</v-row>
					</v-container>
					<v-select v-model="selectId" :items="selectItems"></v-select>
				</v-col>
				<v-col
					cols="1"
					v-if="
						!(
							$vuetify.breakpoint.name == 'xs' ||
							$vuetify.breakpoint.name == 'sm'
						)
					"
				>
					<v-btn
						color="primary"
						class="full-height"
						:disabled="!this.select_id"
						@click="$emit('step-forward')"
						><v-icon>mdi-arrow-right</v-icon></v-btn
					>
				</v-col>
			</v-row>
			<v-row
				v-if="
					$vuetify.breakpoint.name == 'xs' || $vuetify.breakpoint.name == 'sm'
				"
			>
				<v-col>
					<v-btn @click="$emit('step-back')" width="100%"
						><v-icon>mdi-arrow-left</v-icon></v-btn
					>
				</v-col>
				<v-col>
					<v-btn
						color="primary"
						height="100%"
						width="100%"
						:disabled="!this.select_id"
						@click="$emit('step-forward')"
						><v-icon>mdi-arrow-right</v-icon></v-btn
					>
				</v-col>
			</v-row>
		</v-card-text>
		<!-- <v-card-actions>
			<v-btn @click="$emit('step-back')" color="error">Back</v-btn>
			<v-btn
				:disabled="!this.select_id"
				@click="$emit('step-forward')"
				color="secondary"
				>Next</v-btn
			>
		</v-card-actions> -->
	</v-card>
</template>

<script>
export default {
	props: ["items", "layout", "price", "select_id"],
	data() {
		return {
			image_url: "",
		};
	},
	computed: {
		selectId: {
			get: function () {
				return this.select_id;
			},
			set: function (v) {
				this.image_url = this.items.filter((i) => i.id == v)[0].url;
				this.$emit("select-update", v);
			},
		},
		selectItems() {
			return this.items.map((item) => {
				return { text: `${item.name} - ₱${item.price}`, value: item.id };
			});
		},
		imageDim() {
			switch (this.$vuetify.breakpoint.name) {
				case "xs":
					return 200;
				case "sm":
					return 200;
				case "md":
					return 400;
				case "lg":
					return 400;
				case "xl":
					return 400;
			}
			return 200;
		},
	},
};
</script>

<style>
.full-height {
	height: 100% !important;
}
</style>
