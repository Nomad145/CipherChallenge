<?php

namespace App\Crypto;

use App\Tokenizer\TokenizerInterface;
use App\Factory\FrequencyDistributionFactory;
use App\Factory\SubstitutionCipherFactory;
use App\FrequencyDistribution;
use App\Smoother\SmootherInterface;
use App\Cipher\CipherInterface;

/**
 * @author Michael Phillips <michaeljoelphillips@gmail.com>
 */
class SubstitutionCipherCracker
{
    public function __construct(
        TokenizerInterface $tokenizer,
        FrequencyDistributionFactory $frequencyDistributionFactory,
        SubstitutionCipherFactory $cipherFactory,
        FrequencyDistribution $sourceDistribution,
        SmootherInterface $smoother
    ) {
        $this->tokenizer = $tokenizer;
        $this->frequencyDistributionFactory = $frequencyDistributionFactory;
        $this->cipherFactory = $cipherFactory;
        $this->sourceDistribution = $sourceDistribution;
        $this->smoother = $smoother;
    }

    public function crack(string $cipherText) : CipherInterface
    {
        $tokens = $this->tokenizer->tokenize($cipherText);

        $frequencyDistribution = $this
            ->frequencyDistributionFactory
            ->withTokens($tokens);

        // The cipher built only using FrequencyDistributions of the source
        // text and the cipher text.
        $cipher = $this
            ->cipherFactory
            ->withFrequencyDistributions(
                $this->sourceDistribution,
                $frequencyDistribution
            );

        // Attempt to smooth out any inaccuracies with the cipher.
        return $this->smoother->smooth($cipher, $cipherText);
    }
}
