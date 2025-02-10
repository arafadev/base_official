<?php

namespace App\Notifications;

use App\Models\Admin;
use App\Enums\NotificationType;

class NotifyAdmin extends BaseNotification
{

	public function __construct()
	{
		$this->data = [
			'type' => 'admin_notify',
			'sender' => 1,
			'sender_name' => Admin::find(1)->name,
		];
	}
}
