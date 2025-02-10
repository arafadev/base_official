<?php

namespace App\Channels;

use App\Jobs\FireBase\SendFirebaseNotificationToMultipleJob;
use Illuminate\Notifications\Notification;

class FirebaseChannel
{
	public function send($notifiable, Notification $notification) : void
	{
		SendFirebaseNotificationToMultipleJob::dispatch($notifiable, $notification->data);
	}
}
