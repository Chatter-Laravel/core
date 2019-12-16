<template>
    <div class="w-full sm:w-3/12 ">
        <div class="p-2 sm:p-4 sm:pt-4 sm:sticky sm:top-0">
            <div class="w-full pb-2">
                <new-discussion-button></new-discussion-button>
            </div>

            <div class="flex flex-col">
                <router-link 
                        :to="{ name: 'chatter.home' }"
                        class="flex font-light hover:font-bold items-center pt-2"
                    >
                        <div class="inline-block rounded-full w-6 h-6 bg-gray-300 mr-2"></div>
                        All discussions
                    </router-link>

                <div v-for="c in categories" v-bind:key="c.slug" class="pt-2">
                    <router-link 
                        :to="{ name: 'chatter.category', params: { category: c.slug }}"
                        class="flex font-light hover:font-bold items-center"
                    >
                        <div class="inline-block rounded-full w-6 h-6 hover:bg-gray-900 mr-2" :style="`background-color: ${ c.color }`"></div>
                        {{ c.name }}
                    </router-link>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { mapGetters } from 'vuex'
import NewDiscussionButton from '../components/NewDiscussionButton'
export default {
    components: {
        NewDiscussionButton
    },
    computed: {
        ...mapGetters(['categories'])
    }
}
</script>

<style>
.router-link-exact-active {
    font-weight: 700;
}
</style>