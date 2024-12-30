<?php

namespace App\Http\Controllers\Message;

use App\Base\Packages\ImgUpload;
use App\Http\Controllers\Controller;
use App\Http\Requests\Message\MessageDeleteRequest;
use App\Http\Requests\Message\MessageStoreRequest;
use App\Http\Requests\Message\MessageUpdateRequest;
use App\Models\Message;
use App\Services\MessageService;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function __construct(private MessageService $messageService)
    {
    }

    public function index()
    {
        return $this->messageService->AllUserMessages();
    }

    public function store(MessageStoreRequest $request, string $username)
    {
        return $this->messageService->SendMessage(
            ImgUpload::perform($request, 'message'),
            $username,
        );
    }

    public function update(MessageUpdateRequest $request, Message $message)
    {
        return $this->messageService->EditMessage(
            ImgUpload::perform($request ,'user', $message),
            $message,
        );
    }

    public function destroy(MessageDeleteRequest $request, Message $message)
    {
        return $this->messageService->DeleteMessage($message);
    }

    public function delMsgImg(int $message_id)
    {
        return $this->messageService->DeleteMessageImage($message_id);
    }

    public function replay(MessageStoreRequest $request, int $message_id)
    {
        return $this->messageService->ReplayMessage(
            ImgUpload::perform($request, 'message'),
            $message_id,
        );
    }

    public function search()
    {
        return $this->messageService->SearchInMessages();
    }

    public function chat(string $username)
    {
        return $this->messageService->ShowChats($username);
    }
}
