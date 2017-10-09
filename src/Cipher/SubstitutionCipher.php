<?php

namespace App\Cipher;

use App\Cipher\SwappableCipherInterface;

/**
 * @author Michael Phillips <michaeljoelphillips@gmail.com>
 */
class SubstitutionCipher implements SwappableCipherInterface
{
    /**
     * The character map for the Substitution Cipher.
     * Keys are plaintext characters.
     * Values are ciphertext characters.
     *
     * @var array
     */
    protected $map;

    /**
     * @param array $map
     */
    public function __construct(array $map)
    {
        $this->map = $map;

        ksort($this->map);
    }

    /**
     * {@inheritdoc}
     */
    public function encipher(string $message) : string
    {
        return strtr(strtolower($message), $this->map);
    }

    /**
     * {@inheritdoc}
     */
    public function decipher(string $message) : string
    {
        return strtr(strtolower($message), array_flip($this->map));
    }

    public function swap(string $a, string $b) : SwappableCipherInterface
    {
        $val = $this->map[$a];

        $this->map[$a] = $this->map[$b];
        $this->map[$b] = $val;

        return $this;
    }
}
