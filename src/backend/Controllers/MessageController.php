<?php


namespace Messenger\Controllers;


use Messenger\Database\Repositories\ConversationRepository;
use Messenger\Database\Repositories\FileMessageRepository;
use Messenger\Database\Repositories\MessageRepository;
use Messenger\Database\Repositories\TextMessageRepository;
use Messenger\Models\Message;
use Messenger\Models\TextMessage;
use Messenger\ViewModels\SendMessage;

class MessageController
{
    /** @var ConversationRepository $object */
    protected $ConversationRepository;

    /** @var MessageRepository $object */
    protected $MessageRepository;

    /** @var TextMessageRepository $object */
    protected $TextMessageRepository;

    /** @var FileMessageRepository $object */
    protected $FileMessageRepository;

    public function __construct()
    {
        $this->ConversationRepository = new ConversationRepository();
        $this->MessageRepository = new MessageRepository();
        $this->TextMessageRepository = new TextMessageRepository();
        $this->FileMessageRepository = new FileMessageRepository();
    }


    public function GetAll(string $conversationId)
    {
        $currentUser = $_SESSION["User"];
        if (!$currentUser) {
            echo json_encode("User not Unauthorized");
            return;
        }

        $conversation = $this->ConversationRepository->GetById($conversationId);
        if($conversation->FirstUserId != $currentUser->Id && $conversation->SecondUserId != $currentUser->Id)
        {
            echo json_encode("No access");
            return;
        }

        $messages = $this->MessageRepository->GetAllMessagesByConversationId($conversationId);
        foreach ($messages as $message)
        {
            if($message->TypeId == 1)
                $message->Content = $this->TextMessageRepository->GetByMessageId($message->Id);
            else
                $message->Content = $this->FileMessageRepository->GetByMessageId($message->Id);
        }
        echo json_encode($messages);
    }

    public function GetUpdate(string $date)
    {
        $currentUser = $_SESSION["User"];
        if (!$currentUser) {
            echo json_encode("User not Unauthorized");
            return;
        }
        $date = date("Y-m-d H:i:s", strtotime($date));
        $data = $this->MessageRepository->GetMessagesFromDate($date,$currentUser->Id);
        echo json_encode($data);
    }

    public function AddMessage(SendMessage $model)
    {
        $currentUser = $_SESSION["User"];
        if (!$currentUser) {
            echo json_encode("User not Unauthorized");
            return;
        }
        $message = new Message();
        $message->TypeId = $model->messageType;
        $message->SenderId = $currentUser->Id;
        $message->IsRead =false;
        $message->ConversationId = $model->conversationId;
        $message->SendDateTime = date("Y-m-d H:i:s");
        $this->MessageRepository->Insert($message);

        $textMessage = new TextMessage();
        $textMessage->Text = $model->messageContent;
        $textMessage->MessageId = $message->Id;
        $this->TextMessageRepository->Insert($textMessage);

        $message->Content = $textMessage;
        echo json_encode($message);
    }
}