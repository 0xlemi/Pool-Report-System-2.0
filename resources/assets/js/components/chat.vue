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
        <div v-for="channel in channelList" @click="changeChannel(channel)" class="chat-list-item online">
            <div class="chat-list-item-photo">
                <img :src="channel.members[1].profileUrl" alt="">
            </div>
            <div class="chat-list-item-header">
                <div class="chat-list-item-name">
                    <span class="name">{{ channel.members[1].nickname }}</span>
                </div>
                <div class="chat-list-item-date">16:59</div>
            </div>
            <div class="chat-list-item-cont">
                <div class="chat-list-item-txt writing">
                    <div class="icon">
                        <i class="font-icon font-icon-pencil-thin"></i>
                    </div>
                    typing a message
                </div>
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
            <div class="chat-list-item online">
                <div class="chat-list-item-name">
                    <span class="name">Thomas Bryan</span>
                </div>
                <div class="chat-list-item-txt writing">Last seen 05 aug 2015 at 18:04</div>
            </div>
        </div><!--.chat-area-header-->

        <div class="chat-dialog-area scrollable-block">
            <div class="messenger-dialog-area">
                <div v-for="message in messageList" class="messenger-message-container" :class="{'from bg-blue': isCurrent(message._sender)}">
                    <span v-if="isCurrent(message._sender)">
                        <div class="messages">
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
                    <textarea rows="1" class="form-control" placeholder="Type a message" v-model="currentMessage"></textarea>
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
        newChat(seqId){
            this.$broadcast('closeModal', 'addChat');
            this.openPrivateChat(seqId);
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
            let vue = this;
            this.currentChannel.sendUserMessage(text, null, 'regular', function(message, error){
                if (error) {
                    console.error(error);
                    return;
                }
                vue.getMessages(vue.currentChannel);
                vue.currentMessage = '';
            });
        },
        // Lists
        getChannels(){
            let vue = this;
            let channelListQuery = this.sb.GroupChannel.createMyGroupChannelListQuery();
            channelListQuery.includeEmpty = true;
            channelListQuery.limit = 100; // pagination limit could be set up to 100

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
        isCurrent(user){
            if(user){
                return (this.currentUser.userId == user.userId)
            }
            return false;
        }
    },
    ready(){
        let vue = this;
        setTimeout(function () {
            vue.getChannels();
        }, 3000);
    }
}
</script>
