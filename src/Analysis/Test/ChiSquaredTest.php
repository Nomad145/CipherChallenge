<?php

namespace App\Analysis\Test;

use App\FrequencyDistribution;

/**
 * Implements the Chi-Squared Test, comparing an expected frequency
 * distribution with the observed frequency distribution of cipher text.
 *
 * @author Michael Phillips <michaeljoelphillips@gmail.com>
 */
class ChiSquaredTest
{
    /** @const float */
    const THRESHOLD = 0;

    /**
     * {@inheritdoc}
     */
    public function execute(FrequencyDistribution $expected, FrequencyDistribution $observed) : float
    {
        /** @var array */
        $expectedArray = array_values($expected->getDistribution());
        $observedArray = array_values($observed->getDistribution());

        $distroSize = count($expectedArray);

        if ($distroSize !== count($observedArray)) {
            throw new DistributionSizeException('The algorithm cannot compare distributions of unequal size.');
        }

        $result = 0;

        for ($i = 0; $i < $distroSize; $i++) {
            $observedCount = $observedArray[$i] * $observed->getTextLength();
            $expectedCount = $expectedArray[$i] * $observed->getTextLength();

            $difference = $observedCount - $expectedCount;

            $result += $difference * $difference / $expectedCount;
        }

        return $result;
    }
}
