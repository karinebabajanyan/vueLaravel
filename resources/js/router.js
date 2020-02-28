import Vue from 'vue';
import VueRouter from 'vue-router';

Vue.use(VueRouter);

export const router = new VueRouter({
    mode: 'history',
    routes:
        [
            {
                path: '/',
                component: Vue.component('welcome', () => import('./components/Welcome.vue')),
                name: 'welcome',
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
