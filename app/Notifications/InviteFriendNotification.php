<?php
namespace App\Notifications;
use App\Enums\NotificationType;

class InviteFriendNotification extends BaseNotification
{
    public function __construct()
    {
        $this->data = [
            'type'       => NotificationType::NEW_CONTACT_US_MESSAGE,
            'id'         => auth()->user()->id,
            'name'       => auth()->user()->name,
        ];
    }
}
