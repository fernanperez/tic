<?php

namespace App\Http\Livewire\Chat;

use App\Models\Conversation;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class ChatlistComponent extends Component
{
    public $auth_id;
    public $conversations;
    public $receiverInstance;
    public $name;
    public $selectedConversation;

    protected $listeners = ['chatUserSelected', 'refresh'=>'$refresh', 'resetComponent'];

    public function mount()
    {
        $this->auth_id = auth()->id();
        $this->conversations = Conversation::where('sender_id', $this->auth_id)
            ->orWhere('receiver_id', $this->auth_id)->orderBy('last_time_message', 'DESC')->get();
    }

    public function render()
    {
        return view('livewire.chat.chatlist-component');
    }

    public function getChatUserInstance(Conversation $conversation, ?String $request)
    {
        $this->auth_id = auth()->id();

        if ($conversation->sender_id == $this->auth_id) {
            $this->receiverInstance = User::firstWhere('id', $conversation->receiver_id);
        } else {
            $this->receiverInstance = User::firstWhere('id', $conversation->sender_id);
        }

        if ($request == null) {
            return $this->receiverInstance;
        } else {
            return $this->receiverInstance->request;
        }
    }

    public function chatUserSelected(Conversation $conversation, $receiverId)
    {
        // dd([$conversation, $receiverId]);
        $this->selectedConversation = $conversation;

        $receiverInstance = User::find($receiverId);

        $this->emitTo('chat.chatbox', 'loadConversation', $this->selectedConversation, $receiverInstance);
        $this->emitTo('chat.sendmessage-component', 'updateSendMessage', $this->selectedConversation, $receiverInstance);
    }

    public function resetComponent()
    {
        $this->selectedConversation = null;
        $this->receiverInstance= null;
    }
}
