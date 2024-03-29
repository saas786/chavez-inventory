<template>
	<v-dialog max-width="1200">
		<template v-slot:activator="{ attrs, on }">
			<v-card v-on="on" v-bind="attrs" elevation="0">
				<v-img :src="item.url" height="150" class="darken--image">
					<v-card-title class="catalog-item-title">
						{{ item.name }}
					</v-card-title>
				</v-img>
				<v-card-subtitle class="primary--text"
					>₱{{ item.price }}</v-card-subtitle
				>
				<v-card-text>
					{{ item.description }}
				</v-card-text>
			</v-card>
		</template>
		<v-card>
			<v-card-text>
				<v-row>
					<v-col cols="4">
						<v-row>
							<v-col>
								<v-img
									:src="item.url"
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
							</v-col>
						</v-row>
						<v-row>
							<v-col>
								<v-textarea
									outlined
									dense
									readonly
									label="Description"
									:value="item.description"
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
									label="Name"
									readonly
									:value="item.name"
								></v-text-field>
							</v-col>
							<v-col>
								<v-currency-field
									label="Price"
									:value="item.price"
									outlined
									dense
									prefix="₱"
								></v-currency-field>
							</v-col>
						</v-row>
						<v-row>
							<v-col>
								<v-simple-table>
									<tbody>
										<tr>
											<th>Layout</th>
											<td colspan="3">Full-size</td>
										</tr>
										<tr>
											<th>Switch</th>
											<td>{{ item.keyboard.switch.name }}</td>
											<th>Keycap</th>
											<td>{{ item.keyboard.keycap.name }}</td>
										</tr>
										<tr>
											<th>Plate</th>
											<td>{{ item.keyboard.plate.name }}</td>
											<th>Case</th>
											<td>{{ item.keyboard.case.name }}</td>
										</tr>
										<tr>
											<th>Cable Length</th>
											<td>1</td>
											<th>Coil Width</th>
											<td>2</td>
										</tr>
										<tr>
											<th>Cable Color</th>
											<td>{{ item.keyboard.cable.color.name }}</td>
											<th>Detachable?</th>
											<td>
												{{ item.keyboard.cable.detachable ? "Yes" : "No" }}
											</td>
										</tr>
										<tr>
											<th>Double Sleeved?</th>
											<td>
												{{ item.keyboard.cable.double_sleeved ? "Yes" : "No" }}
											</td>
											<th v-if="item.keyboard.cable.double_sleeved">
												Sleeve Color
											</th>
											<td v-if="item.keyboard.cable.double_sleeved">
												{{ item.keyboard.cable.double_sleeve_color.name }}
											</td>
										</tr>
									</tbody>
								</v-simple-table>
							</v-col>
						</v-row>
					</v-col>
				</v-row>
			</v-card-text>
			<v-card-actions class="justify-center" v-if="!readonly">
				<v-dialog max-width="500">
					<template v-slot:activator="{ on, attrs }">
						<v-btn
							color="success"
							@click="$emit('order', item.id)"
							outlined
							v-on="on"
							v-bind="attrs"
							>Order</v-btn
						>
					</template>
					<v-card>
						<v-card-title>Customer details</v-card-title>
						<v-card-text>
							<v-text-field label="Name" v-model="customer_name"></v-text-field>
							<v-text-field
								label="Messenger Name"
								v-model="messenger_name"
							></v-text-field>
						</v-card-text>
						<v-card-actions>
							<v-btn
								class="mx-auto black--text"
								color="success"
								@click="orderItem"
								:disabled="!customer_name || !messenger_name"
								>Order</v-btn
							>
						</v-card-actions>
					</v-card>
				</v-dialog>
			</v-card-actions>
		</v-card>
	</v-dialog>
</template>

<script>
import { Inertia } from "@inertiajs/inertia";
export default {
	props: ["item", "readonly"],
	data() {
		return {
			customer_name: "",
			messenger_name: "",
			order: false,
		};
	},
	methods: {
		orderItem() {
			Inertia.post("/shop", {
				customer_name: this.customer_name,
				messenger_name: this.messenger_name,
				prebuilt_order_id: this.item.id,
			});
		},
	},
};
</script>

<style>
.catalog-item-title {
	position: absolute;
	bottom: 0;
	font-size: 1.5em;
	text-shadow: 0 0 5px black;
}
</style>
