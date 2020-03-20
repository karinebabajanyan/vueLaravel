const state = {
    user:{
        name:'',
        id:'',
        email:'',
    },
    cover:'',
    userError:'',
}

// getters
const getters = {
    USER: state => {
        return state.user;
    },
    COVER: state => {
        return state.cover;
    },
    USERERROR: state => {
        return state.userError
    }
}

// actions
const actions = {
    GET_USER: (context, user) => {
        axios.get('api/users/profile')
        .then(response=>{
            context.commit('SET_USER', response.data.user);
            context.commit('SET_COVER', response.data.cover);
        })
        .catch(function (error) {
            context.commit('SET_USERERROR', error.message)
            console.log(error); 
            // this.errors = error.response.data
        });
        // console.log(data);
    },
}

// mutations
const mutations = {
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
    SET_USERERROR: (state, error) => {
        state.userError=error
    }
}

export default {
    // namespaced: true,
    state,
    getters,
    actions,
    mutations
}