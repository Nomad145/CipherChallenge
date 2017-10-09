<?php

namespace App\Tokenizer;

use App\Tokenizer\TokenizerInterface;

/**
 * @author Michael Phillips <michaeljoelphillips@gmail.com>
 */
class NgramTokenizer implements TokenizerInterface
{
    /** @var int */
    protected $length = 0;

    /**
     * @param int $length
     */
    public function __construct(int $length)
    {
        $this->length = $length;
    }

    /**
     * {@inheritdoc}
     */
    public function tokenize(string $input) : array
    {
        $matches = [];
        preg_match_all($this->getRegex(), strtolower($input), $matches);

        return $matches[0];
    }

    /**
     * Returns a the formatted Regular Expression matching the n-gram.
     *
     * @return string
     */
    private function getRegex() : string
    {
        return sprintf("/[a-z]{%d}/", $this->length);
    }
}
