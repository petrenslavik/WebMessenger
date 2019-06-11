<?php


namespace Messenger\backend\Database\Interfaces;


use Messenger\Database\Interfaces\IBaseRepository;

interface IConversationRepository extends IBaseRepository
{
    public function GetByUserId($userId);

}