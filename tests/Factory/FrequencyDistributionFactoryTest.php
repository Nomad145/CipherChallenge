<?php

namespace App\Tests\Factory;

use PHPUnit\Framework\TestCase;
use App\Factory\FrequencyDistributionFactory;
use App\Analysis\FrequencyDistribution;

/**
 * @author Michael Phillips <michaeljoelphillips@gmail.com>
 */
class FrequencyDistributionFactoryTest extends TestCase
{
    public function testWithTokens()
    {
        $subject = new FrequencyDistributionFactory();
        $tokens = range('a', 'z');

        $distribution = $subject->withTokens($tokens);

        $this->assertInstanceOf(FrequencyDistribution::class, $distribution);
    }
}
