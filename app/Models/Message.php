<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Message extends Model
{
    use HasFactory;

    protected $table = 'messages';
    protected $fillable = [
        'sender_id',
        'receiver_id',
        'text',
        'is_read',
    ];


    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }

    public static function getUnreadMessagesCount($sender_id)
    {
        return Message::where('receiver_id', Auth::id())
            ->where('sender_id', $sender_id)
            ->where('is_read', false)
            ->count();


    }

    /**
     * Summary of unreadToReadMessage
     * @param int $receiver_id
     * @return int
     */
    public static function unreadToReadMessage($receiver_id): int
    {

        return Message::where('receiver_id', Auth::id())
            ->where('sender_id', $receiver_id)
            ->update(['is_read' => true]);
    }
}
