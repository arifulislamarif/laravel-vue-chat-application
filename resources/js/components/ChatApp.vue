<template>
  <div class="container-chat clearfix">
        <div class="people-list" id="people-list">
      <div class="search">
        <input type="text" placeholder="search" />
        <i class="fa fa-search"></i>
      </div>
      <ul class="list" >
        <li @click.prevent="selectUser(user.id)" class="clearfix" v-for="(user,index) in userList" :key="index">
        <img height="55px" width="55px" style="border-radius:30px" src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTpCKq1XnPYYDaUIlwlsvmLPZ-9-rdK28RToA&usqp=CAU" alt="avatar" />
          <div class="about">
            <div class="name">{{ user.name }}</div>
            <div v-if="onlineUser(user.id)" class="status" style="color:white">
                <i class="fa fa-circle online"></i> online
            </div>
            <div v-else class="status" style="color:white">
                <i class="fa fa-circle offline"></i> offline
            </div>
          </div>
        </li>
      </ul>
    </div>

    <div class="chat">
      <div class="chat-header clearfix">
        <img height="55px" width="55px" style="border-radius:30px" src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTpCKq1XnPYYDaUIlwlsvmLPZ-9-rdK28RToA&usqp=CAU" alt="avatar" />

        <div class="chat-about">
          <div class="chat-with" v-if="userMessage.user" style="display: inline-block">{{ userMessage.user.name }}</div>
            <div class="dropdown" style="display: inline-block">
                <a class="btn btn-primary btn-sm" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    ...
                </a>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <a class="dropdown-item" @click.prevent="deleteAllMessage">Delete All Messages</a>
                </div>
            </div>
          <div class="chat-num-messages">already 1 902 messages</div>
        </div>
        <i class="fa fa-star"></i>
      </div> <!-- end chat-header -->

      <div class="chat-history" v-chat-scroll>
        <ul>
          <li class="clearfix" v-for="(message, index) in userMessage.messages" :key="index">
            <div :class="`message-data ${userMessage.user.id == message.user.id ? 'align-right':''}`">
                <span class="message-data-time">{{ message.created_at | timeformat }}</span> &nbsp; &nbsp;
                <span class="message-data-name" >{{ message.user.name }}</span> <i class="fa fa-circle me"></i>
                <div class="dropdown" style="display: inline-block">
                    <a class="" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        ...
                    </a>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <a class="dropdown-item" @click.prevent="deleteSingleMessage(message.id)" style="cursor:pointer">Delete</a>
                    </div>
                </div>
            </div>
            <div :class="`message ${userMessage.user.id == message.user.id ? 'other-message float-right':'my-message'}`">
                {{ message.message }}
            </div>
          </li>
        </ul>

      </div> <!-- end chat-history -->

      <div class="chat-message clearfix">
        <p v-if="typing">{{ typing }} typing...</p>
        <textarea v-if="userMessage.user" @keydown="typingEvent(userMessage.user.id)" @keypress.enter.prevent="sendMessage" v-model="message" name="message-to-send" id="message-to-send" placeholder ="Type your message" rows="3"></textarea>
        <textarea v-else disabled  id="message-to-send" placeholder ="Type your message" rows="3"></textarea>

        <i class="fa fa-file-o"></i> &nbsp;&nbsp;&nbsp;
        <i class="fa fa-file-image-o"></i>

        <button @click.prevent="sendMessage">Send</button>

      </div> <!-- end chat-message -->

    </div> <!-- end chat -->
  </div> <!-- end container -->
</template>

<script>
    import _ from 'lodash'
    export default {
        data() {
            return {
                message: '',
                typing: '',
                users: ''
            }
        },
        mounted(){
            this.$store.dispatch('userList')

            Echo.private(`chat.${authuser.id}`)
            .listen('MessageSend', (e) => {
                this.selectUser(e.message.from)
            });

            Echo.private(`typingevent`)
            .listenForWhisper('typing', (e) => {
                if (e.user.id == this.userMessage.user.id && e.userId == authuser.id) {
                    this.typing = e.user.name
                }
                setTimeout(() => {
                    this.typing = ''
                }, 2000);
            });
        },
        computed: {
            userList(){
                return this.$store.getters.userList
            },
            userMessage(){
                return this.$store.getters.userMessage
            }
        },
        methods: {
            sendMessage(){
                if (this.message != '') {
                    axios.post('/sendmessage',{
                        message: this.message,
                        userid: this.userMessage.user.id,
                    })
                    .then(response => {
                        this.message = ''
                        this.selectUser(this.userMessage.user.id)
                    })
                }
            },
            selectUser(userId){
                this.$store.dispatch('userMessage', userId)
            },
            deleteSingleMessage(id){
                axios.delete(`/delete/single/message/${id}`)
                .then(response => {
                    this.selectUser(this.userMessage.user.id)

                })
            },
            deleteAllMessage(){
                axios.delete(`/delete/all/message/${this.userMessage.user.id}`)
                .then(response => {
                    this.selectUser(this.userMessage.user.id)
                })
            },
            typingEvent(userId){
                Echo.private(`typingevent`)
                .whisper('typing', {
                    'user': authuser,
                    'typing': this.message,
                    'userId': userId
                });
            },
            onlineUser(userId){
                return _.find(this.users, {'id': userId});
            }
        },
        created(){
            Echo.join(`liveUser`)
                .here((users) => {
                    this.users = users
                })
                .joining((user) => {
                    this.users = user
                    console.log(user.name);
                })
                .leaving((user) => {
                    console.log(user.name);
                });
        },
    }
</script>
