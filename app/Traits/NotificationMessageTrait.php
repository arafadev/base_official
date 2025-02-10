<?php

namespace App\Traits;

trait NotificationMessageTrait
{

	public function getTitle(array $notification_data, $local = 'ar') : string
	{
		return trans('notification.title_' . $notification_data['type'], $notification_data, $local);
	}

	public function getBody(array $notification_data, $local = 'ar') : string
	{
		if ('admin_notify' == $notification_data['type']) {
			return $notification_data['body_' . $local]; //! check dashboard input name
		} else {
			return $this->transTypeToBody($notification_data, $local);
		}
	}

	private function transTypeToBody($notification_data, $local) : string
	{
		return trans('notification.body_' . $notification_data['type'], $notification_data, $local);
	}

}
