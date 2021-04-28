<?php

namespace PMVC\PlugIn\ml;

use Phpml\Preprocessing\Normalizer;

${_INIT_CONFIG}[_CLASS] = __NAMESPACE__ . '\PhpmlGetNormalizer';

/**
 * @see https://php-ml.readthedocs.io/en/latest/machine-learning/preprocessing/normalization/
 * @see https://gitlab.com/php-ai/php-ml/-/blob/master/src/Preprocessing/Normalizer.php
 */
class PhpmlGetNormalizer
{
    public function __invoke($s)
    {
        $n = null;
        switch ($s) {
            case 'normalizeL1':
                $n = new Normalizer(Normalizer::NORM_L1);
                break;
            case 'normalizeL2':
                $n = new Normalizer(Normalizer::NORM_L2);
                break;
            case 'normalizeSTD':
                $n = new Normalizer(Normalizer::NORM_STD);
                break;
        }
        return $n;
    }
}
