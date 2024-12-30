<?php

namespace App\Services;

use App\Base\Packages\ServiceWrapper;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;

class MessageService
{
    public function AllUserMessages()
    {
        return app(ServiceWrapper::class)(
            fn() => [
                "action" => Message::where('user_id', auth()->id())->orWhere('receiver_id', auth()->id())->get(),
                "status" => 200,
            ]
        );
    }

    public function SendMessage(array $inputs, string $username)
    {
        return app(ServiceWrapper::class)(function () use ($inputs, $username) {
            if (!isset($inputs['txt']) && !isset($inputs['img']))
                return ["action" => "you cant send an empty message!", "status" => 422];

            $receiver = User::where('username', $username)->firstOrFail();
            $inputs['user_id'] = auth()->id();
            $inputs['receiver_id'] = $receiver->id;
            $message = Message::create($inputs);
            return ["action" => $message, "status" => 200];
        });
    }

    public function EditMessage(array $inputs, object $message)
    {
        return app(ServiceWrapper::class)(function () use ($inputs, $message) {
            if (!isset($inputs['txt']) && !isset($inputs['img']))
                return ["action" => "you cant send an empty message!", "status" => 422];
            return ["action" => $message->update($inputs), "status" => 200];
        });
    }

    public function DeleteMessage(object $message)
    {
        return app(ServiceWrapper::class)(function () use ($message) {
            ImgDelete::perform($message);
            return ["action" => $message->delete(), "status" => 200];
        });
    }

    public function DeleteMessageImage(int $message_id)
    {
        return app(ServiceWrapper::class)(function () use ($message_id) {
            $message = Message::where('id', $message_id)->firstOrFail();
            return ["action" => ImgDelete::perform($message), "status" => 200];
        });
    }

    public function ReplayMessage(array $inputs, int $message_id)
    {
        return app(ServiceWrapper::class)(function () use ($inputs, $message_id) {
            $message = Message::where('id', $message_id)->firstOrFail();
            if (auth()->id() !== $message->user_id && auth()->id() !== $message->receiver_id)
                return ["action" => "access denied!", "status" => 403];
            $message_replay = Message::create($inputs);
            $message->user_id = auth()->id();
            $message->in_replay_to_msg_id = $message_id;
            $message->save();
            return ["action" => $message_replay, "status" => 200];
        });
    }

    public function SearchInMessages()
    {
        return app(ServiceWrapper::class)(function () {
            $search_phrase = strtolower(request()->input('q'));
            $results = Message::where('user_id', auth()->id())
                ->orWhere('receiver_id', auth()->id())
                ->where('txt', 'like', "%$search_phrase%")->get();
            return ["action" => $results, "status" => 200];
        });
    }

    public function ShowChats(string $username)
    {
        return app(ServiceWrapper::class)(function () use ($username) {
            // $receiver = User::where('username', $username)->firstOrFail();
            $receiver_id = (User::select('id')->where('username', $username)->firstOrFail())->id;
            // dd($receiver_id);
            // $messages = Message::where('user_id', auth()->id())
            //     ->where('receiver_id', $receiver->id)
            //     ->orWhere('user_id', $receiver->id)
            //     ->where('receiver_id', auth()->id())->get();

            $messages = Message::select('txt', 'img', 'updated_at', 'user_id')
                ->where('receiver_id', $receiver_id)
                ->orWhere('user_id', $receiver_id)
                ->where('receiver_id', auth()->id())->get();
            return ["action" => $messages, "status" => 200];
        });
    }
}
