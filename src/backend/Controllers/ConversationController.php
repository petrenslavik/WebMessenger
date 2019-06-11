<?php


namespace Messenger\Controllers;


use Messenger\Database\Repositories\ConversationRepository;

class ConversationController
{
    /** @var ConversationRepository $object */
    protected $ConversationRepositry;

    public function __construct()
    {
        $this->ConversationRepositry = new ConversationRepository();
    }

    public function GetAll()
    {
        $currentUser = $_SESSION["User"];
        $this->ConversationRepositry->GetByUserId($currentUser->Id);
        
    }
}