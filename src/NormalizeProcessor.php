<?php

namespace PMVC\PlugIn\ml;

use PMVC\HashMap;

class NormalizeProcessor
{
    private $_normalizer;

    private function _transformOne($samples, $processor, $labels = null)
    {
        $nextSamples = $processor->transform($samples, $labels);
        return $nextSamples && !is_bool($nextSamples) ? $nextSamples : $samples;
    }

    public function transform($samples, $labels = null)
    {
        $nextSamples = null;
        if ($this->_normalizer) {
            $nextSamples = $samples;
            if (is_array($this->_normalizer)) {
                foreach ($this->_normalizer as $n) {
                    $nextSamples = $this->_transformOne($nextSamples, $n, $labels);
                }
            } else {
                $nextSamples = $this->_transformOne(
                    $nextSamples,
                    $this->_normalizer,
                    $labels
                );
            }
        }
        return $nextSamples && !is_bool($nextSamples) ? $nextSamples : $samples;
    }

    public function __construct($normalizer, $algo = null)
    {
        if ($normalizer && !is_object($normalizer) && $algo) {
            $normalizer = $algo->getDefaultNormalizer();
        }
        $this->_normalizer = $normalizer;
    }
}
