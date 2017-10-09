<?php

namespace App\Tests\Cipher\SubstitutionCipherTest;

use PHPUnit\Framework\TestCase;
use App\Cipher\SubstitutionCipher;

/**
 * @author Michael Phillips <michaeljoelphillips@gmail.com>
 */
class SubstitutionCipherTest extends TestCase
{
    public function setUp()
    {
        $this->subject = new SubstitutionCipher(
            array_combine(
                range('a', 'z'),
                range('z', 'a')
            )
        );
    }

    public function testDecipher()
    {
        $cipherText = implode('', range('Z', 'A'));
        $plainText = implode('', range('a', 'z'));

        $this->assertEquals($plainText, $this->subject->decipher($cipherText));
    }

    public function testEncipher()
    {
        $cipherText = implode('', range('z', 'a'));
        $plainText = implode('', range('A', 'Z'));

        $this->assertEquals($cipherText, $this->subject->encipher($plainText));
    }
}
