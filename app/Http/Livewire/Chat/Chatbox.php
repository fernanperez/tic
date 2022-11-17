<?php

namespace App\Http\Livewire\Chat;

use App\Events\MessageSendEvent;
use App\Events\MessageReadEvent;
use App\Models\Conversation;
use App\Models\Message;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class Chatbox extends Component
{
    public $selectedConversation;
    public $receiver;
    public $messages;
    public $paginateVar = 10;
    public $height;

    // protected $listeners = ['loadConversation', 'pushMessage', 'loadmore', 'updateHeight'];

    public function getListeners()
    {
        $auth_id = auth()->id();
        return [
            "echo-private:chat.{$auth_id},MessageSendEvent" => 'broadcastedMessageReceived',
            "echo-private:chat.{$auth_id},MessageReadEvent" => 'broadcastedMessageRead',
            'loadConversation',
            'pushMessage',
            'loadmore',
            'updateHeight',
            'broadcastMessageRead',
            'resetComponent',
        ];
    }

    public function render()
    {
        return view('livewire.chat.chatbox');
    }

    public function loadConversation(Conversation $conversation, User $receiver)
    {
        $this->selectedConversation = $conversation;
        $this->receiverInstance = $receiver;

        $this->messages_count = Message::where('conversation_id', $this->selectedConversation->id)->count();

        $this->messages = Message::where('conversation_id', $this->selectedConversation->id)
            ->skip($this->messages_count - $this->paginateVar)
            ->take($this->paginateVar)
            ->get();

        $this->dispatchBrowserEvent('chatSelected');

        Message::where('conversation_id', $this->selectedConversation->id)
            ->where('receiver_id', auth()->user()->id)->update(['read' => 1]);

        $this->emitSelf('broadcastMessageRead');
    }

    public function pushMessage($messageId)
    {
        $newMessage = Message::find($messageId);
        $this->messages->push($newMessage);

        $this->dispatchBrowserEvent('rowChatToBottom');
    }

    public function loadmore()
    {
        // dd("entro");
        $this->paginateVar = $this->paginateVar + 10;
        $this->messages_count = Message::where('conversation_id', $this->selectedConversation->id)->count();
        $this->messages = Message::where('conversation_id', $this->selectedConversation->id)
            ->skip($this->messages_count - $this->paginateVar)
            ->take($this->paginateVar)
            ->get();
        $height = $this->height;
        $this->dispatchBrowserEvent('updatedHeight', ($height));
    }

    public function updateHeight($height)
    {
        $this->height = $height;
    }

    public function broadcastedMessageReceived($event)
    {

        $this->emitTo('chat.chatlist-component', 'refresh');

        $broadcastedMessage = Message::find($event['message']);

        if ($this->selectedConversation) {

            if ((int) $this->selectedConversation->id  === (int)$event['conversation_id']) {
                // dd($event);
                $broadcastedMessage->read = 1;
                $broadcastedMessage->save();

                $this->pushMessage($broadcastedMessage->id);

                $this->emitSelf('broadcastMessageRead');
            }
        }
    }

    public function broadcastMessageRead()
    {
        broadcast(new MessageReadEvent($this->selectedConversation->id, $this->receiverInstance->id));
    }

    public function broadcastedMessageRead($event)
    {
        // dd($event);
        if ($this->selectedConversation) {
            if ((int)$this->selectedConversation->id === (int)$event['conversation_id']) {
                $this->dispatchBrowserEvent('markMessageAsRead');
            }
        }
    }

    public function resetComponent()
    {
        $this->selectedConversation = null;
        $this->receiverInstance = null;
    }
}
