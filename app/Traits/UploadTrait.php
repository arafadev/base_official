<?php

namespace App\Traits;

use File;
use Intervention\Image\Facades\Image;

trait UploadTrait
{


  public function uploadAllTyps($file, $directory, $width = null, $height = null)
  {
    if (!File::isDirectory('storage/images/' . $directory)) {
      File::makeDirectory('storage/images/' . $directory, 0777, true, true);
    }

    $fileMimeType = $file->getClientmimeType(); // image/png
    $imageCheck = explode('/', $fileMimeType);  // [ 0 => 'image', 1 => 'png']


    if ($imageCheck[0] == 'image') {
      $allowedImagesMimeTypes = ['image/jpeg', 'image/jpg', 'image/png'];
      if (!in_array($fileMimeType, $allowedImagesMimeTypes)){
        return 'default.png';
      }

      return $this->uploadeImage($file, $directory, $width, $height);
    }

    $allowedMimeTypes = ['application/pdf', 'application/msword', 'application/excel', 'application/vnd.ms-excel', 'application/vnd.msexcel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'application/octet-stream'];
    if (!in_array($fileMimeType, $allowedMimeTypes))
      return  'default.png';

    return $this->uploadFile($file, $directory);
  }

  public function uploadFile($file, $directory)
  {
    $filename = time() . rand(1000000, 9999999) . '.' . $file->getClientOriginalExtension();
    $path = 'images/' . $directory;
    $file->storeAs($path, $filename);
    return $filename;
  }

  public function uploadeImage($file, $directory, $width = null, $height = null)
{

    $thumbsPath = 'storage/images/' . $directory;
    // if (!File::isDirectory($thumbsPath)) {
    //     File::makeDirectory($thumbsPath, 0777, true, true);
    // }

    $name = rand(1111, 9999) . '.' . $file->getClientOriginalExtension();

    $file->move($thumbsPath, $name);

    return (string) $name;
}


  public function deleteFile($file_name, $directory = 'unknown'): void
  {
    if ($file_name && $file_name != 'default.png' && file_exists("storage/images/$directory/$file_name")) {
      unlink("storage/images/$directory/$file_name");
    }
  }

  public function defaultImage($directory)
  {
    return asset("/storage/images/$directory/default.png");
  }

  public static function getImage($name, $directory)
  {
    return asset("storage/images/$directory/" . $name);
  }
}
