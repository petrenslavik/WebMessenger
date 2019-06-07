<?php

namespace Messenger\Database;

interface IBaseRepository{
    public function GetById($id);
    public function Insert($entity);
    public function Delete($entity);
    public function Update($entity);
    public function GetAll();
    public function GetCount();
    public function GetSet($startIndex, $amount);
}