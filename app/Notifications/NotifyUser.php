<?php

namespace App\Notifications;

use App\Enums\NotificationType;

class NotifyUser extends BaseNotification
{

    public function __construct($request)
    {
        $this->data = [
            // 'body_ar'       => $request['body_ar'],
            // 'body_en'       => $request['body_en'],
            'type'          => NotificationType::ADMIN_NOTIFY ,
        ];
    }
}
