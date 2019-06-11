<?php


namespace Messenger\Database\Interfaces;

interface IMessageRepository extends IBaseRepository
{
    public function GetLastMessageByConversationId($conversationId);
}