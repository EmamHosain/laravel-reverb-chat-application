<?php

namespace App\Livewire;

use App\Events\MessageSentEvent;
use App\Events\UnReadMessageCountEvent;
use App\Events\UserTypingEvent;
use App\Models\MessageList;
use App\Models\User;
use App\Models\Message;
use Carbon\Carbon;
use Livewire\Attributes\On;
use Livewire\Component;

class Chat extends Component
{
    public $text;
    public $all_conversations = [];
    public $sender_id;
    public $receiver_id;
    public $user;

    public $all_user_lists;

    public $current_receiver_user;

    public function mount()
    {

        $receiver_id = request()->query('receiver_id');
        $this->user = User::find($receiver_id);

        $this->sender_id = auth()->user()->id;
        if ($this->user) {
            $this->receiver_id = $this->user->id;
            $this->current_receiver_user = $this->user;


            // user add to list
            $this->userAddToList();


            // get all messages
            $messages = $this->getMessage();

            // dd($this->all_conversations);
            foreach ($messages as $item) {
                $this->appendChatMessages($item);
            }
            // dd($this->all_conversations);


            // make unread message to read
            Message::unreadToReadMessage($this->receiver_id);
        }
        $this->getAllUserLists();

    }


    public function userAddToList()
    {
        $list = MessageList::where('user_id', $this->sender_id)
            ->where('receiver_id', $this->receiver_id)
            ->first();

        if ($list) {
            // Using `touch` instead of manually setting `updated_at`
            $list->touch();
        } else {
            MessageList::create(
                [
                    'user_id' => $this->sender_id,
                    'receiver_id' => $this->receiver_id,
                ]
            );
        }

    }


    public function getAllUserLists()
    {

        $this->all_user_lists = MessageList::with('receiver:id,name')
            ->where('user_id', $this->sender_id)
            ->orderByDesc('updated_at')
            ->get();
        // dd($this->all_user_lists->toArray());
    }

    public function getMessage()
    {
        $messages = Message::with(['sender:id,name', 'receiver:id,name'])

            ->where(function ($query) {

                // data will come from the sender
                $query->where('sender_id', $this->sender_id)
                    ->where('receiver_id', $this->receiver_id);
            })

            ->orWhere(function ($query) {

                // data will come from the receiver
                $query->where('sender_id', $this->receiver_id)
                    ->where('receiver_id', $this->sender_id);
            })
            ->get();

        // dd($messages->toArray());
        return $messages;
    }

    public function rules()
    {
        return [
            'text' => 'required'
        ];
    }

    public function sendMessage()
    {
        $this->validate();

        $message = Message::create([
            'sender_id' => $this->sender_id,
            'receiver_id' => $this->receiver_id,
            'text' => $this->text,
        ]);

        $msg = Message::with('sender:id,name', 'receiver:id,name')->where('id', $message->id)->first();
        $this->appendChatMessages($msg);
        $this->reset('text');
        broadcast(new MessageSentEvent($message))->toOthers();


        $unread_msg_count = $this->getUnreadMessagesCount();
        broadcast(new UnReadMessageCountEvent($this->sender_id, $this->receiver_id, $unread_msg_count))->toOthers();

        Message::unreadToReadMessage($this->receiver_id);
        $this->dispatch('message-updated');



    }

    #[On('echo-private:chat-channel.{sender_id},MessageSentEvent')]  // sender_id is current auth user id
    public function listenForMessage($event)
    {
        //    dd($event);
        $message = Message::with('sender:id,name', 'receiver:id,name')
            ->where('id', $event['message']['id'])->first();

        // dd( $message);
        $this->appendChatMessages($message);
    }


    public function appendChatMessages($msg)
    {
        $this->all_conversations[] = [
            'id' => $msg->id,
            'message' => $msg->text,
            'sender' => $msg->sender->name,
            'receiver' => $msg->receiver->name,
            'sender_id' => $msg->sender->id,
        ];

        // dd($this->all_conversations);
    }


    public function userTyping()
    {
        // dd($this->text);
        broadcast(new UserTypingEvent($this->sender_id, $this->receiver_id));
        // dd($this->text);
    }



    /**
     * Summary of getUnreadMessagesCount
     * @return int
     */
    public function getUnreadMessagesCount(): int
    {
        return Message::where('receiver_id', $this->receiver_id)
            ->where('sender_id', $this->sender_id)
            ->where('is_read', false)
            ->count();
    }


    public function render()
    {
        return view('livewire.chat')->layout('layouts.app');
    }

}
