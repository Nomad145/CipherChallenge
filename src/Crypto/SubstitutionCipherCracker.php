<?php

namespace App\Crypto;

use App\Tokenizer\TokenizerInterface;
use App\Factory\FrequencyDistributionFactory;
use App\Factory\SubstitutionCipherFactory;
use App\Analysis\FrequencyDistribution;
use App\Smoother\SmootherInterface;
use App\Cipher\CipherInterface;
use App\Crypto\CipherCrackerInterface;

/**
 * @author Michael Phillips <michaeljoelphillips@gmail.com>
 */
class SubstitutionCipherCracker implements CipherCrackerInterface
{
    /** @var TokenizerInterface */
    protected $tokenizer;

    /** @var FrequencyDistributionFactory */
    protected $frequencyDistributionFactory;

    /** @var SubstitutionCipherFactory */
    protected $cipherFactory;

    /** @var FrequencyDistribution */
    protected $sourceDistribution;

    /** @var SmootherInterface */
    protected $smoother;

    /**
     * @param TokenizerInterface $tokenizer
     * @param FrequencyDistributionFactory $frequencyDistributionFactory
     * @param SubstitutionCipherFactory $cipherFactory
     * @param FrequencyDistribution $sourceDistribution
     * @param SmootherInterface $smoother
     */
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

    /**
     * {@inheritdoc}
     */
    public function crack(string $cipherText) : CipherInterface
    {
        $tokens = $this->tokenizer->tokenize($cipherText);

        $frequencyDistribution = $this
            ->frequencyDistributionFactory
            ->withTokens($tokens);

        // Build a cipher from the source distribution and the ciphertext
        // distribution.
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
