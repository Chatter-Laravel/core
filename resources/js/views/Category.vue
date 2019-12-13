<template>
    <div>
        <transition name="fade">
            <div v-if="$route.params.category && !loading" class="w-full p-2">Viewing page {{ category.page }}/{{ category.last_page }} of <span class="font-bold">{{ $route.params.category }}</span></div>
            <div v-if="!$route.params.category && !loading" class="w-full p-2">Viewing all discussions {{ category.page }}/{{ category.last_page }}</div>
        
            <div v-if="loading" class="flex flex-wrap">
                <div v-for="d in [0,1,2,3]" v-bind:key="d" class="w-full sm:p-6">
                    <content-loader :height="25">
                        <circle cx="12" cy="12" r="11" />
                        <rect x="34" y="4" rx="3" ry="3" width="100%" height="10" />
                        <rect x="34" y="20" rx="2" ry="2" width="100%" height="6" />
                    </content-loader>
                </div>
            </div>
        </transition>

        <div v-if="!loading" class="flex flex-wrap">
            <div v-for="d in discussions" v-bind:key="d.id" class="w-full">
                <router-link :to="{ name: 'chatter.discussion', params: { category: d.category.slug, title: d.slug }}">
                    <discussion :discussion="d"></discussion>
                </router-link>
            </div>
        </div>

        <div v-if="!loading && discussions.length === 0" class="p-2">
            <div class="h-24 text-gray-700 text-bold text-xl sm:text-2xl flex items-center sm:shadow rounded-lg">
                <div class="w-full text-center">No discussions found in this category</div>
            </div>
        </div>

        <pagination v-if="$route.params.category"
            :getter="category"
            :loading="loading"
            route="chatter.category"
        ></pagination>
        <pagination v-else
            :getter="category"
            :loading="loading"
            route="chatter.home"
        ></pagination>
    </div>
</template>

<script>
import { mapGetters, mapMutations } from 'vuex'
import { ContentLoader } from 'vue-content-loader'
import Discussion from '../components/Discussion'
import Pagination from '../components/Pagination'

export default {
    components: {
        ContentLoader,
        Discussion,
        Pagination
    },
    props: {
        routes: Object
    },
    data() {
        return {
            discussions: [],
        }
    },
    watch: {
        '$route' (to, from) {
            this.setLoading(true)
            this.onRouteChange(from, to)
        }
    },
    mounted() {
        this.onRouteChange(null, this.$route)
    },
    methods: {
        ...mapMutations([
            'setTitle',
            'setLoading',
            'setHeader',
            'setCategoryPage',
            'setCategoryLastPage'
        ]),
        onRouteChange(from, route) {
            if (! ['chatter.home', 'chatter.category'].includes(route.name)) {
                return
            }
            
            var self = this;
            let url = '/api/chatter/discussion'
            let params = {};
            
            this.setCategoryPage(route.query.page);
            this.setLoading(true)

            // Add the page parameter to the request
            if (route.params.category !== undefined) {
                params = { category: route.params.category };
            }
            Object.assign(params, { page: self.category.page });
            let queryString = Object.keys(params).map(key => key + '=' + params[key]).join('&');

            // Make request
            axios.get(url + '?' + queryString)
                .then(response => {
                    self.setTitle(response.data.category.name)
                    self.setCategoryPage(response.data.meta.current_page)
                    self.setCategoryLastPage(response.data.meta.last_page)
                    self.setHeader({
                        title: response.data.category.name,
                        subtitle: response.data.category.subtitle,
                        color: response.data.category.color
                    })
                    self.discussions = response.data.data
                })
                .catch(error => console.error(error))
                .then(() => {
                    setTimeout(() => {
                        self.setLoading(false)
                    }, 600)
                })
        }
    },
    computed: {
        ...mapGetters([
            'category',
            'loading'
        ])
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