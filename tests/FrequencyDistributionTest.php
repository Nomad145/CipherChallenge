<?php

namespace App\Tests;

use PHPUnit\Framework\TestCase;
use App\FrequencyDistribution;
use App\Tokenizer\CharacterTokenizer;

/**
 * @author Michael Phillips <michaeljoelphillips@gmail.com>
 */
class FrequencyDistributionTest extends TestCase
{
    public function setUp()
    {
        $tokenizer = new CharacterTokenizer();
        $tokens = $tokenizer->tokenize('abcdefg');

        $this->subject = new FrequencyDistribution($tokens);
    }

    public function testGetDistribution()
    {
        $distribution = array_fill_keys(
            range('a', 'g'),
            0.14285714285714285
        );

        $this->assertSame($distribution, $this->subject->getDistribution());
    }

    public function testGetTextLength()
    {
        $this->assertEquals(7, $this->subject->getTextLength());
    }
}
