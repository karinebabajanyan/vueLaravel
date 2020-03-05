import Vue from 'vue';
import VueRouter from 'vue-router';

Vue.use(VueRouter);

export const router = new VueRouter({
    mode: 'hash',
    routes:
        [
            {
                path: '/',
                redirect:'/profile',
                component: Vue.component('app', () => import('./components/App.vue')),
                name: 'app',
            },
            {
                path: '/profile',
                component: Vue.component('users', () => import('./components/Users/index.vue')),
                name: 'users',
            },
            {
                path: '/posts',
                component: Vue.component('posts-index', () => import('./components/Posts/index.vue')),
                name: 'posts.index',
            },
            {
                path: '/posts/create',
                component: Vue.component('posts-create', () => import('./components/Posts/create.vue')),
                name: 'posts.create',
            },
            {
                path: '/posts/show',
                component: Vue.component('posts-show', () => import('./components/Posts/show.vue')),
                name: 'posts.show',
                props: true
            },
            {
                path: '/posts/edit',
                component: Vue.component('posts-edit', () => import('./components/Posts/edit.vue')),
                name: 'posts.edit',
                props: true
            },

        ],
    base: '/',
});
