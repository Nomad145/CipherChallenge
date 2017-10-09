<?php

namespace App\Tokenizer;

/**
 * @author Michael Phillips <michaeljoelphillips@gmail.com>
 */
interface TokenizerInterface
{
    /**
     * @param string $input
     * @return array
     */
    public function tokenize(string $input) : array;
}
