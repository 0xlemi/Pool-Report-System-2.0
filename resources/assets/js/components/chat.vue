<template>
<modal title="New Chat" id="addChat" modal-class="modal-lg">
    <div class="col-md-12">
		<urc-table></urc-table>
    </div>
</modal>

<modal title="Chat Settings" id="chatSettings">
    Settings
</modal>


<alert type="danger" :message="alertMessage" :active="alertActive"></alert>

<section class="chat-list">
    <div class="chat-list-search chat-list-settings-header">
        <div class="row">
            <div class="col-sm-2 col-lg-2 action">
                <a v-on:click.stop.prevent="$broadcast('openModal', 'chatSettings')">
                    <span class="font-icon font-icon-cogwheel"></span>
                </a>
            </div>
            <div class="col-sm-8 col-lg-8 text-center description">
                Messenger
            </div>
            <div class="col-sm-2 col-lg-2 text-right action">
                <a v-on:click.stop.prevent="$broadcast('openModal', 'addChat')">
                    <span class="glyphicon glyphicon-plus"></span>
                </a>
            </div>
        </div>
    </div><!--.chat-list-search-->
    <div class="chat-list-in scrollable-block">
        <div v-for="channel in channelList" @click="changeChannel(channel)" class="chat-list-item" :class="{'selected' : isCurrentChannel(channel)}">
            <span v-if="removeCurrentUserFromMembers(channel.members)"></span>
            <div class="chat-list-item-photo">
                <img :src="channel.members[0].profileUrl" alt="">
            </div>
            <div class="chat-list-item-header">
                <div class="chat-list-item-name">
                    <span class="name">{{ channel.members[0].nickname }}</span>
                </div>
                <div class="chat-list-item-date">last seen {{channel.members[0].lastSeenAt}}</div>
            </div>
            <div class="chat-list-item-cont">
                <div v-if="channel.isTyping()" class="chat-list-item-txt writing">
                    <div class="icon">
                        <i class="font-icon font-icon-pencil-thin"></i>
                    </div>
                    typing a message
                </div>
                <span v-else >
                    <div v-if="channel.lastMessage" class="chat-list-item-txt">{{ channel.lastMessage.message }}</div>
                </span>
                <div v-if="channel.unreadMessageCount > 0" class="chat-list-item-count">{{channel.unreadMessageCount}}</div>
            </div>
        </div>
    </div><!--.chat-list-in-->
</section><!--.chat-list-->

<section class="chat-list-info">
    <div class="chat-list-search chat-list-settings-header">
        <a href="#"><span class="fa fa-phone"></span></a>
        <a href="#"><span class="fa fa-video-camera"></span></a>
        <a href="#"><span class="fa fa-info-circle"></span></a>
    </div><!--.chat-list-search-->
    <div class="chat-list-in">
        <section class="chat-user-info chat-list-item online">
            <div class="chat-list-item-photo">
                <img src="img/photo-64-1.jpg" alt="">
            </div>
            <div class="chat-list-item-header">
                <div class="chat-list-item-name">
                    <span class="name">Matt McGill</span>
                </div>
            </div>
            <div class="chat-list-item-cont">
                <div class="chat-list-item-txt writing">
                    Matt McGill typing a message
                </div>
            </div>
        </section>
        <section class="chat-settings">
            <div class="checkbox-toggle">
                <input type="checkbox" id="check-toggle-2" checked="">
                <label for="check-toggle-2">Disable notifications</label>
            </div>
        </section>
        <section class="chat-profiles">
            <header>Profile on facebook</header>
            <a href="#">http://facebook.com/startui</a>
        </section>
    </div>
</section>

