<?php

namespace App\Tests\Factory;

use PHPUnit\Framework\TestCase;
use App\Factory\SubstitutionCipherFactory;
use App\Cipher\SubstitutionCipher;
use App\Analysis\FrequencyDistribution;

/**
 * @author Michael Phillips <michaeljoelphillips@gmail.com>
 */
class SubstitutionCipherFactoryTest extends TestCase
{
    public function testWithFrequencyDistributions()
    {
        $subject = new SubstitutionCipherFactory();

        $cipher = $subject->withFrequencyDistributions(
            new FrequencyDistribution(range('a', 'z')),
            new FrequencyDistribution(range('z', 'a'))
        );

        $this->assertInstanceOf(SubstitutionCipher::class, $cipher);
    }
}
