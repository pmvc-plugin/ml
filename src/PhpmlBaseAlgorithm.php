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

}
