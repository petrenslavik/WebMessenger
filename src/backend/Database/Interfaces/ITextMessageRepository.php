<?php


namespace Messenger\Database\Interfaces;


interface ITextMessageRepository extends IBaseRepository
{
    public function GetByMessageId($id);
}