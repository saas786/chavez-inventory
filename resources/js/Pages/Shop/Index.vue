<template>
	<v-container fluid>
		<v-row>
			<v-carousel hide-delimiters height="50vh" cycle>
				<v-carousel-item>
					<v-card link href="/shop" max-width="100%" height="100%">
						<v-parallax
							src="https://cdn.pixabay.com/photo/2020/07/12/07/47/bee-5396362_1280.jpg"
						>
							<v-row
								class="fill-height flex-column"
								align="center"
								justify="center"
							>
								<div class="text-subtitle-1">
									Make a keyboard that suits <i>your</i> tastes!
								</div>
								<h1 class="text-h2">Customize Now</h1>
							</v-row>
						</v-parallax>
					</v-card>
				</v-carousel-item>
				<v-carousel-item>
					<v-card link href="/shop" max-width="100%" height="100%">
						<v-parallax
							src="https://cdn.pixabay.com/photo/2020/07/12/07/47/bee-5396362_1280.jpg"
						>
							<v-row
								class="fill-height flex-column"
								align="center"
								justify="center"
							>
								<div class="text-subtitle-1">
									Choose a keyboard already lovingly crafted
								</div>
								<h1 class="text-h2">Adopt a Keyboard</h1>
							</v-row>
						</v-parallax>
					</v-card>
				</v-carousel-item>
			</v-carousel>
		</v-row>
		<v-row>
			<v-col cols="4">
				<v-card height="25vh" link href="/">
					<v-img
						height="100%"
						src="https://cdn.pixabay.com/photo/2020/07/12/07/47/bee-5396362_1280.jpg"
					>
						<v-row>
							<div>About Us</div>
						</v-row>
					</v-img>
				</v-card>
			</v-col>
			<v-col cols="4">
				<v-card height="25vh" link href="/">
					<v-img
						height="100%"
						src="https://cdn.pixabay.com/photo/2020/07/12/07/47/bee-5396362_1280.jpg"
					>
						<v-row>
							<div>FAQs</div>
						</v-row>
					</v-img>
				</v-card>
			</v-col>
			<v-col cols="4">
				<v-card height="25vh" link href="/">
					<v-img
						height="100%"
						src="https://cdn.pixabay.com/photo/2020/07/12/07/47/bee-5396362_1280.jpg"
					>
						<v-row>
							<div>Something Else</div>
						</v-row>
					</v-img>
				</v-card>
			</v-col>
		</v-row>
	</v-container>
</template>

<script>
import Layout from "./../../Shared/Layout";
import ShopLayout from "./../../Shared/ShopLayout";

export default {
	layout: (h, page) => {
		return h(Layout, [h(ShopLayout, [page])]);
	},

	mounted() {},
};
</script>
