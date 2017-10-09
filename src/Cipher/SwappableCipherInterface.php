<?php

namespace App\Cipher;

use App\Cipher\CipherInterface;

/**
 * @author Michael Phillips <michaeljoelphillips@gmail.com>
 */
interface SwappableCipherInterface extends CipherInterface
{
    /**
     * @param string
     * @param string
     * @return void
     */
    public function swap(string $a, string $b) : SwappableCipherInterface;
}
