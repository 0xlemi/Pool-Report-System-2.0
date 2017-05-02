<template>
<div class="dropdown dropdown-notification messages">
    <a href="#"
       class="header-alarm dropdown-toggle active"
       id="dd-messages"
       data-toggle="dropdown"
       aria-haspopup="true"
       aria-expanded="false">
        <i class="font-icon-mail"></i>
    </a>
    <div class="dropdown-menu dropdown-menu-right dropdown-menu-messages" aria-labelledby="dd-messages">
        <div class="dropdown-menu-messages-header">
            <ul class="nav" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active"
                       data-toggle="tab"
                       href="#tab-incoming"
                       role="tab">
                        Inbox
                        <span class="label label-pill label-danger">8</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link"
                       data-toggle="tab"
                       href="#tab-outgoing"
                       role="tab">Outbox</a>
                </li>
            </ul>
            <button type="button" class="create">
                <i class="font-icon font-icon-pen-square"></i>
            </button>
        </div>
        <div class="tab-content">
            <div class="tab-pane active" id="tab-incoming" role="tabpanel">
                <div class="dropdown-menu-messages-list">
                    <a href="#" class="mess-item">
                        <span class="avatar-preview avatar-preview-32"><img src="{{ url('img/photo-64-2.jpg') }}" alt=""></span>
                        <span class="mess-item-name">Tim Collins</span>
                        <span class="mess-item-txt">Morgan was bothering about something!</span>
                    </a>
                    <a href="#" class="mess-item">
                        <span class="avatar-preview avatar-preview-32"><img src="{{ url('img/avatar-2-64.png') }}" alt=""></span>
                        <span class="mess-item-name">Christian Burton</span>
                        <span class="mess-item-txt">Morgan was bothering about something! Morgan was bothering about something.</span>
                    </a>
                    <a href="#" class="mess-item">
                        <span class="avatar-preview avatar-preview-32"><img src="{{ url('img/photo-64-2.jpg') }}" alt=""></span>
                        <span class="mess-item-name">Tim Collins</span>
                        <span class="mess-item-txt">Morgan was bothering about something!</span>
                    </a>
                    <a href="#" class="mess-item">
                        <span class="avatar-preview avatar-preview-32"><img src="{{ url('img/avatar-2-64.png') }}" alt=""></span>
                        <span class="mess-item-name">Christian Burton</span>
                        <span class="mess-item-txt">Morgan was bothering about something...</span>
                    </a>
                </div>
            </div>
            <div class="tab-pane" id="tab-outgoing" role="tabpanel">
                <div class="dropdown-menu-messages-list">
                    <a href="#" class="mess-item">
                        <span class="avatar-preview avatar-preview-32"><img src="{{ url('img/avatar-2-64.png') }}" alt=""></span>
                        <span class="mess-item-name">Christian Burton</span>
                        <span class="mess-item-txt">Morgan was bothering about something! Morgan was bothering about something...</span>
                    </a>
                    <a href="#" class="mess-item">
                        <span class="avatar-preview avatar-preview-32"><img src="{{ url('img/photo-64-2.jpg') }}" alt=""></span>
                        <span class="mess-item-name">Tim Collins</span>
                        <span class="mess-item-txt">Morgan was bothering about something! Morgan was bothering about something.</span>
                    </a>
                    <a href="#" class="mess-item">
                        <span class="avatar-preview avatar-preview-32"><img src="{{ url('img/avatar-2-64.png') }}" alt=""></span>
                        <span class="mess-item-name">Christian Burtons</span>
                        <span class="mess-item-txt">Morgan was bothering about something!</span>
                    </a>
                    <a href="#" class="mess-item">
                        <span class="avatar-preview avatar-preview-32"><img src="{{ url('img/photo-64-2.jpg') }}" alt=""></span>
                        <span class="mess-item-name">Tim Collins</span>
                        <span class="mess-item-txt">Morgan was bothering about something!</span>
                    </a>
                </div>
            </div>
        </div>
        <div class="dropdown-menu-notif-more">
            <a href="#">See more</a>
        </div>
    </div>
</div>
</template>

<script>

export default {

}
</script>
