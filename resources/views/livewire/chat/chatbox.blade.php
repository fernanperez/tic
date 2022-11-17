<div>
    @if ($selectedConversation)
        <div class="chatbox_header">

            <div class="return">
                <i class="bi bi-arrow-left"></i>
            </div>

            <div class="img_container">
                <img src="https://ui-avatars.com/api/?name={{ $receiverInstance->firstname . ' ' . $receiverInstance->lastname }}"
                    alt="img">
            </div>

            <div class="name">
                {{ $receiverInstance->firstname }}
            </div>

            <div class="info">
                <div class="info_item">
                    <i class="bi bi-telephone-fill"></i>
                </div>

                <div class="info_item">
                    <i class="bi bi-image"></i>
                </div>

                <div class="info_item">
                    <i class="bi bi-info-circle-fill"></i>
                </div>
            </div>
        </div>
        <div class="chatbox_body">
            @foreach ($messages as $message)
                <div class="message_body {{ auth()->id() == $message->sender_id ? 'message_body_me' : 'message_body_receiver' }}"
                    style="width: 80%; max-width: 80%; max-width: max-content;">
                    {{ $message->body }}
                    <div class="message_body_footer">
                        <div class="date">
                            {{ $message->created_at->format('m: i: a') }}
                        </div>
                        <div class="read">
                            @php
                                if($message->user->id === auth()->id()){
                                    if($message->read == 0){
                                        echo'<i class="bi bi-check2 status_tick"></i>';
                                    }else{
                                        echo'<i class="bi bi-check2-all text-primary "></i>';
                                    }
                                }
                            @endphp
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <script>
            $('.chatbox_body').on('scroll', function() {
                var top = $('.chatbox_body').scrollTop();

                if (top == 0) {
                    window.livewire.emit('loadmore');
                }

            });
        </script>
        <script>
            window.addEventListener('updatedHeight', event => {
                let old = event.detail.height;
                let newHeight = $('.chatbox_body')[0].scrollHeight;
                let height = $('.chatbox_body').scrollTop(newHeight - old);

                window.livewire.emit('updateHeight', {
                    height: height
                });
            });
        </script>
    @else
        <div class="fs-4 text-center text-primary mt-5">
            Ninguna conversación seleccionada
        </div>
    @endif

    <script>
        window.addEventListener('rowChatToBottom', event => {
            $('.chatbox_body').scrollTop($('.chatbox_body')[0].scrollHeight);
        });
    </script>

    <script>
        $(document).on('click', '.return', function() {
            window.livewire.emit('resetComponent');
        });
    </script>

    <script>
        window.addEventListener('markMessageAsRead', event=>{
            var value = document.querySelectorAll('.status_tick');
            value.forEach(element, index => {
                element.classList.remove('bi bi-check2');
                element.classList.add('bi bi-check2', 'text-primary');
            });
        })
    </script>
</div>
