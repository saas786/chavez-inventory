<template>
	<div>
		<v-row v-for="cards in deck" v-bind:key="cards.index">
			<v-col
				v-for="item in cards"
				v-bind:key="item.name"
				:cols="cards.deck_cols"
			>
				<catalog-item-card :item="item" @order="order"> </catalog-item-card>
			</v-col>
		</v-row>
	</div>
</template>

<script>
import CatalogItemCard from "../../components/catalog/CatalogItemCard.vue";
import Layout from "./../../Shared/Layout";
import ShopLayout from "./../../Shared/ShopLayout";

export default {
	components: { CatalogItemCard },
	props: ["catalog"],

	computed: {
		deck_width() {
			switch (this.$vuetify.breakpoint.name) {
				case "xs":
					return [2, 6];
				case "sm":
					return [2, 6];
				case "md":
					return [3, 4];
				case "lg":
					return [4, 3];
				case "xl":
					return [4, 3];
			}
		},

		deck() {
			let i, j;
			let arr = this.catalog;
			const chunk = this.deck_width[0];
			let deck = [];

			for (i = 0, j = arr.length; i < j; i += chunk) {
				let cards = arr.slice(i, i + chunk);
				cards.deck_cols = this.deck_width[1];
				deck.push(cards);
			}

			return deck;
		},
	},

	layout: (h, page) => {
		return h(Layout, [h(ShopLayout, [page])]);
	},

	methods: {
		order(e) {
			console.log("Ordered!", e);
		},
	},
};
</script>
