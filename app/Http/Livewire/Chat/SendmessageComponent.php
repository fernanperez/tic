<?php

namespace App\Http\Livewire\Chat;

use App\Events\MessageSendEvent;
use App\Models\Conversation;
use App\Models\Message;
use App\Models\User;
use Livewire\Component;

class SendmessageComponent extends Component
{
    public $selectedConversation;
    public $receiverInstance;
    public $body;
    public $createMessage;

    protected $listeners=['updateSendMessage', 'dispatchMessageSend', 'resetComponent'];

    public function render()
    {
        return view('livewire.chat.sendmessage-component');
    }

    public function updateSendMessage(Conversation $conversation, User $receiver)
    {
        $this->selectedConversation = $conversation;
        $this->receiverInstance = $receiver;
    }

    public function sendMessage()
    {
        if (is_null($this->body)) {
            return null;
        }

        $this->createMessage = Message::create([
            'conversation_id'=>$this->selectedConversation->id,
            'sender_id'=>auth()->id(),
            'receiver_id'=>$this->receiverInstance->id,
            'body'=>$this->body
        ]);

        $this->selectedConversation->last_time_message = $this->createMessage->created_at;
        $this->selectedConversation->save();

        $this->emitTo('chat.chatbox', 'pushMessage', $this->createMessage->id);
        $this->emitTo('chat.chatlist-component', 'refresh', $this->createMessage->id);
        $this->reset('body');

        $this->emitSelf('dispatchMessageSend');
    }

    public function dispatchMessageSend()
    {
        broadcast(new MessageSendEvent(Auth()->user(), $this->createMessage, $this->selectedConversation, $this->receiverInstance));
    }

    public function resetComponent()
    {
        $this->selectedConversation = null;
        $this->receiverInstance= null;
    }
}
