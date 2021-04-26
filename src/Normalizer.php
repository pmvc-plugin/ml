<?php

namespace PMVC\PlugIn\ml;

use PMVC\HashMap;

class Normalizer {

    private $_normalizer;

    public function transform(&$samples) {
        $nextSamples = null; 
        if ($this->_normalizer) {
            $nextSamples = $this->_normalizer->transform($samples);
        }
        return $nextSamples && !is_bool($nextSamples) ? $nextSamples : $samples;
    }

    public function __construct($normalizer, $algo) {
        if ($normalizer && !is_object($normalizer)) {
            $normalizer = $algo->getDefaultNormalizer();
        }
        $this->_normalizer = $normalizer;
    }
}
