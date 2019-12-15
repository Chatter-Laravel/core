<template>
    <div class="flex flex-wrap mx-auto antialiased leading-tight">
        <alert></alert>
        
        <app-header></app-header>

        <set-username v-if="auth && !hasUsername"></set-username>

        <app-menu></app-menu>

        <div class="w-full sm:w-9/12 p-4 sm:pl-0">
            <keep-alive>
                <router-view></router-view>
            </keep-alive>
        </div>

        <new-discussion></new-discussion>
    </div>
</template>
<script>
import { mapMutations, mapGetters } from 'vuex'

import AppHeader from './AppHeader'
import AppMenu from './AppMenu'
import NewDiscussion from '../components/NewDiscussion'
import Alert from '../components/Alert'
import SetUsername from '../components/SetUsername'

export default {
    components: { AppHeader, AppMenu, NewDiscussion, Alert, SetUsername },
    props: {
        appName: String,
        page: Number,
        categories: Array,
        logged: Boolean,
        hasUsername: Boolean
    },
    created() {
        this.setAuth(this.logged)        
        this.setName(this.appName)
        this.setTitle(this.appName)
        this.setCategories(this.categories)
        this.setCategoryPage(this.page)
        this.setDiscussionPage(this.page)
    },
    methods: {
        ...mapMutations([
            'setAuth',
            'setName',
            'setTitle',
            'setCategories',
            'setCategoryPage',
            'setDiscussionPage'
        ])
    },
    computed: {
        ...mapGetters([
            'title',
            'name',
            'auth'
        ])
    },
    watch: {
        title() {
            if (undefined === this.title) {
                document.title = this.name
            } else {
                document.title = this.title + ' | ' + this.name
            }
            
        }
    }
}
</script>