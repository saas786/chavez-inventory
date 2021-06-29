<template>
	<v-container>
		<inertia-head>
			<title>Custom Mechanical Keyboards</title>
		</inertia-head>
		<v-container
			v-if="page_status"
			fill-height
			class="align-center justify-center flex-column"
		>
			<v-progress-circular
				indeterminate
				:size="300"
				:width="10"
				color="primary"
			></v-progress-circular>
			<!-- <h1 class="display-1 mt-2">Loading...</h1> -->
		</v-container>
		<slot v-if="!page_status" />
	</v-container>
</template>

<script>
export default {
	computed: {
		page_status: function () {
			return this.$parent.$parent.$parent.page_status;
		},
	},
};
</script>
