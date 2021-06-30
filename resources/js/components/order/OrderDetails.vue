<template>
	<v-card>
		<v-card-text>
			<v-row>
				<v-col cols="4" v-if="item.description">
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
				<v-col :cols="item.description ? 8 : 12">
					<v-row>
						<v-col>
							<v-text-field
								outlined
								dense
								label="Name"
								readonly
								:value="item.name || `Custom Keyboard`"
							></v-text-field>
						</v-col>
						<v-col>
							<v-currency-field
								label="Price"
								:value="item.price || keyboard.price"
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
										<td>{{ keyboard.switch.name }}</td>
										<th>Keycap</th>
										<td>{{ keyboard.keycap.name }}</td>
									</tr>
									<tr>
										<th>Plate</th>
										<td>{{ keyboard.plate.name }}</td>
										<th>Case</th>
										<td>{{ keyboard.case.name }}</td>
									</tr>
									<tr>
										<th>Cable Length</th>
										<td>1</td>
										<th>Coil Width</th>
										<td>2</td>
									</tr>
									<tr>
										<th>Cable Color</th>
										<td>{{ keyboard.cable.color.name }}</td>
										<th>Detachable?</th>
										<td>
											{{ keyboard.cable.detachable ? "Yes" : "No" }}
										</td>
									</tr>
									<tr>
										<th>Double Sleeved?</th>
										<td>
											{{ keyboard.cable.double_sleeved ? "Yes" : "No" }}
										</td>
										<th v-if="keyboard.cable.double_sleeved">Sleeve Color</th>
										<td v-if="keyboard.cable.double_sleeved">
											{{ keyboard.cable.double_sleeve_color.name }}
										</td>
									</tr>
								</tbody>
							</v-simple-table>
						</v-col>
					</v-row>
				</v-col>
			</v-row>
		</v-card-text>
	</v-card>
</template>

<script>
export default {
	props: ["item"],
	computed: {
		keyboard() {
			return this.item.keyboard;
		},
	},
	mounted() {
		console.log(this.item.keyboard);
	},
};
</script>

<style></style>
