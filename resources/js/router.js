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
                path: '/users',
                component: Vue.component('users-index', () => import('./components/Users/index.vue')),
                name: 'users.index',
            },
            {
                path: '/profile',
                component: Vue.component('users-profile', () => import('./components/Users/profile.vue')),
                name: 'modules.profile',
                props: true
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