<section class="chat-area">
    <div class="chat-area-in">
        <div class="chat-area-header">
            <span v-if="currentChannel">
                <div class="chat-list-item" style="text-align: center" :class="{ 'online' : (currentChannel.members[0].connectionStatus == 'online')}">
                    <div class="chat-list-item-name">
                        <span @click="test" class="name">{{currentChannel.members[0].nickname}}</span>
                    </div>
                    <div class="chat-list-item-txt writing">Last seen {{currentChannel.members[0].lastSeenAt}}</div>
                </div>
            </span>

            <span v-else>
                <div class="clean">Start a conversation</div>
            </span>
        </div><!--.chat-area-header-->

        <div class="chat-dialog-area scrollable-block" id="chatBox">
            <div class="messenger-dialog-area">
                    <div v-for="message in messageList" class="messenger-message-container" style="width: 100%" :class="{'from bg-blue': isCurrentUser(message._sender)}">
                        <span v-if="isCurrentUser(message._sender)">
                            <div class="messages" style="width: 100%" >
                                <ul>
                                    <li>
                                        <div class="time-ago">1:26</div>
                                        <div class="message">
                                            <div>
                                                {{ message.message }}
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            <div class="avatar chat-list-item-photo">
                                <img :src="message._sender.profileUrl">
                            </div>
                        </span>
                        <span v-else>
                            <div class="avatar">
                                <img :src="message._sender.profileUrl">
                            </div>
                            <div class="messages">
                                <ul>
                                    <li>
                                        <div class="message">
                                            <div>
                                                {{ message.message }}
                                            </div>
                                        </div>
                                        <div class="time-ago">1:26</div>
                                    </li>
                                </ul>
                            </div>
                        </span>
                    </div>
            </div>
        </div>

        <div class="chat-area-bottom">
            <form class="write-message">
                <div class="form-group">
                    <textarea @keydown.enter="sendMessage(currentMessage)" rows="1" class="form-control" placeholder="Type a message" v-model="currentMessage"></textarea>
                    <div class="dropdown dropdown-typical dropup attach">
                        <button @click="sendMessage(currentMessage)" :disabled="chatDisabled" type="button" class="btn btn-rounded float-left">Send</button>
                        <a class="dropdown-toggle dropdown-toggle-txt"
                           id="dd-chat-attach"
                           data-target="#"
                           data-toggle="dropdown"
                           aria-haspopup="true"
                           aria-expanded="false">
                            <span class="font-icon fa fa-file-o"></span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dd-chat-attach">
                            <a class="dropdown-item" href="#"><i class="font-icon font-icon-cam-photo"></i>Photo</a>
                            <a class="dropdown-item" href="#"><i class="font-icon font-icon-cam-video"></i>Video</a>
                            <a class="dropdown-item" href="#"><i class="font-icon font-icon-sound"></i>Audio</a>
                            <a class="dropdown-item" href="#"><i class="font-icon font-icon-page"></i>Document</a>
                            <a class="dropdown-item" href="#"><i class="font-icon font-icon-earth"></i>Map</a>
                        </div>
                    </div>
                </div>
            </form>
        </div><!--.chat-area-bottom-->
    </div><!--.chat-area-in-->
</section><!--.chat-area-->

</template>

<script>
import modal from './modal.vue';
import alert from './alert.vue';
import bootstrapTable from './BootstrapTable.vue';
import urcTable from './urcTable.vue';

