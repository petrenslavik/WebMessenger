<?php


namespace Messenger\Database\Repositories;


class TextMessageRepository extends BaseRepository
{
    public function __construct()
    {
        parent::__construct("messagetext", "Messenger\Models\TextMessage");
    }
}