<?php

namespace App\Events;

use Auth;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ChatEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message;
    public $room_id;
    public $user;

    public function __construct($message, $room_id)
    {
        $this->message = $message;
        $this->room_id = $room_id;
        $this->user = Auth::user();
    }

    public function broadcastOn()
    {
        return new PrivateChannel('rooms.' . $this->room_id);
    }

}
