<?php

namespace App\Factory;

use App\Cipher\SubstitutionCipher;
use App\Analysis\FrequencyDistribution;

/**
 * @author Michael Phillips <michaeljoelphillips@gmail.com>
 */
class SubstitutionCipherFactory
{
    /**
     * @param FrequencyDistribution $source
     * @param FrequencyDistribution $target
     * @return SubstitutionCipher
     */
    public function withFrequencyDistributions(FrequencyDistribution $source, FrequencyDistribution $target) : SubstitutionCipher
    {
        return new SubstitutionCipher(
            array_combine(
                array_keys($source->getDistribution()),
                array_keys($target->getDistribution())
            )
        );
    }
}
