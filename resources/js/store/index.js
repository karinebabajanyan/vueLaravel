import Vue from 'vue';
import Vuex from 'vuex';
import Axios from 'axios';

Vue.use(Vuex);
// import Axios from 'axios';
export const store = new Vuex.Store({
    state: {
        user:{
            name:'',
            id:'',
            email:'',
        },
        cover:''
    },
    getters: {
        USER: state => {
            return state.user;
        },
        COVER: state => {
            return state.cover;
        },
    },
    mutations: {
        SET_USER: (state, user,admin) => {
            state.user.name=user.name;
            state.user.id=user.id;
            state.user.email=user.email;
        },
        SET_COVER: (state, cover) => {
            if(cover){
                state.cover=cover.path
            }
        },
    },
    actions: {
        GET_USER: async (context, user) => {
            let {data} = await Axios.get('api/users/profile');
            context.commit('SET_USER', data.user);
            context.commit('SET_COVER', data.cover);
        },
    },
});
