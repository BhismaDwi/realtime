<?php

namespace App\Livewire;

use App\Events\MessageEvent;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;

class ChatComponent extends Component
{

    public $message;
    public $conversations = [];

    public function mount()
    {
        $message = Message::all();
        foreach ($message as $msg) {
            $this->conversations[] = [
                'username' => $msg->user->name,
                'message' => $msg->message
            ];
        }
    }

    public function submit()
    {
        MessageEvent::dispatch(Auth::user()->id, $this->message);
        $this->message = "";
    }

    public function render()
    {
        return view('livewire.chat-component');
    }

    #[On('echo:our-channel,MessageEvent')]
    public function listenForMessage($data)
    {
        $this->conversations[] = [
            'username' => $data['username'],
            'message' => $data['message']
        ];
    }
}
