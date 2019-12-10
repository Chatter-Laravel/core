import Category from './views/Category'
import Discussion from './views/Discussion'

export const routes = [
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
];