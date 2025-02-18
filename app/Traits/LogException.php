<?php

namespace App\Traits;

use Exception;
use Illuminate\Support\Facades\Log;

trait LogException
{
    use ResponseTrait;

    public function logException(Exception $exception): array
    {
        $this->deleteLogFileIfIsLong();

        $trace = debug_backtrace();
        $class = $trace[1]['class'];
        $function = $trace[1]['function'];
        Log::info('there is error at class ===> ' . $class . ' , function ===> ' . $function . ' //// the exception message ===========> ', [
            'message' => $exception->getMessage(),
            'file' => [
                'file' => $exception->getFile(),
                'line' => $exception->getLine(),
            ],
        ]);


        return [
            'key' => 'fail',
            'msg' => __('apis.some_thing_error'),
        ];
    }

    public function deleteLogFileIfIsLong($max_size = 10): void
    {
        $logFilePath = storage_path('logs/laravel.log');

        if (file_exists($logFilePath)) {
            $fileSize = filesize($logFilePath);

            $base = log($fileSize, 1024);
            $size = round(1024 ** ($base - floor($base)), 2);

            if ($size > $max_size) {
                unlink($logFilePath);
            }
        }
    }
}