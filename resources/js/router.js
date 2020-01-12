import VueRouter from 'vue-router'

import Category from './views/Category'
import Discussion from './views/Discussion'

export default new VueRouter({
    mode: 'history',
    routes: [
        {
            path: '/forums',
            name: 'chatter.home',
            component: Category,
        },
        {
            path: '/forums/category/:category',
            name: 'chatter.category',
            component: Category
        },
        {
            path: '/forums/discussion/:category/:title',
            name: 'chatter.discussion',
            component: Discussion
        }
    ]
});
