<?php


namespace Messenger\Database\Repositories;


class FileMessageRepository extends BaseRepository
{
    public function __construct()
    {
        parent::__construct("files", "Messenger\Models\FileMessage");
    }
}