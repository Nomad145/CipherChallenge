<?php

namespace App\Smoother;

use App\Cipher\SwappableCipherInterface;

/**
 * @author Michael Phillips <michaeljoelphillips@gmail.com>
 */
interface SmootherInterface
{
    public function smooth(SwappableCipherInterface $cipher, string $text) : SwappableCipherInterface;
}
