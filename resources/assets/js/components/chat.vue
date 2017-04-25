<template>
<modal title="New Chat" id="addChat" modal-class="modal-lg">
    <div class="col-md-12">
		<urc-table></urc-table>
    </div>
</modal>

<modal title="Chat Settings" id="chatSettings">
    Settings
</modal>

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
        <div class="chat-list-item online">
            <div class="chat-list-item-photo">
                <img src="img/photo-64-1.jpg" alt="">
            </div>
            <div class="chat-list-item-header">
                <div class="chat-list-item-name">
                    <span class="name">Matt McGill</span>
                </div>
                <div class="chat-list-item-date">16:59</div>
            </div>
            <div class="chat-list-item-cont">
                <div class="chat-list-item-txt writing">
                    <div class="icon">
                        <i class="font-icon font-icon-pencil-thin"></i>
                    </div>
                    Matt McGill typing a message
                </div>
                <div class="chat-list-item-count">3</div>
            </div>
        </div>
        <div class="chat-list-item">
            <div class="chat-list-item-photo">
                <img src="img/photo-64-2.jpg" alt="">
            </div>
            <div class="chat-list-item-header">
                <div class="chat-list-item-name">
                    <span class="name">Matthew Heath</span>
                </div>
                <div class="chat-list-item-date">16:59</div>
            </div>
            <div class="chat-list-item-cont">
                <div class="chat-list-item-txt">Anything that's easy or has no difficulty; something that is a certainty</div>
                <div class="chat-list-item-count">100</div>
            </div>
        </div>
        <div class="chat-list-item selected">
            <div class="chat-list-item-photo">
                <img src="img/photo-64-3.jpg" alt="">
            </div>
            <div class="chat-list-item-header">
                <div class="chat-list-item-name">
                    <span class="name">Vasilisa</span>
                </div>
                <div class="chat-list-item-date">05 Aug</div>
            </div>
            <div class="chat-list-item-cont">
                <div class="chat-list-item-txt">no</div>
                <div class="chat-list-item-dot"></div>
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
                <div class="messenger-message-container">
                    <div class="avatar">
                        <img src="img/avatar-1-32.png">
                    </div>
                    <div class="messages">
                        <ul>
                            <li>
                                <div class="message">
                                    <div>
                                        Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.
                                    </div>
                                </div>
                                <div class="time-ago">1:26</div>
                            </li>
                            <li>
                                <div class="message">
                                    <div>
                                        Lorem Ipsum is simply dummy text...
                                    </div>
                                </div>
                                <div class="time-ago">1:26</div>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="messenger-message-container from bg-blue">
                    <div class="messages">
                        <ul>
                            <li>
                                <div class="time-ago">1:26</div>
                                <div class="message">
                                    <div>
                                        Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="time-ago">1:26</div>
                                <div class="message">
                                    <div>
                                        Lorem Ipsum is simply dummy text...
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div class="avatar chat-list-item-photo">
                        <img src="img/photo-64-1.jpg">
                    </div>
                </div>
                <div class="messenger-message-container">
                    <div class="avatar">
                        <img src="img/avatar-1-32.png">
                    </div>
                    <div class="messages">
                        <ul>
                            <li>
                                <div class="message">
                                    <div>
                                        Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.
                                    </div>
                                </div>
                                <div class="time-ago">1:26</div>
                            </li>
                            <li>
                                <div class="message">
                                    <div>
                                        Lorem Ipsum is simply dummy text...
                                    </div>
                                </div>
                                <div class="time-ago">1:26</div>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="messenger-message-container from bg-blue">
                    <div class="messages">
                        <ul>
                            <li>
                                <div class="time-ago">1:26</div>
                                <div class="message">
                                    <div>
                                        Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="time-ago">1:26</div>
                                <div class="message">
                                    <div>
                                        Lorem Ipsum is simply dummy text...
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div class="avatar chat-list-item-photo">
                        <img src="img/photo-64-1.jpg">
                    </div>
                </div>
                <div class="messenger-message-container">
                    <div class="avatar">
                        <img src="img/avatar-1-32.png">
                    </div>
                    <div class="messages">
                        <ul>
                            <li>
                                <div class="message">
                                    <div>
                                        Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.
                                    </div>
                                </div>
                                <div class="time-ago">1:26</div>
                            </li>
                            <li>
                                <div class="message">
                                    <div>
                                        Lorem Ipsum is simply dummy text...
                                    </div>
                                </div>
                                <div class="time-ago">1:26</div>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="messenger-message-container from bg-blue">
                    <div class="messages">
                        <ul>
                            <li>
                                <div class="time-ago">1:26</div>
                                <div class="message">
                                    <div>
                                        Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="time-ago">1:26</div>
                                <div class="message">
                                    <div>
                                        Lorem Ipsum is simply dummy text...
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div class="avatar chat-list-item-photo">
                        <img src="img/photo-64-1.jpg">
                    </div>
                </div>
            </div>
        </div>

        <div class="chat-area-bottom">
            <form class="write-message">
                <div class="form-group">
                    <textarea rows="1" class="form-control" placeholder="Type a message"></textarea>
                    <div class="dropdown dropdown-typical dropup attach">
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
import bootstrapTable from './BootstrapTable.vue';
import urcTable from './urcTable.vue';

export default {
    props: ['sb', 'currentUser'],
    components:{
        modal,
        bootstrapTable,
        urcTable,
    },
    data(){
        return {

        }
    },
    events: {
        newChat(userSedId){
            this.$broadcast('closeModal', 'addChat');
            this.openPrivateChat(seqId);
        }
    },
    methods: {
        openPrivateChannel(seqId){
            
            this.sb.GroupChannel.createChannelWithUserIds(userIds, true, 'Private Chat', '', '', '', function(createdChannel, error){
                if (error) {
                    console.error(error);
                    return;
                }

            });
        }
    },
    ready(){
        let vue = this;
        // setTimeout(function(){ vue.createPrivateChannel(['pepe_123']) }, 3000);

        // sb.GroupChannel.createChannelWithUserIds(userIds , true, 'hello', '', 'json: {}', '', function(createdChannel, error){
        //     if (error) {
        //         console.error(error);
        //         return;
        //     }
        //
        //     console.log(createdChannel);
        // });


    }
}
</script>
