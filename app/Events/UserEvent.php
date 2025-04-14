<?php

namespace App\Events;

use App\Models\Message;
use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Auth;

class UserEvent implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $username;
    public $message;
    public $received;
    public $userId;

    /**
     * Create a new event instance.
     */
    public function __construct($to, $message)
    {
        $this->received = $to;
        $this->userId = Auth::user()->id;

        $newMessage = new Message();
        $newMessage->user_id =  $this->userId;
        $newMessage->message = $message;
        $newMessage->received = $this->received;
        $newMessage->save();

        $this->username = User::find($this->userId)->name;
        $this->message = $message;


    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('user.'.$this->received),
            new PrivateChannel('user.'.$this->userId),
        ];
    }
}
