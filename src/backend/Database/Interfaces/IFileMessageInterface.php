<?php


namespace Messenger\Database\Interfaces;


interface IFileMessageInterface extends  IBaseRepository
{
    public function GetByMessageId($id);
}