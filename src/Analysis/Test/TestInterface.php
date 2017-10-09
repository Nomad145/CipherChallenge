<?php

namespace App\Analysis\Test;

/**
 * @author Michael Phillips <michaeljoelphillips@gmail.com>
 */
interface TestInterface
{
    /**
     * @param FrequencyDistribution $distribution
     * @return array The array of tokens that pass a given threshold.
     */
    public function execute(FrequencyDistribution $distribution) : array;
}
