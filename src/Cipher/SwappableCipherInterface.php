<?php

namespace App\Cipher;

use App\Cipher\CipherInterface;

/**
 * @author Michael Phillips <michaeljoelphillips@gmail.com>
 */
interface SwappableCipherInterface extends CipherInterface
{
    /**
     * Swaps two characters within a cipher.
     *
     * @param string $a
     * @param string $b
     * @return void
     */
    public function swap(string $a, string $b) : SwappableCipherInterface;
}
