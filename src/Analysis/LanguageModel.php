<?php

namespace App\Analysis;

use App\Tokenizer\TokenizerInterface;
use App\Tokenizer\NgramTokenizer;
use App\Tokenizer\CharacterTokenizer;
use App\Analysis\FrequencyDistribution;

/**
 * Encapsulates different frequency distributions built from source text.
 *
 * @author Michael Phillips <michaeljoelphillips@gmail.com>
 */
class LanguageModel
{
    /** @var FrequencyDistribution */
    protected $unigramDistribution;

    /** @var FrequencyDistribution */
    protected $quadgramDistribution;

    /**
     * @param string $sourcePath
     */
    public function __construct(string $sourcePath)
    {
        if (!file_exists($sourcePath)) {
            throw new \InvalidArgumentException('The source file does not exist.');
        }

        $contents = file_get_contents($sourcePath);

        $uniTokens = (new CharacterTokenizer())->tokenize($contents);
        $quadTokens = (new NgramTokenizer(4))->tokenize($contents);

        $this->quadgramDistribution = new FrequencyDistribution($quadTokens);
        $this->unigramDistribution = new FrequencyDistribution($uniTokens);
    }

    /**
     * @param FrequencyDistribution $unigramDistribution
     * @return $this
     */
    public function setUnigramDistribution(FrequencyDistribution $unigramDistribution) : LanguageModel
    {
        $this->unigramDistribution = $unigramDistribution;

        return $this;
    }

    /**
     * @return FrequencyDistribution
     */
    public function getUnigramDistribution() : ?FrequencyDistribution
    {
        return $this->unigramDistribution;
    }

    /**
     * @param FrequencyDistribution $quadgramDistribution
     * @return $this
     */
    public function setQuadgramDistribution(FrequencyDistribution $quadgramDistribution) : LanguageModel
    {
        $this->quadgramDistribution = $quadgramDistribution;

        return $this;
    }

    /**
     * @return FrequencyDistribution
     */
    public function getQuadgramDistribution() : ?FrequencyDistribution
    {
        return $this->quadgramDistribution;
    }
}
