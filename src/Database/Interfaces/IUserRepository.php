<?php


namespace Messenger\Database\Interfaces;


interface IUserRepository
{
    public function GetUserByEmail($email);
    public function GetUserByUsername($username);
}