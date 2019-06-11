<?php


namespace Messenger\Database\Interfaces;


interface IUserRepository extends IBaseRepository
{
    public function GetUserByEmail($email);
    public function GetUserByUsername($username);
}