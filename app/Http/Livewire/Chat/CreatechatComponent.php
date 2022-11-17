<?php

namespace App\Http\Livewire\Chat;

use App\Models\Conversation;
use App\Models\Message;
use App\Models\User;
use Livewire\Component;

class CreatechatComponent extends Component
{
    public $user;

    public function render()
    {
        $this->user = User::whereNot('id', auth()->user()->id)->get();
        return view(
            'livewire.chat.createchat-component',
            [
                'users' => $this->user,
            ]
        );
    }

    public function checkConversation(int $receiver_id)
    {
        // dd($receiver_id);
        $checkedConversation = Conversation::where([['receiver_id', auth()->user()->id], ['sender_id', $receiver_id]])
        ->orWhere('receiver_id', $receiver_id)
        ->where('sender_id', auth()->user()->id)
        ->get();

        if (count($checkedConversation) == 0) {
            // dd('no conversation');
            $createConversation = Conversation::create([
                'receiver_id' => $receiver_id,
                'sender_id' => auth()->user()->id,
            ]);

            $createMessage = Message::create([
                'conversation_id' => $createConversation->id,
                'receiver_id' => $receiver_id,
                'sender_id' => auth()->user()->id,
            ]);

            $createConversation->last_time_message = $createMessage->created_at;
            $createConversation->save();

            dd($createMessage);
        }

        if (count($checkedConversation) > 0) {
            dd('conversation exist');
        }
    }
}
