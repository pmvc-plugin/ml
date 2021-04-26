<?php

namespace PMVC\PlugIn\ml;

use PMVC\TestCase;
use Rubix\ML\Classifiers\KNearestNeighbors;

class RubixMlTest extends TestCase
{
    private $_plug = 'ml';
    function testRubix()
    {
        $plug = \PMVC\plug($this->_plug);
        $rubixMl = $plug->rubixMl();
        $samples = [[3, 4, 50.5], [1, 5, 24.7], [4, 4, 62.0], [3, 2, 31.1]];

        $labels = ['hot', 'cute', 'hot', 'cute'];
        $dataset = $rubixMl->initDataSet($samples, $labels);
        $estimator = new KNearestNeighbors(3);
        $estimator->train($dataset);
        $samples = [[4, 3, 44.2], [2, 2, 16.7], [2, 4, 19.5], [3, 3, 55.0]];
        $sampleDataset = $rubixMl->initDataSet($samples);
        $predictions = $estimator->predict($sampleDataset);
        var_dump($predictions);
    }
}
