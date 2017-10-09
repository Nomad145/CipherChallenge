<?php

namespace App\Tests\Crypto;

use PHPUnit\Framework\TestCase;
use App\Tokenizer\TokenizerInterface;

/**
 * @author Michael Phillips <michaeljoelphillips@gmail.com>
 */
class SubstitutionCipherCrackerTest extends TestCase
{
    public function setUp()
    {
        $tokenizer = $this->createMock(TokenizerInterface::class);
        $distFactory = $this->createMock(FrequencyDistributionFactory::class);
        $sourceDist = $this-

        $this->subject = new SubstitutionCipherCracker();
    }
}
