<?php

namespace PMVC\PlugIn\ml;

use InvalidArgumentException; 

# Normalization
use Phpml\Preprocessing;

abstract class PhpmlBaseAlgorithm extends BaseAlgorithm 
{
    public function getDefaultNormalizer() {
        return new Preprocessing\Normalizer();
    }

    public function predicts(array $samples)
    {
        if ($this->_normalizer) {
            $samples = $this->normalize($samples, $this->_normalizer);
        }
        return  $this->_app->predict($samples);
    }

    public function predict($sample)
    {
        if (is_array($sample)) {
            $sample = array_values($sample);
        }
        $a = $this->predicts([$sample]);
        return $a[0];
    }
}
