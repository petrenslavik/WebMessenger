<?php


namespace Messenger\Controllers;


use Messenger\Database\Repositories\ConversationRepository;
use Messenger\Database\Repositories\FileMessageRepository;
use Messenger\Database\Repositories\MessageRepository;
use Messenger\Database\Repositories\TextMessageRepository;
use Messenger\Database\Repositories\UserRepository;
use Messenger\Models\Conversation;
use Messenger\Models\Message;
use Messenger\Models\TextMessage;
use Messenger\ViewModels\ConversationStart;

class ConversationController
{
    /** @var ConversationRepository $object */
    protected $ConversationRepository;

    /** @var MessageRepository $object */
    protected $MessageRepository;

    /** @var TextMessageRepository $object */
    protected $TextMessageRepository;

    /** @var FileMessageRepository $object */
    protected $FileMessageRepository;

    /** @var UserRepository $object */
    protected $UserRepository;

    public function __construct()
    {
        $this->ConversationRepository = new ConversationRepository();
        $this->MessageRepository = new MessageRepository();
        $this->TextMessageRepository = new TextMessageRepository();
        $this->FileMessageRepository = new FileMessageRepository();
        $this->UserRepository = new UserRepository();
    }

    public function GetAll()
    {
        $currentUser = $_SESSION["User"];
        if (!$currentUser) {
            echo json_encode("User not Unauthorized");
            return;
        }

        $conversations = $this->ConversationRepository->GetByUserId($currentUser->Id);
        foreach ($conversations as $conversation) {
            $conversation->LastMessage = $this->MessageRepository->GetLastMessageByConversationId($conversation->Id);
            $conversation->Sender = $this->UserRepository->GetById($conversation->LastMessage->SenderId);
            if($conversation->FirstUserId != $currentUser->Id)
                $conversation->Speaker = $this->UserRepository->GetById($conversation->FirstUserId);
            else
                $conversation->Speaker = $this->UserRepository->GetById($conversation->SecondUserId);
            unset($conversation->Sender->Verified);
            unset($conversation->Sender->PasswordHash);
            if ($conversation->LastMessage->TypeId == 1) {
                $conversation->LastMessage->Content = $this->TextMessageRepository->GetByMessageId($conversation->LastMessage->Id);
            } else {
                $conversation->LastMessage->Content = $this->FileMessageRepository->GetByMessageId($conversation->LastMessage->Id);
            }
        }

        echo json_encode($conversations);

    }

    public function GetConversation(string $conversationId)
    {
        $currentUser = $_SESSION["User"];
        if (!$currentUser) {
            echo json_encode("User not Unauthorized");
            return;
        }
        $conversation = $this->ConversationRepository->GetById($conversationId);
        $conversation->LastMessage = $this->MessageRepository->GetLastMessageByConversationId($conversation->Id);
        $conversation->Sender = $this->UserRepository->GetById($conversation->LastMessage->SenderId);
        if($conversation->FirstUserId != $currentUser->Id)
            $conversation->Speaker = $this->UserRepository->GetById($conversation->FirstUserId);
        else
            $conversation->Speaker = $this->UserRepository->GetById($conversation->SecondUserId);
        unset($conversation->Sender->Verified);
        unset($conversation->Sender->PasswordHash);
        if ($conversation->LastMessage->TypeId == 1) {
            $conversation->LastMessage->Content = $this->TextMessageRepository->GetByMessageId($conversation->LastMessage->Id);
        } else {
            $conversation->LastMessage->Content = $this->FileMessageRepository->GetByMessageId($conversation->LastMessage->Id);
        }

        echo json_encode($conversation);
    }

    public function CreateConversation(ConversationStart $model){
        $currentUser = $_SESSION["User"];

        if (!$currentUser) {
            echo json_encode("User not Unauthorized");
            return;
        }
        $conversationEntity= new Conversation();
        $conversationEntity->FirstUserId = $currentUser->Id;
        $conversationEntity->SecondUserId = $model->userId;
        if($this->ConversationRepository->GetByEntity($conversationEntity))
        {
            echo json_encode("Conversation already created");
            return;
        }
        $this->ConversationRepository->Insert($conversationEntity);
        $messageEntity=new Message();
        $messageEntity->ConversationId = $conversationEntity->Id;
        $messageEntity->IsRead = false;
        $messageEntity->SendDateTime = date("Y-m-d H:i:s");
        $messageEntity->SenderId =$currentUser->Id;
        $messageEntity->TypeId = $model->messageType;
        $this->MessageRepository->Insert($messageEntity);
        $content = null;
        if($model->messageType == 1)
        {
            $textMessageEntity = new TextMessage();
            $textMessageEntity->MessageId = $messageEntity->Id;
            $textMessageEntity->Text = $model->messageContent;
            $this->TextMessageRepository->Insert($textMessageEntity);
            $content = $textMessageEntity;
        }
        $conversationEntity->LastMessage = $messageEntity;
        $conversationEntity->Sender = $currentUser;
        unset($conversationEntity->Sender->Verified);
        unset($conversationEntity->Sender->PasswordHash);
        $conversationEntity->LastMessage->Content=$content;
        echo json_encode($conversationEntity);
    }
}