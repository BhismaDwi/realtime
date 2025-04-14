<?php

namespace App\Livewire;

use App\Events\UserEvent;
use App\Models\Message;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ChatPrivateComponent extends Component
{

    public $message;
    public $conversations = [];
    public $userId;
    public $received = null;

    public function mount(){
        $message = Message::where('user_id', auth()->id())->orWhere('received',auth()->id())->get();
        foreach ($message as $msg) {
            $this->conversations[] = [
                'username' => $msg->user->name,
                'message' => $msg->message
            ];
        }
    }

    public function submit()
    {
        UserEvent::dispatch($this->received, $this->message);
        $this->message = "";
    }

    public function render()
    {
        $users = User::whereNotIn('id', [auth()->id()])->get();
        return view('livewire.chat-private-component', compact('users'));
    }

    public function getListeners(){
        return [
            "echo-private:user.".auth()->id().",UserEvent" => "listenForMessage"
        ];
    }

    public function listenForMessage($data){
        $this->conversations[] = [
            'username' => $data['username'],
            'message' => $data['message']
        ];
    }

}
