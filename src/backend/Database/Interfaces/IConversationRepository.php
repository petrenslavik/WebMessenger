<?php


namespace Messenger\Database\Interfaces;

interface IConversationRepository extends IBaseRepository
{
    public function GetByUserId($userId);

}