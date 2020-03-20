import Vue from 'vue';
import Vuex from 'vuex';
import Axios from 'axios';
import user from './modules/user'

Vue.use(Vuex);
// import Axios from 'axios';
const debug = process.env.NODE_ENV !== 'production'

export const store = new Vuex.Store({
    modules: {
        user,
    },
    strict: debug,
});
