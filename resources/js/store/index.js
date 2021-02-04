export default {
    state: {},
    getters: {

    },
    actions: {
        userList(context){
            axios.get('/userlist')
            .then(response => {
                context.commit("userlist");
            })
        }
    },
    mutations: {
        userlist(state, payload){

        }
    }
};
