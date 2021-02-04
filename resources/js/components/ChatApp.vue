<template>
  <div class="container-chat clearfix">
        <div class="people-list" id="people-list">
      <div class="search">
        <input type="text" placeholder="search" />
        <i class="fa fa-search"></i>
      </div>
      <ul class="list" >
        <li class="clearfix" v-for="(user,index) in userList" :key="index">
        <img height="55px" width="55px" style="border-radius:30px" src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTpCKq1XnPYYDaUIlwlsvmLPZ-9-rdK28RToA&usqp=CAU" alt="avatar" />
          <div class="about">
            <div class="name">{{ user.name }}</div>
            <div class="status">
              <i class="fa fa-circle online"></i> online
            </div>
          </div>
        </li>
      </ul>
    </div>

    <div class="chat">
      <div class="chat-header clearfix">
        <img height="55px" width="55px" style="border-radius:30px" src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTpCKq1XnPYYDaUIlwlsvmLPZ-9-rdK28RToA&usqp=CAU" alt="avatar" />

        <div class="chat-about">
          <div class="chat-with">Chat with Vincent Porter</div>
          <div class="chat-num-messages">already 1 902 messages</div>
        </div>
        <i class="fa fa-star"></i>
      </div> <!-- end chat-header -->

      <div class="chat-history">
        <ul>
          <li class="clearfix">
            <div class="message-data align-right">
              <span class="message-data-time" >10:10 AM, Today</span> &nbsp; &nbsp;
              <span class="message-data-name" >Olia</span> <i class="fa fa-circle me"></i>

            </div>
            <div class="message other-message float-right">
              Hi Vincent, how are you? How is the project coming along?
            </div>
          </li>

          <li>
            <div class="message-data">
              <span class="message-data-name"><i class="fa fa-circle online"></i> Vincent</span>
              <span class="message-data-time">10:12 AM, Today</span>
            </div>
            <div class="message my-message">
              Are we meeting today? Project has been already finished and I have results to show you.
            </div>
          </li>

        </ul>

      </div> <!-- end chat-history -->

      <div class="chat-message clearfix">
        <textarea @keypress.enter.prevent="sendMessage" v-model="message" name="message-to-send" id="message-to-send" placeholder ="Type your message" rows="3"></textarea>

        <i class="fa fa-file-o"></i> &nbsp;&nbsp;&nbsp;
        <i class="fa fa-file-image-o"></i>

        <button>Send</button>

      </div> <!-- end chat-message -->

    </div> <!-- end chat -->
  </div> <!-- end container -->
</template>

<script>
    export default {
        data() {
            return {
                message: ''
            }
        },
        mounted(){
            this.$store.dispatch('userList')
        },
        computed: {
            userList(){
               return this.$store.getters.userList
            }
        },
        methods: {
            sendMessage(){
                if (this.message != '') {
                    axios.post('/sendmessage',{
                        message: this.message 
                    })
                }
                alert()
            }
        },
        created(){},
    }
</script>
