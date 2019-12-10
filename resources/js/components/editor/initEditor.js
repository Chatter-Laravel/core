import { events } from '../../events'
import { Editor } from 'tiptap'
import {
    Blockquote,
    HardBreak,
    OrderedList,
    BulletList,
    ListItem,
    Bold,
    Italic,
    Link,
    Strike,
    Underline,
    History,
} from 'tiptap-extensions'

export default new Editor({
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
    ],
    content: ``,
    onUpdate: ({getHTML}) => {
        window.ChatterEvents.$emit(events.DISCUSSION_CONTENT_UPDATE, getHTML())
    }
})