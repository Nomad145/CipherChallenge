<?php

namespace App\Factory;

use App\FrequencyDistribution;

/**
 * @author Michael Phillips <michaeljoelphillips@gmail.com>
 */
class FrequencyDistributionFactory
{
    /**
     * @param array $tokens
     * @return FrequencyDistribution
     */
    public function withTokens(array $tokens) : FrequencyDistribution
    {
        return new FrequencyDistribution($tokens);
    }
}
