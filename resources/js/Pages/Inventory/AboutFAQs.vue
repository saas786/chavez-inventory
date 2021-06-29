<template>
	<v-container fill-height>
		<v-row>
			<v-col cols="1">
				<v-row class="justify-end">
					<h2>A</h2>
				</v-row>
				<v-row class="justify-end">
					<h2>B</h2>
				</v-row>
				<v-row class="justify-end">
					<h2>O</h2>
				</v-row>
				<v-row class="justify-end">
					<h2>U</h2>
				</v-row>
				<v-row class="justify-end">
					<h2>T</h2>
				</v-row>
			</v-col>
			<v-col cols="11">
				<tiptap-editor tableName="about" v-model="about"></tiptap-editor>
			</v-col>
		</v-row>
		<v-row>
			<v-col cols="1">
				<v-row class="justify-end">
					<h2>F</h2>
				</v-row>
				<v-row class="justify-end">
					<h2>A</h2>
				</v-row>
				<v-row class="justify-end">
					<h2>Q</h2>
				</v-row>
				<v-row class="justify-end">
					<h2>s</h2>
				</v-row>
			</v-col>
			<v-col cols="11">
				<tiptap-editor tableName="faqs" v-model="faqs"></tiptap-editor>
			</v-col>
		</v-row>
		<v-btn block @click="updateFields">Save</v-btn>
	</v-container>
</template>

<script>
import InventoryLayout from "./../../Shared/InventoryLayout";
import Layout from "./../../Shared/Layout";
import TiptapEditor from "./../../components/TiptapEditor";
import { Inertia } from "@inertiajs/inertia";

export default {
	components: { TiptapEditor },
	props: ["aboutContent", "faqsContent"],

	layout: (h, page) => {
		return h(Layout, [h(InventoryLayout, [page])]);
	},

	data: () => ({
		about: "",
		faqs: "",
	}),

	methods: {
		updateFields() {
			const url = "/inventory/about_faqs/";

			Inertia.post(url, {
				about: this.about,
				faqs: this.faqs,
			});
		},
	},

	mounted() {
		this.about = this.aboutContent;
		this.faqs = this.faqsContent;
	},
};
</script>
