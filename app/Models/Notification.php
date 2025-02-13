<?php

namespace App\Models;

use App\Traits\NotificationMessageTrait;
use Illuminate\Notifications\DatabaseNotification;

class Notification extends DatabaseNotification
{
    use NotificationMessageTrait ;

    public function getTypeAttribute($value)
    {
        return $this->data['type'] ;
    }

    public function getTitleAttribute($value) : string
    {
        return $this->getTitle($this->data , lang() ) ;
    }

    public function getBodyAttribute($value) : string
    {   
        return $this->getBody($this->data ,  lang());
    }

    public function getSenderAttribute($value) : array
    {
        $def    = 'App\Models\\' . $this->data['sender_model'];
        $sender = $def::find($this->data['sender']);
        return [
            'name'   => $sender->name,
            'avatar' => $sender->avatar,
        ];
    }

}
