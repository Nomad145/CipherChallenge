<?php

namespace App\Tokenizer;

use App\Tokenizer\TokenizerInterface;

/**
 * @author Michael Phillips <michaeljoelphillips@gmail.com>
 */
class CharacterTokenizer implements TokenizerInterface
{
    /**
     * {@inheritdoc}
     */
    public function tokenize(string $input) : array
    {
        return array_filter(
            str_split(strtolower($input)),
            'ctype_alpha'
        );
    }
}
