export default class Discussion {
    constructor(discussion = {}) {
        this.title = discussion.title ? discussion.title : ''
        this.body = discussion.body ? discussion.body : ''     
        this.category = discussion.category ? discussion.category : ''
    }
}