export default {
    props: ['sb', 'currentUser'],
    components:{
        modal,
        alert,
        bootstrapTable,
        urcTable,
    },
    data(){
        return {
            alertMessage: '',
            alertActive: false,
            channelList: {},
            messageList: {},

            currentChannel: null,
            currentMessage: '',
        }
    },
    events: {
        chatReady(user){
            let vue = this;
            this.getChannels();
            var ChannelHandler = new this.sb.ChannelHandler();
            ChannelHandler.onMessageReceived = function(channel, message){
                vue.$emit('newMessage', {
                    channel: channel,
                    message: message
                });
            };
            this.sb.addChannelHandler('message_receiver', ChannelHandler);
        },
        newChat(seqId){
            this.$broadcast('closeModal', 'addChat');
            this.openPrivateChat(seqId);
        },
        newMessage(info){
            if(this.currentChannel && (this.currentChannel.url == info.channel.url)){
                this.getMessages(this.currentChannel);
            }
        }
    },
    computed: {
        chatDisabled(){
            return (this.currentChannel == null);
        },
    },
    methods: {
        // Actions
        changeChannel(channel){
            this.currentChannel = channel;
            this.getMessages(channel);
        },
        sendMessage(text){
            if(this.currentChannel && (text != '')){
                let vue = this;
                this.currentChannel.sendUserMessage(text, null, 'regular', function(message, error){
                    if (error) {
                        console.error(error);
                        return;
                    }
                    vue.getMessages(vue.currentChannel);
                    vue.changeLastMassage(text);
                    vue.currentMessage = '';
                });
            }
        },
        // Lists
        getChannels(){
            let vue = this;
            let channelListQuery = this.sb.GroupChannel.createMyGroupChannelListQuery();
            channelListQuery.includeEmpty = true;
            channelListQuery.limit = 50; // pagination limit could be set up to 100

            if (channelListQuery.hasNext) {
                channelListQuery.next(function(channelList, error){
                    if (error) {
                        console.error(error);
                        return;
                    }
                    vue.channelList = channelList;
                });
            }
        },
        getMessages(channel){
            let vue = this;
            var messageListQuery = channel.createPreviousMessageListQuery();
            messageListQuery.load(20, true, function(messageList, error){
                if (error) {
                    console.error(error);
                    return;
                }
                vue.messageList = messageList.reverse();
                channel.markAsRead();
                setTimeout(function () {
                    vue.scrollToTheBottom();
                }, 100);
            });
        },
        // Creation
        openPrivateChat(seqId){
            this.$http.get(Laravel.url+'chat/id/'+seqId).then(response => {
                let chatId = response.data.chat_id;
                this.createPrivateChannel([chatId]);
            },response => {
                this.alertMessage = 'There was a problem creating the conversetion.';
                this.alertActive = true;
            });

        },
        createPrivateChannel(userIds){
            let vue = this;
            this.sb.GroupChannel.createChannelWithUserIds(userIds, true, 'Private Chat', '', '', '', function(createdChannel, error){
                if (error) {
                    console.error(error);
                    return;
                }
                // if successfull refresh the channel list
                vue.getChannels();
            });
        },
        // Random
        isCurrentUser(user){
            if(user && this.currentUser){
                return (this.currentUser.userId == user.userId)
            }
            return false;
        },
        isCurrentChannel(channel){
            if(channel && this.currentChannel){
                return (this.currentChannel.url == channel.url)
            }
            return false;
        },
        removeCurrentUserFromMembers(members){
            let userId = this.currentUser.userId;
            for(var i = 0; i < members.length; i++) {
                if(members[i].userId == userId) {
                    members.splice(i, 1);
                    break;
                }
            }
            return members;
        },
        changeLastMassage(message){
            let channelUrl = this.currentChannel.url;
            for(var i = 0; i < this.channelList.length; i++) {
                if(this.channelList[i].url == channelUrl) {
                    if(this.channelList[i].lastMessage){
                        this.channelList[i].lastMessage.message = message;
                    }else{
                        // In the case of newly created channels
                        this.channelList[i]['lastMessage'] = {
                            message: message
                        };
                    }
                    break;
                }
            }
        },
        scrollToTheBottom(){
            // gives a few bugs with the ui (ask in startui comments)
            let pane = $('#chatBox').jScrollPane();
            pane.data('jsp').scrollToBottom();
        },
        // Make sure to remove this after testing
        test(){
            //
        }
    },
    ready(){
        // let vue = this;
        //
        // //
        // setTimeout(function () {
        //     console.log(vue.currentUser);
        // }, 5000);
    }
}
</script>
