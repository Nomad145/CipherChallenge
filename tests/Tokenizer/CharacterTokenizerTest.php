<?php

namespace App\Tests\Tokenizer;

use PHPUnit\Framework\TestCase;
use App\Tokenizer\CharacterTokenizer;

/**
 * @author Michael Phillips <michaeljoelphillips@gmail.com>
 */
class CharacterTokenizerTest extends TestCase
{
    public function testTokenize()
    {
        $subject = new CharacterTokenizer();
        $tokens = $subject->tokenize('aBcDeFg7. ');

        $this->assertEquals(range('a', 'g'), $tokens);
    }
}
