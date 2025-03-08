<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UnReadMessageCountEvent implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */
    public $sender_id;
    public $receiver_id;
    public $unread_msg_count;
    public function __construct($sender_id, $receiver_id, $unread_msg_count)
    {
        $this->sender_id = $sender_id;
        $this->receiver_id = $receiver_id;
        $this->unread_msg_count = $unread_msg_count;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel("chat-unread-msg-count-channel.{$this->receiver_id}"),
        ];
    }


    /**
     * Function : broadcastWith
     * @return array
     */
    public function broadcastWith(): array
    {
        return [
            'sender_id' => $this->sender_id,
            'unread_msg_count' => $this->unread_msg_count,
        ];
    }
}
