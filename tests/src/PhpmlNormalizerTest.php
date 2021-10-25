<?php

namespace PMVC\PlugIn\ml;

use PMVC\TestCase;

class PhpmlNormalizerTest extends TestCase
{
    private $_plug = 'ml';

    /**
     * @see https://php-ml.readthedocs.io/en/latest/machine-learning/preprocessing/normalization/
     */
    function testSimple()
    {
        $p = \PMVC\plug($this->_plug);
        $n = new NormalizeProcessor([$p->phpml()->get_normalizer('normalizeL1')]);
        $samples = [[1, -1, 2], [2, 0, 0], [0, 1, -1]];
        $results = $n->transform($samples);
        $this->assertEquals(
            [[0.25, -0.25, 0.5], [1.0, 0.0, 0.0], [0.0, 0.5, -0.5]],
            $results
        );
    }
}
