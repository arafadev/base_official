<?php
namespace App\Http\Requests\Api;
use App\Traits\ResponseTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class BaseApiRequest extends FormRequest 
{
  use ResponseTrait;

  public function authorize()
  {
    return true;
  }

  protected function failedValidation(Validator $validator)
  {
    throw new HttpResponseException($this->response('fail', $validator->errors()->first()));
  }

  protected function mimesImage(): string
  {
      $extension = [
          'gif', 'jpeg', 'png', 'swf', 'psd', 'bmp',
          'tiff', 'tiff', 'jpc', 'jp2', 'jpf', 'jb2', 'swc',
          'aiff', 'wbmp', 'xbm', 'webp'
      ];

      return implode(',', $extension);
  }
}
