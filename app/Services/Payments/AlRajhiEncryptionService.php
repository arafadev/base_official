<?php

namespace App\Services\Payments;

class AlRajhiEncryptionService
{
    private $key;
    private $iv;

    public function __construct()
    {
        $this->key = config('payments.Alrajhibank.ENCRYPTION_KEY');
        $this->iv = config('payments.Alrajhibank.IV');
    }

    /**
     * Encrypt data using AES-256-CBC
     */
    public function encrypt($data)
    {
        $encrypted = openssl_encrypt(
            $data,
            'aes-256-cbc',
            $this->key,
            OPENSSL_RAW_DATA,
            $this->iv
        );

        return bin2hex($encrypted);  // this method converts binary data to hexadecimal representation
    }

    /**
     * Decrypt data using AES-256-CBC
     */
    public function decrypt($data)
    {
        $binaryData = hex2bin($data);
        return openssl_decrypt(
            $binaryData,
            'aes-256-cbc',
            $this->key,
            OPENSSL_RAW_DATA,
            $this->iv
        );
    }
}