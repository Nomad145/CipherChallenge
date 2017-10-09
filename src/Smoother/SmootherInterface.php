<?php

namespace App\Smoother;

use App\Cipher\SwappableCipherInterface;

/**
 * @author Michael Phillips <michaeljoelphillips@gmail.com>
 */
interface SmootherInterface
{
    /**
     * @param SwappableCipherInterface $cipher
     * @param string $text
     * @return SwappableCipherInterface
     */
    public function smooth(SwappableCipherInterface $cipher, string $text) : SwappableCipherInterface;
}
