<?php


namespace Messenger\Database\Interfaces;


interface IEmailTokenRepository extends IBaseRepository
{
    public function GetByToken($token);
}