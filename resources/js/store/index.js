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
    },
    getters: {
        USER: state => {
            return state.user;
        },
    },
    mutations: {
        SET_USER: (state, user) => {
            state.user.name=user.name;
            state.user.id=user.id;
            state.user.email=user.email;
        },
    },
    actions: {
        GET_USER: async (context, user) => {
            let {data} = await Axios.get('api/users');
            context.commit('SET_USER', data.user);
            console.log(1);
        },
    },
});
