<template>
	<div class="d-flex flex-column" style="height: 100%">
		<div v-if="editor" class="d-inline-flex flex-wrap">
			<v-tooltip top>
				<template v-slot:activator="{ on, attrs }">
					<v-btn
						small
						v-bind="attrs"
						v-on="on"
						class="mx-0"
						tile
						color="secondary"
						@click="editor.chain().focus().toggleBold().run()"
						:outlined="!editor.isActive('bold')"
					>
						B
					</v-btn>
				</template>
				<span>Bold</span>
			</v-tooltip>
			<v-tooltip top>
				<span>Italic</span>
				<template v-slot:activator="{ on, attrs }">
					<v-btn
						small
						v-bind="attrs"
						v-on="on"
						class="mx-0"
						tile
						color="secondary"
						@click="editor.chain().focus().toggleItalic().run()"
						:outlined="!editor.isActive('italic')"
					>
						<i>I</i>
					</v-btn>
				</template>
			</v-tooltip>
			<v-tooltip top>
				<span>Strikethrough</span>
				<template v-slot:activator="{ on, attrs }">
					<v-btn
						small
						v-bind="attrs"
						v-on="on"
						tile
						color="secondary"
						@click="editor.chain().focus().toggleStrike().run()"
						:outlined="!editor.isActive('strike')"
					>
						<s>S</s>
					</v-btn>
				</template>
			</v-tooltip>
			<v-tooltip top>
				<span>Code</span>
				<template v-slot:activator="{ on, attrs }">
					<v-btn
						small
						v-bind="attrs"
						v-on="on"
						tile
						color="secondary"
						@click="editor.chain().focus().toggleCode().run()"
						:outlined="!editor.isActive('code')"
					>
						{{ "<\/\>" }}
					</v-btn>
				</template>
			</v-tooltip>
			<v-tooltip top>
				<span>Clear</span>
				<template v-slot:activator="{ on, attrs }">
					<v-btn
						small
						v-bind="attrs"
						v-on="on"
						tile
						outlined
						color="error"
						@click="editor.chain().focus().unsetAllMarks().run()"
					>
						Clear
					</v-btn>
				</template>
			</v-tooltip>
			<v-tooltip top>
				<span>Paragraph</span>
				<template v-slot:activator="{ on, attrs }">
					<v-btn
						small
						v-bind="attrs"
						v-on="on"
						tile
						color="secondary"
						@click="editor.chain().focus().setParagraph().run()"
						:outlined="!editor.isActive('paragraph')"
					>
						¶
					</v-btn>
				</template>
			</v-tooltip>
			<v-tooltip top>
				<span>Heading 1</span>
				<template v-slot:activator="{ on, attrs }">
					<v-btn
						small
						v-bind="attrs"
						v-on="on"
						tile
						color="secondary"
						@click="editor.chain().focus().toggleHeading({ level: 1 }).run()"
						:outlined="!editor.isActive('heading', { level: 1 })"
					>
						h1
					</v-btn>
				</template>
			</v-tooltip>
			<v-tooltip top>
				<span>Heading 2</span>
				<template v-slot:activator="{ on, attrs }">
					<v-btn
						small
						v-bind="attrs"
						v-on="on"
						tile
						color="secondary"
						@click="editor.chain().focus().toggleHeading({ level: 2 }).run()"
						:outlined="!editor.isActive('heading', { level: 2 })"
					>
						h2
					</v-btn>
				</template>
			</v-tooltip>
			<v-tooltip top>
				<span>Heading 3</span>
				<template v-slot:activator="{ on, attrs }">
					<v-btn
						small
						v-bind="attrs"
						v-on="on"
						tile
						color="secondary"
						@click="editor.chain().focus().toggleHeading({ level: 3 }).run()"
						:outlined="!editor.isActive('heading', { level: 3 })"
					>
						h3
					</v-btn>
				</template>
			</v-tooltip>
			<v-tooltip top>
				<span>Heading 4</span>
				<template v-slot:activator="{ on, attrs }">
					<v-btn
						small
						v-bind="attrs"
						v-on="on"
						tile
						color="secondary"
						@click="editor.chain().focus().toggleHeading({ level: 4 }).run()"
						:outlined="!editor.isActive('heading', { level: 4 })"
					>
						h4
					</v-btn>
				</template>
			</v-tooltip>
			<v-tooltip top>
				<span>Heading 5</span>
				<template v-slot:activator="{ on, attrs }">
					<v-btn
						small
						v-bind="attrs"
						v-on="on"
						tile
						color="secondary"
						@click="editor.chain().focus().toggleHeading({ level: 5 }).run()"
						:outlined="!editor.isActive('heading', { level: 5 })"
					>
						h5
					</v-btn>
				</template>
			</v-tooltip>
			<v-tooltip top>
				<span>Heading 6</span>
				<template v-slot:activator="{ on, attrs }">
					<v-btn
						small
						v-bind="attrs"
						v-on="on"
						tile
						color="secondary"
						@click="editor.chain().focus().toggleHeading({ level: 6 }).run()"
						:outlined="!editor.isActive('heading', { level: 6 })"
					>
						h6
					</v-btn>
				</template>
			</v-tooltip>
			<v-tooltip top>
				<span>Unordered List</span>
				<template v-slot:activator="{ on, attrs }">
					<v-btn
						small
						v-bind="attrs"
						v-on="on"
						tile
						color="secondary"
						@click="editor.chain().focus().toggleBulletList().run()"
						:outlined="!editor.isActive('bulletList')"
					>
						<v-icon>mdi-format-list-bulleted</v-icon>
					</v-btn>
				</template>
			</v-tooltip>
			<v-tooltip top>
				<span>Ordered List</span>
				<template v-slot:activator="{ on, attrs }">
					<v-btn
						small
						v-bind="attrs"
						v-on="on"
						tile
						color="secondary"
						@click="editor.chain().focus().toggleOrderedList().run()"
						:outlined="!editor.isActive('orderedList')"
					>
						<v-icon>mdi-format-list-numbered</v-icon>
					</v-btn>
				</template>
			</v-tooltip>
			<v-tooltip top>
				<span>Codeblock</span>
				<template v-slot:activator="{ on, attrs }">
					<v-btn
						small
						v-bind="attrs"
						v-on="on"
						tile
						color="secondary"
						@click="editor.chain().focus().toggleCodeBlock().run()"
						:outlined="!editor.isActive('codeBlock')"
					>
						<v-icon>mdi-code-tags</v-icon>
					</v-btn>
				</template>
			</v-tooltip>
			<v-tooltip top>
				<span>Blockquote</span>
				<template v-slot:activator="{ on, attrs }">
					<v-btn
						small
						v-bind="attrs"
						v-on="on"
						tile
						color="secondary"
						@click="editor.chain().focus().toggleBlockquote().run()"
						:outlined="!editor.isActive('blockquote')"
					>
						<v-icon>mdi-format-quote-close</v-icon>
					</v-btn>
				</template>
			</v-tooltip>
			<v-tooltip top>
				<span>Clear Formatting</span>
				<template v-slot:activator="{ on, attrs }">
					<v-btn
						small
						v-bind="attrs"
						v-on="on"
						tile
						outlined
						color="error"
						@click="editor.chain().focus().clearNodes().run()"
					>
						Clear
					</v-btn>
				</template>
			</v-tooltip>
			<v-tooltip top>
				<span>Horizontal Rule</span>
				<template v-slot:activator="{ on, attrs }">
					<v-btn
						small
						v-bind="attrs"
						v-on="on"
						tile
						outlined
						color="secondary"
						@click="editor.chain().focus().setHorizontalRule().run()"
					>
						<v-icon>mdi-minus</v-icon>
					</v-btn>
				</template>
			</v-tooltip>
			<v-tooltip top>
				<span>Line Break</span>
				<template v-slot:activator="{ on, attrs }">
					<v-btn
						small
						v-bind="attrs"
						v-on="on"
						tile
						outlined
						color="secondary"
						@click="editor.chain().focus().setHardBreak().run()"
					>
						break
					</v-btn>
				</template>
			</v-tooltip>
			<v-tooltip top>
				<span>Undo</span>
				<template v-slot:activator="{ on, attrs }">
					<v-btn
						small
						v-bind="attrs"
						v-on="on"
						outlined
						tile
						color="secondary"
						@click="editor.chain().focus().undo().run()"
					>
						<v-icon>mdi-undo</v-icon>
					</v-btn>
				</template>
			</v-tooltip>
			<v-tooltip top>
				<span>Redo</span>
				<template v-slot:activator="{ on, attrs }">
					<v-btn
						small
						v-bind="attrs"
						v-on="on"
						outlined
						tile
						color="secondary"
						@click="editor.chain().focus().redo().run()"
					>
						<v-icon>mdi-redo</v-icon>
					</v-btn>
				</template>
			</v-tooltip>
		</div>
		<editor-content style="height: 100%" :editor="editor" />
	</div>
</template>

<script>
import { Editor, EditorContent } from "@tiptap/vue-2";
import StarterKit from "@tiptap/starter-kit";
import Blockquote from "@tiptap/extension-blockquote";

export default {
	components: {
		EditorContent,
	},
	props: {
		tableName: {
			type: String,
		},
		value: {
			type: String,
			default: "",
		},
	},

	watch: {
		value(value) {
			const isSame = this.editor.getHTML() === value;

			if (isSame) {
				return;
			}

			this.editor.commands.setContent(this.value, false);
		},
	},

	data() {
		return {
			editor: null,
		};
	},

	mounted() {
		this.editor = new Editor({
			content: this.value,
			onUpdate: () => {
				this.$emit("input", this.editor.getHTML());
			},
			editorProps: {
				attributes: {
					style: "height: 100%",
				},
			},
			extensions: [
				StarterKit,
				Blockquote.configure({
					HTMLAttributes: {
						class: "blockquote",
					},
				}),
			],
		});
	},

	beforeDestroy() {
		this.editor.destroy();
	},
};
</script>

<style scoped>
.tip-tap-wrapper {
	height: 100%;
}
</style>
