<?php

namespace App\Http\Requests;

use App\Traits\ResponseTrait;
use Illuminate\Foundation\Http\FormRequest;

class BaseRequest extends FormRequest
{
	use ResponseTrait;

	protected function mimesImage(): string
	{
		$extension = [
			'gif',
			'jpeg',
			'png',
			'swf',
			'psd',
			'bmp',
			'tiff',
			'tiff',
			'jpc',
			'jp2',
			'jpf',
			'jb2',
			'swc',
			'aiff',
			'wbmp',
			'xbm',
			'webp'
		];

		return implode(',', $extension);
	}

	protected function mimesVideo(): string
	{
		$extension = [
			'mp4',
			'avi',
			'mov',
			'wmv',
			'flv',
			'mkv',
			'webm',
			'3gp',
			'ogv',
			'mpeg',
			'm4v',
			'ts',
			'f4v',
			'swf',
			'vob',
			'asf',
		];
		return implode(',', $extension);
	}

	protected function mimesDocument(): string
	{
		$extension = ['pdf', 'doc', 'docx', 'xls', 'xlsx'];
		return implode(',', $extension);
	}
	protected function mimesAudio(): string
	{
		$extension = ['mp3', 'mp3', 'mp3']; //^^TODO 
		return implode(',', $extension);
	}

	protected function languages(): string
	{
		return implode(',', languages());
	}
	protected function deviceTypes(): string
	{
		return implode(',', ['android', 'ios', 'web']);
	}
}
