<div>
    <div class="chatlist_header">
        <div class="title">
            Chat
        </div>
        <div class="img_container">
            <img src="https://ui-avatars.com/api/?background=0D8ABC&color=fff&name={{auth()->user()->firstname .' '. auth()->user()->lastname}}" alt="img">
        </div>
    </div>
    <div class="chatlist_body">
        @forelse ($conversations as $conversation)
            <div class="chatlist_item" wire:key='{{$conversation->id}}'
                wire:click="$emit('chatUserSelected', {{ $conversation }}, {{ $this->getChatUserInstance($conversation, $name = '')->id }})">
                <div class="chatlist_img_container">
                    <img src="https://ui-avatars.com/api/?name={{ $this->getChatUserInstance($conversation, $name = '')->firstname .' '. $this->getChatUserInstance($conversation, $name = '')->lastname}}"
                        alt="img-{{ $this->getChatUserInstance($conversation, $name = '')->firstname .' '. $this->getChatUserInstance($conversation, $name = '')->lastname}}">
                </div>
                <div class="chatlist_info">
                    <div class="top_row">
                        <div class="list_username">{{ $this->getChatUserInstance($conversation, $name = '')->firstname }}
                        </div>
                        <span
                            class="date">{{ $conversation->messages->last()?->created_at->shortAbsoluteDiffForHumans() }}</span>
                    </div>
                    <div class="bottom_row">
                        <div class="message_body text-truncate">
                            {{ $conversation->messages->last()->body }}
                        </div>
                        <div class="unread_count">
                            56
                        </div>
                    </div>
                </div>
            </div>
        @empty
            No hay conversaciones
        @endforelse
    </div>
</div>
