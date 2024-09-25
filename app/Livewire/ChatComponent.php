<?php

namespace App\Livewire;

use App\Events\MessageSendEvent;
use App\Models\Message;
use App\Models\User;
use Livewire\Attributes\On;
use Livewire\Component;

class ChatComponent extends Component
{
    public $user ;
    public $sender_id ;
    public $receiver_id;

    public $message;
    public $messages = [];

    public function mount($user_id)
    {
        $this->sender_id = auth()->user()->id;
        $this->receiver_id = $user_id;

        $messages = Message::where(function($query){
            $query->where('sender_id', $this->sender_id)
            ->where('receiver_id', $this->receiver_id);
        })->orWhere(function($query){
            $query->where('sender_id', $this->receiver_id)
            ->where('receiver_id', $this->sender_id);
        })->with('sender:id,name', 'receiver:id,name')->get();

        foreach($messages as $message){
            $this->appendMessage($message);
        }

        $this->user = User::whereId($user_id)->first();
    }

    public function render()
    {
        return view('livewire.chat-component');
    }


    public function sendMessage()
    {
       $validated = $this->validate([
        'message' => 'required|string',
       ]);

       $chatMessage = Message::create([
        'sender_id' => $this->sender_id,
        'receiver_id' => $this->receiver_id,
        'message' => $this->message,
       ]);

       $this->appendMessage($chatMessage);

       broadcast(new MessageSendEvent($chatMessage))->toOthers();

       $this->message = '';
    }


    #[On('echo-private:chat-channel.{sender_id},MessageSendEvent')]
    public function listenSendMessage($event)
    {
        $chatMessage = Message::whereId($event['message']['id'])
        ->with('sender:id,name', 'receiver:id,name')->first();
        $this->appendMessage($chatMessage);
    }


    public function appendMessage($message)
    {
        $this->messages[] = [
            'id' => $message->id,
            'sender' => $message->sender->name,
            'receiver' => $message->receiver->name,
            'message' => $message->message,
        ];
    }
}
