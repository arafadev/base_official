<?php

namespace App\Traits;

use App\Models\Device;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;

trait FirebaseTrait
{

	use NotificationMessageTrait;

	private $authFailedCount = 3;

	private function prepareData($language): array
	{
 		$newData = array_map('strval', $this->data);
		Carbon::setLocale($language);
		$newData['created_at'] = Carbon::now()->diffForHumans();
		return $newData;
	}

	private function credentials()
	{
		return json_decode(file_get_contents(storage_path('app/firebase_credentials.json')), true);
	}


	function sendFirebaseNotification($notifiable) : void
	{
		foreach (languages() as $language) {
			$deviceTokens = $notifiable->devices()->where('lang', $language)->where('is_notify', 1)->select('device_id', 'lang', 'device_type')->get();
			foreach ($deviceTokens as $deviceToken) {
				$this->sendFirebaseNotifications($deviceToken);
			}
		}

	}


	private function sendFirebaseNotifications($deviceToken) : void
	{
		$language    = $deviceToken->lang;
		$token       = $deviceToken->device_id;
		$type        = $deviceToken->device_type;
		$accessToken = Cache::rememberForever('firebase_access_token', function () {
			return $this->getToken();
		});
		$title       = $this->getTitle($this->prepareData($language), $language);
		$body        = $this->getBody($this->prepareData($language), $language);
		$projectId   = $this->credentials()['project_id'];
		$fcmUrl      = "https://fcm.googleapis.com/v1/projects/$projectId/messages:send";

		$notificationData = [
			'title' => $title,
			'body'  => $body,
			// 'image' => url('/') . settings('logo'),
		];

		$notification = match ($type) {
			'ios'     => $this->getIosMessageFormat($token, $notificationData, $language),
			'android' => $this->getAndroidMessageFormat($token, $language),
			default   => $this->getWebMessageFormat($token, $notificationData, $language),
		};

		// Set the headers for the HTTP request
		$headers = [
			'Authorization' => 'Bearer ' . $accessToken, // Use the OAuth2 token here
			'Content-Type'  => 'application/json',
		];

		$response = Http::withHeaders($headers)->post($fcmUrl, $notification);

		if (in_array($response->getStatusCode(), [400, 404])) {
			DB::table('devices')->where('device_id', $token)->delete();
		}



		if ($response->getStatusCode() == 401 && $this->authFailedCount > 0) {
			$this->authFailedCount--;
			Cache::forget('firebase_access_token');
			$this->sendFirebaseNotifications($deviceToken);
		}
	}

	public function getToken()
	{
		$clientEmail = $this->credentials()['client_email'];
		$privateKey  = $this->credentials()['private_key'];

		$secret = openssl_get_privatekey($privateKey);


		$header = json_encode([
			'typ' => 'JWT',
			'alg' => 'RS256'
		]);

		// Get seconds since 1 January 1970
		$time = time();

		$payload = json_encode([
			"iss"   => $clientEmail,
			"scope" => "https://www.googleapis.com/auth/firebase.messaging",
			"aud"   => "https://oauth2.googleapis.com/token",
			"exp"   => $time + 3600,
			"iat"   => $time
		]);

		$base64UrlHeader = $this->base64UrlEncode($header);

		$base64UrlPayload = $this->base64UrlEncode($payload);

		$result = openssl_sign($base64UrlHeader . "." . $base64UrlPayload, $signature, $secret, OPENSSL_ALGO_SHA256);

		$base64UrlSignature = $this->base64UrlEncode($signature);

		$jwt = $base64UrlHeader . "." . $base64UrlPayload . "." . $base64UrlSignature;

		$client = new Client();

		$response = $client->post('https://oauth2.googleapis.com/token', [
			'form_params' => [
				'grant_type' => 'urn:ietf:params:oauth:grant-type:jwt-bearer',
				'assertion'  => $jwt
			],
			'headers'     => [
				'Content-Type' => 'application/x-www-form-urlencoded'
			]
		]);

		$responseBody = json_decode($response->getBody());

		if (!isset($responseBody->access_token)) {
			throw new \Exception("Failed to get access token: " . json_encode($responseBody));
		}

		return $responseBody->access_token;
	}


	private function base64UrlEncode($text)
	{
		return str_replace(
			['+', '/', '='],
			['-', '_', ''],
			base64_encode($text)
		);
	}

	private function getIosMessageFormat($token, $notification, $language): array
	{
		return [
			'message' => [
				'token'        => $token,
				'notification' => $notification,
				'data'         => $this->prepareData($language),
				'apns'         => [
					'headers' => [
						'apns-priority'  => '10', // High priority for immediate delivery
						'apns-push-type' => 'alert', // For alert notifications
					],
					'payload' => [
						'aps' => [
							'alert' => $notification,
							'sound' => 'default',
						],
					],
				],
			],
		];
	}

	private function getWebMessageFormat($token, $notification, $language): array
	{
		return [
			'message' => [
				'token'        => $token,
				'data'         => $this->prepareData($language),
				'notification' => $notification,
				"webpush"      => [
					"fcm_options" => [
						"link" => array_key_exists('url', $this->data) ? $this->data['url'] : url('/')
					]
				],
			]
		];
	}


	private function getAndroidMessageFormat($token, $language): array
	{
		return [
			'message' => [
				'token' => $token,
				'data'  => $this->prepareData($language),
			],
		];
	}


}