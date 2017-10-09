<?php

namespace App\Cipher;

/**
 * @author Michael Phillips <michaeljoelphillips@gmail.com>
 */
interface CipherInterface
{
    /**
     * @param string $message
     * @return string
     */
    public function encipher(string $message) : string;

    /**
     * @param string $message
     * @return string
     */
    public function decipher(string $message) : string;
}
