export default {
    state: {
        userList: [],
        userMessage: []
    },
    getters: {
        userList(state) {
            return state.userList;
        },
        userMessage(state) {
            return state.userMessage;
        }
    },
    actions: {
        userList(context) {
            axios.get("/userlist").then(response => {
                context.commit("userlist", response.data.users);
            });
        },
        userMessage(context, payload) {
            axios.get(`/usermessage/${payload}`).then(response => {
                console.log(response.data.messages);
                context.commit("usermessage", response.data.messages);
            });
        }
    },
    mutations: {
        userlist(state, payload) {
            return (state.userList = payload);
        },
        usermessage(state, payload) {
            return (state.userMessage = payload);
        }
    }
};
