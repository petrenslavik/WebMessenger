<?php


namespace Messenger\ViewModels;


use Messenger\Core\BaseViewModel;

class ConversationStart extends BaseViewModel
{
    public $userId, $messageType, $messageContent;

    protected function validate(): bool
    {
        if(!is_numeric($this->userId))
            return false;
        if(!($this->messageType >0 && $this->messageType<3))
            return false;
        if(!$this->messageContent)
            return false;
        return true;
    }
}