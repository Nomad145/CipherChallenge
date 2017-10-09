<?php

namespace App\Crypto;

use App\Cipher\CipherInterface;

/**
 * @author Michael Phillips <michaeljoelphillips@gmail.com>
 */
interface CipherCrackerInterface
{
    /**
     * @param string $cipherText
     * @return CipherInterface
     */
    public function crack(string $cipherText) : CipherInterface;
}
