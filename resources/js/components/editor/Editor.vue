<template>
  <div v-cloak class="editor border shadow rounded-t">
    <editor-menu-bar :editor="editor" v-slot="{ commands, isActive }">
      <div class="flex flex-wrap">

        <button
            :class="[{ 'bg-gray-300': isActive.bold() }, buttonClass]"
            @click="commands.bold"
        >
          <icon name="bold" />
        </button>

        <button
            :class="[{ 'bg-gray-300': isActive.italic() }, buttonClass]"
            @click="commands.italic"
        >
          <icon name="italic" />
        </button>

        <button
            :class="[{ 'bg-gray-300': isActive.underline() }, buttonClass]"
            @click="commands.underline"
        >
          <icon name="underline" />
        </button>

        <button
            :class="[{ 'bg-gray-300': isActive.bullet_list() }, buttonClass]"
            @click="commands.bullet_list"
        >
          <icon name="ul" />
        </button>

        <button
            :class="[{ 'bg-gray-300': isActive.ordered_list() }, buttonClass]"
            @click="commands.ordered_list"
        >
          <icon name="ol" />
        </button>

        <button
            :class="[{ 'bg-gray-300': isActive.blockquote() }, buttonClass]"
            @click="commands.blockquote"
        >
          <icon name="quote" />
        </button>

        <button
            :class="[{ 'bg-gray-300': isActive.image() }, buttonClass]"
            @click="showImagePrompt(commands.image)"
        >
          <icon name="image" />
        </button>

        <button
            :class="[buttonClass]"
            @click="commands.undo"
        >
          <icon name="undo" />
        </button>

        <button
            :class="[buttonClass]"
            @click="commands.redo"
        >
          <icon name="redo" />
        </button>

      </div>
    </editor-menu-bar>

    <editor-content class="editor__content shadow rounded-b" :editor="editor" />
  </div>
</template>

<script>
import { events } from '../../events'
import Icon from './Icon'
import { Editor, EditorContent, EditorMenuBar } from 'tiptap'
import {
    Blockquote,
    CodeBlock,
    HardBreak,
    Heading,
    HorizontalRule,
    OrderedList,
    BulletList,
    ListItem,
    TodoItem,
    TodoList,
    Bold,
    Code,
    Italic,
    Link,
    Strike,
    Underline,
    History,
    Image
} from 'tiptap-extensions'

export default {
    components: {
        EditorContent,
        EditorMenuBar,
        Icon,
    },
    props: {
        event: {
            type: String,
            default: events.DISCUSSION_CONTENT_UPDATE
        }
    },
    data() {
        return {
            editor: new Editor({
                extensions: [
                    new Blockquote(),
                    new BulletList(),
                    new HardBreak(),
                    // new Heading({ levels: [1, 2, 3] }),
                    new ListItem(),
                    new OrderedList(),
                    new Link(),
                    new Bold(),
                    new Italic(),
                    new Strike(),
                    new Underline(),
                    new History(),
                    new Image()
                ],
                content: ``,
                onUpdate: ({getHTML}) => {
                    window.ChatterEvents.$emit(this.event, getHTML())
                }
            }),
            buttonClass: "flex-grow sm:flex-grow-0 py-2 px-3 inline-block hover:bg-gray-200 rounded"
        }
    },
    beforeDestroy() {
        if (this.editor) this.editor.destroy();
    },
    methods: {
        showImagePrompt(command) {
            const src = prompt('Enter the url of your image here')
            if (src !== null) {
                command({ src })
            }
        },
    }
}
</script>

<style>
.editor .editor__content {
    min-height: 12rem;
}

.editor h1 {
    font-size: 2.25rem;
}
.editor h2 {
    font-size: 2rem;
}
.editor h3 {
    font-size: 1.75rem;
}

.editor ul {
    list-style-type: disc!important;
    margin-top: 10px;
    margin-left: 30px;
}
.editor ol {
    list-style-type: decimal!important;
    margin-top: 10px;
    margin-left: 30px;
}

.editor blockquote {
    margin-top: 10px;
    margin-left: 30px;
    padding-left: 10px;
    padding-top: 10px;
    padding-bottom: 10px;
    border-left: solid #ccc 4px;
}

.editor .ProseMirror {
    min-height: 12rem;
    padding: 1rem;
    overflow-x: auto;
    outline: none;
    text-align: left;
}
</style>