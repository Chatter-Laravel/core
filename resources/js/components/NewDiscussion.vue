<template>
    <div>
        <transition name="fade">
            <div v-if="visible && discussion" class="fixed inset-0 w-full h-screen flex items-center justify-center bg-semi-75" style="z-index:999;">
                    <div @click="closeModal()" class="modal-overlay absolute w-full h-full bg-gray-900 opacity-50"></div>

                    <div class="modal-container overflow-x-auto bg-white w-full h-screen sm:h-auto sm:w-10/12 md:max-w-xl mx-auto shadow-2xl" style="z-index:9999;">
                        <!-- Add margin if you want to see some of the overlay behind the modal-->
                        <div class="modal-content p-2 px-4 text-left">
                            <!--Title-->
                            <div class="flex justify-between items-center">
                                <p class="text-2xl">New discussion</p>
                                <div @click="closeModal()" class="modal-close cursor-pointer z-50 p-4">
                                    <svg class="fill-current text-black" height="18" viewbox="0 0 18 18" width="18" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M14.53 4.53l-1.06-1.06L9 7.94 4.53 3.47 3.47 4.53 7.94 9l-4.47 4.47 1.06 1.06L9 10.06l4.47 4.47 1.06-1.06L10.06 9z"></path>
                                    </svg>
                                </div>
                            </div>

                            <!--Body-->
                            <div>
                                <div v-if="errors" class="p-2 rounded shadow bg-red-200 text-red-700">
                                    <div v-for="(value, key, index) in errors">{{ value[0] }}</div>
                                </div>

                                <div class="pt-2">
                                    <label for="title">Title</label>
                                    <input v-model="discussion.title" name="title" class="block appearance-none w-full bg-white border border-gray-400 hover:border-gray-500 px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline" />
                                </div>
                                
                                <div class="pt-4">
                                    <label for="category" class="py-2">Select a category</label>
                                    <div class="inline-block relative w-full">
                                        <select v-model="discussion.category" name="category" class="block appearance-none w-full bg-white border border-gray-400 hover:border-gray-500 px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline">
                                            <option v-for="c in categories" v-bind:key="c.id" :value="c">{{ c.name }}</option>
                                        </select>
                                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="pt-4">
                                    <editor></editor>
                                </div>

                                <div class="text-right py-4">
                                    <div @click="closeModal()" class="w-32 inline-block bg-gray-200 hover:bg-gray-500 font-bold py-2 px-4 rounded-full text-center cursor-pointer mr-2">
                                        Cancel
                                    </div>

                                    <div @click="save()" class="w-32 inline-block bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-full text-center cursor-pointer">
                                        Create
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        </transition>
    </div>
</template>

<script>
import { mapGetters, mapMutations } from 'vuex'
import { events } from '../events'
import Discussion from '../Discussion'
import Editor from '../components/editor/Editor'

export default {
    components: {
        Editor
    },
    data() {
        return {
            errors: null,
            visible: false,
            discussion: new Discussion(),
        }
    },
    mounted() {
        var self = this

        window.ChatterEvents.$on(events.NEW_DISCUSSION, () => {
            self.openModal()
        })

        window.ChatterEvents.$on(events.DISCUSSION_CONTENT_UPDATE, html => {
            self.discussion.body = html
        })
    },
    computed: {
        ...mapGetters(['categories'])
    },
    methods: {
        ...mapMutations([
            'showAlert'
        ]),
        toggleModal() {
            this.visible = !this.visible
        },
        closeModal() {
            this.visible = false;
        },
        openModal() {
            var self = this;

            axios.post('/api/chatter/discussion')
                .then(response => {
                    self.visible = true;
                })
                .catch(error => {
                    let status = error.response.status

                    if (401 === status) {
                        window.location.href = '/login'
                    } else if (422 === status) {
                        self.visible = true
                    } else {
                        this.showAlert({
                            title: 'Error',
                            text: error.response.data.message,
                            color: 'red'
                        })
                    }

                    console.error(error)
                })
        },
        save() {
            var self = this

            axios.post('/api/chatter/discussion', {
                    title: self.discussion.title,
                    body: self.discussion.body,
                    category_id: self.discussion.category.id
                })
                .then(response => {
                    self.discussion = new Discussion()
                    self.closeModal()

                    this.$router.push({ name: 'chatter.discussion', params: {
                        category: response.data.data.category.slug,
                        title: response.data.data.slug
                    }})
                })
                .catch(error => {
                    console.log(error)

                    let response = error.response

                    if (422 === response.status) {
                        this.errors = response.data.errors
                    } else {
                        this.showAlert({
                            title: 'Error',
                            text: 'Unexpected error, please try again.',
                            color: 'red'
                        })
                    }

                    console.error(error)
                })
        }
    }
}
</script>

<style scoped>
.fade-enter-active, .fade-leave-active {
    transition: opacity .5s;
}
.fade-enter, .fade-leave-to /* .fade-leave-active below version 2.1.8 */ {
    opacity: 0;
}
</style>