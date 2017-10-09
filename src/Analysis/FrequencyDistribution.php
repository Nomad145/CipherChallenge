<?php

namespace App\Analysis;

/**
 * @author Michael Phillips <michaeljoelphillips@gmail.com>
 */
class FrequencyDistribution
{
    /**
     * The textLength number of tokens used for the distribution.
     *
     * @var int
     */
    protected $textLength;

    /** @var array */
    protected $distribution;

    /**
     * @param string
     */
    public function __construct(array $tokens)
    {
        // @todo: Throw Exception if tokens === 0.
        $this->textLength = count($tokens);
        $this->distribution = $this->calculateDistribution($tokens);
    }

    /**
     * @return array
     */
    public function getDistribution() : array
    {
        return $this->distribution;
    }

    /**
     * @return int
     */
    public function getTextLength() : int
    {
        return $this->textLength;
    }

    /**
     * @return array
     */
    protected function calculateDistribution(array $tokens) : array
    {
        $distribution = array_count_values($tokens);

        array_walk(
            $distribution,
            function (&$value, $key) {
                $value = $value / $this->textLength;
            }
        );

        arsort($distribution);

        return $distribution;
    }
}
