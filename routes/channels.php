<?php

use App\Models\User;
use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

// chat channel
Broadcast::channel('chat-channel.{userId}', function (User $user, $userId) {
    return (int) $user->id === (int) $userId;
});


Broadcast::channel('chat-typing-channel.{receiver_id}', function (User $user, $receiver_id) {
    return (int) $user->id === (int) $receiver_id;
});


Broadcast::channel('chat-unread-msg-count-channel.{receiver_id}', function (User $user, $receiver_id) {
    return (int) $user->id === (int) $receiver_id;
});
