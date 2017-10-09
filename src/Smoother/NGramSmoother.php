<?php

namespace App\Smoother;

use App\FrequencyDistribution;
use App\Cipher\SwappableCipherInterface;
use App\Factory\FrequencyDistributionFactory;
use App\Tokenizer\TokenizerInterface;
use App\Cipher\CipherInterface;

/**
 * Iteratively smooths a cipher by comparing the fitness of deciphered text
 * with a list of ngrams from a source frequency distribution.
 *
 * @author Michael Phillips <michaeljoelphillips@gmail.com>
 */
class NGramSmoother implements SmootherInterface
{
    /**
     * The allowed frequency variance of two ngrams being compared.
     *
     * @const float
     */
    protected const FREQUENCY_VARIANCE = 0.06;

    /**
     * The base frequency distribution to compare with the cipher text.
     *
     * @var FrequencyDistribution
     */
    protected $sourceDistribution;

    /** @var FrequencyDistributionFactory */
    protected $frequencyDistributionFactory;

    /** @var TokenizerInterface */
    protected $tokenizer;

    /**
     * @param FrequencyDistribution $sourceDistribution
     * @param FrequencyDistributionFactory $FrequencyDistributionFactory
     * @param TokenizerInterface $tokenizer
     */
    public function __construct(
        FrequencyDistribution $sourceDistribution,
        FrequencyDistributionFactory $frequencyDistributionFactory,
        TokenizerInterface $tokenizer
    ) {
        $this->sourceDistribution = $sourceDistribution;
        $this->frequencyDistributionFactory = $frequencyDistributionFactory;
        $this->tokenizer = $tokenizer;
    }

    /**
     * {@inheritdoc}
     */
    public function smooth(SwappableCipherInterface $cipher, string $text) : SwappableCipherInterface
    {
        // The frequency distribution of the deciphered text with $cipher.
        $textDistribution = $this->buildDistribution($cipher, $text);

        /** @var array */
        $remaining = $this->findIncorrectCharacters($textDistribution);

        // The estimated fitness of the text.
        $fitness = $this->estimateFitness(
            $cipher->decipher($text)
        );

        // Smooth the cipher by incrementally swapping the remaining characters
        // and checking the fitness of the text with the fitness of the last
        // iteration.
        for ($n = 0; $n < count($remaining); $n++) {
            for ($k = $n; $k < count($remaining); $k++) {
                $newCipher = (clone $cipher)->swap(
                    $remaining[$n],
                    $remaining[$k]
                );

                $newFitness = $this->estimateFitness(
                    $newCipher->decipher($text)
                );

                if ($newFitness > $fitness) {
                    $cipher = $newCipher;
                    $fitness = $newFitness;
                }
            }
        }

        return $cipher;
    }

    /**
     * Returns a general fitness level of the text based on the number of times
     * the top ngrams occur.
     *
     * @param string
     * @return int
     */
    protected function estimateFitness(string $text) : int
    {
        // Sample the top 100 ngrams from the source distribution.
        $sample = array_slice($this->sourceDistribution->getDistribution(), 0, 100);

        return array_reduce(
            array_keys($sample),
            function ($count, $ngram) use ($text) {
                // Count the number of occurrances of each ngram in the
                // deciphered text.
                return $count += substr_count($text, $ngram);
            },
            0
        );
    }

    /**
     * Builds a list of characters that are incorrectly set on the cipher based
     * on the likelihood that two n-grams from two distributions are the same.
     *
     * @param FrequencyDistribution
     * @return array
     */
    protected function findIncorrectCharacters(FrequencyDistribution $textDistribution) : array
    {
        // Find intersections between the distributions that have a frequency
        // variance less than or equal to self::FREQUENCY_VARIANCE.  The
        // resulting array should contain ngrams that match the source text by
        // 94% or higher.
        $common = array_uintersect_assoc(
            $this->sourceDistribution->getDistribution(),
            $textDistribution->getDistribution(),
            function ($a, $b) {
                // Only allow small variances in the frequencies.
                return abs(($a - $b) / $a) <= self::FREQUENCY_VARIANCE ? 0 : -1;
            }
        );

        // Reduce the common ngrams to an array of unique characters.  This
        // list should contains characters that are correctly set on the cipher.
        $common = array_unique(
            array_reduce(
                array_keys($common),
                function ($carry, $item) {
                    return array_merge(
                        $carry,
                        str_split($item)
                    );
                },
                // Start with an empty array.
                []
            )
        );

        // Diff the correct list with the full alphabet.  The remaining characters
        // are characters that need smoothing.  The size of this list depends
        // entirely on the similarity of the freqency distributions of the
        // source and the cipher text.
        //
        // Call `array_values` to re-index the keys.
        $diff = array_values(array_diff(range('a', 'z'), $common));

        return $diff;
    }

    /**
     * A helper method to build a frequency distribution from a cipher.
     *
     * @param CipherInterface $cipher
     * @param string $text
     * @return FrequencyDistribution
     */
    protected function buildDistribution(CipherInterface $cipher, string $text) : FrequencyDistribution
    {
        $tokens = $this
            ->tokenizer
            ->tokenize($cipher->decipher($text));

        return $this
            ->frequencyDistributionFactory
            ->withTokens($tokens);
    }
}
