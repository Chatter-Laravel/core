<template>
    <div>
        <div v-if="loading" class="flex flex-wrap">
            <div v-for="d in [0,1,2,3]" v-bind:key="d" class="w-full sm:p-6">
                <content-loader :height="70">
                    <rect x="0" y="0" rx="3" ry="3" width="50%" height="10" />
                    <rect x="0" y="20" rx="2" ry="2" width="100%" height="6" />
                    <rect x="0" y="32" rx="2" ry="2" width="100%" height="6" />
                    <circle cx="85%" cy="55" r="10" />
                </content-loader>
            </div>
        </div>

        <transition name="fade" class="flex flex-wrap p-4 pb-0">
            <div v-if="!loading && discussion && posts">

                <div class="w-full shadow rounded p-4 mb-6">
                    <h1 class="w-full font-bold text-2xl sm:text-3xl mb-4">{{ discussion.title }}</h1>

                    <div class="flex items-center">
                        <img class="w-12 h-12 rounded-full inline-block mr-2" :src="discussion.user.avatar" :alt="`avatar of ${discussion.user.username} on ${discussion.title}`">
                        <div class="inline-block"><span class="font-bold">{{ discussion.user.username }}</span> <span class="text-sm text-gray-600"> | {{ discussion.post.time_ago }}</span></div>
                    </div>
                    
                    <div class="post body w-full text-lg text-gray-800 leading-relaxed mt-4" v-html="discussion.post.body"></div>
                    <div class="pt-4 pb-2">
                        <reactions
                            :post="discussion.post"
                        ></reactions>
                    </div>
                </div>

                <div v-for="post in posts" :key="post.id" class="flex flex-wrap md:py-2">
                    <div class="w-full">
                        <div class="flex items-center">
                            <img class="w-12 h-12 rounded-full inline-block mr-2" :src="post.user.avatar" :alt="`vatar of ${post.user.username} on ${post.title}`">
                            <div class="inline-block"><span class="font-bold">{{ post.user.username }}</span> <span class="text-sm text-gray-600"> | {{ post.time_ago }}</span></div>
                        </div>
                        
                        <div class="post body w-full text-lg text-gray-800 leading-relaxed mt-4" v-html="post.body"></div>

                        <div class="pt-4">
                            <reactions
                                :post="post"
                            ></reactions>
                        </div>
                    </div>
                    <div class="w-full border-t mt-4 mb-2"></div>
                </div>
            </div>
        </transition>

        <pagination
            :getter="discussionGetter"
            :loading="loading"
            route="chatter.discussion"
        ></pagination>

        <reply v-if="!loading && discussion" :discussion="discussion"></reply>
    </div>
</template>

<script>
import { ContentLoader } from 'vue-content-loader'
import { mapMutations, mapGetters } from 'vuex';
import Pagination from '../components/Pagination'
import Reply from '../components/Reply'
import Reactions from '../components/Reactions'
import { events } from '../events'

export default {
    components: {
        ContentLoader,
        Pagination,
        Reactions,
        Reply
    },
    data() {
        return {
            posts: [],
            discussion: null,
            showDiscussions: false,
        }
    },
    watch: {
        '$route' (to, from) {
            this.setLoading(true);
            this.onRouteChange(from, to);
        }
    },
    mounted() {
        var self = this

        this.onRouteChange(null, this.$route)

        window.ChatterEvents.$on(events.ADD_POST_TO_DISCUSSION, post => {
            self.posts.push(post)
        });
    },
    computed: {
        ...mapGetters({
            'discussionGetter': 'discussion',
            'loading': 'loading',
        })
    },
    methods: {
        ...mapMutations([
            'setTitle',
            'setLoading',
            'setDiscussionPage',
            'setDiscussionLastPage'
        ]),
        onRouteChange(from, route) {
            if ('chatter.discussion' !== route.name) {
                return
            }

            var self = this
            var page = route.query.page
            let params = {}

            this.setDiscussionPage(page)
            this.setLoading(true)

            // Returns the discussion information            
            axios.get('/api/chatter/discussion/' + route.params.title)
                .then(response => {
                    self.discussion = response.data.data
                    self.setTitle(self.discussion.title)
                })
                .catch(error => console.error(error))
                .then(() => {
                    self.setLoading(false)
                    setTimeout(function() {
                        self.showDiscussions = true
                    }, 500)
                })

            // Returns all the post from the discussion
            axios.get('/api/chatter/post/?discussion=' + route.params.title + '&page=' + page)
                .then(response => {
                    self.setDiscussionPage(response.data.meta.current_page)
                    self.setDiscussionLastPage(response.data.meta.last_page)

                    if (1 === self.discussionGetter.page) {
                        response.data.data.shift();
                    }
                    self.posts = response.data.data;
                })
                .catch(error => console.error(error))
        }
    }
}
</script>

<style>
.fade-enter-active, .fade-leave-active {
    transition: opacity .5s;
}
.fade-enter, .fade-leave-to /* .fade-leave-active below version 2.1.8 */ {
    opacity: 0;
}

.post.body h1 {
    font-size: 2.25rem;
}
.post.body h2 {
    font-size: 2rem;
}
.post.body h3 {
    font-size: 1.75rem;
}

.post.body ul {
    list-style-type: disc!important;
    margin-top: 10px;
    margin-left: 30px;
}
.post.body ol {
    list-style-type: decimal!important;
    margin-top: 10px;
    margin-left: 30px;
}

.post.body blockquote {
    margin-top: 10px;
    margin-left: 30px;
    padding-left: 10px;
    padding-top: 10px;
    padding-bottom: 10px;
    border-left: solid #ccc 4px !important;
}
</style>