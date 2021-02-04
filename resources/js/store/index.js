export default {
    state: {
        userList: []
    },
    getters: {
        userList(state){
            return state.userList;
        }
    },
    actions: {
        userList(context){
            axios.get('/userlist')
            .then(response => {
                context.commit("userlist", response.data.users);
            })
        }
    },
    mutations: {
        userlist(state, payload){
            return (state.userList = payload);
        }
    }
};
