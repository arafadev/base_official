<?php

namespace App\Notifications;

use App\Channels\FirebaseChannel;
use App\Jobs\FireBase\SendFirebaseNotificationToMultipleJob;
use App\Traits\FirebaseTrait;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;


class BaseNotification extends Notification
{
	use Queueable, FirebaseTrait;

	public $data;

	public function via(mixed $notifiable): array
	{
		return ['database', FirebaseChannel::class];
	}


	public function toDatabase() : array
	{
		return $this->data;
	}
	public function toFirebase() : array
	{
		return $this->data;
	}

}
