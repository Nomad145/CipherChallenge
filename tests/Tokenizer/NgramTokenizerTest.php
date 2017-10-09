<?php

namespace App\Tests\Tokenizer;

use PHPUnit\Framework\TestCase;
use App\Tokenizer\NgramTokenizer;

/**
 * @author Michael Phillips <michaeljoelphillips@gmail.com>
 */
class NgramTokenizerTest extends TestCase
{
    public function testTokenize()
    {
        $subject = new NgramTokenizer(4);
        $tokens = $subject->tokenize('that then7 misunderstand qwerty.');

        $this->assertEquals(['that', 'then', 'misu', 'nder', 'stan', 'qwer'], $tokens);
    }
}
