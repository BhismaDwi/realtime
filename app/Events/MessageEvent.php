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

class MessageEvent implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message;
    public $username;

    /**
     * Create a new event instance.
     */
    public function __construct($user_id, $message)
    {
        // Message::create([
        //     'user_id' => $user_id,
        //     'message' => $message
        // ]);
        $newMessage = new Message();
        $newMessage->user_id = $user_id;
        $newMessage->message = $message;
        $newMessage->save();

        $this->username = User::find($user_id)->name;
        $this->message = $message;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn()
    {
        return 
            new Channel('our-channel');
    }
}
