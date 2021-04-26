<?php

namespace PMVC\PlugIn\ml;

use PMVC\TestCase;
use Rubix\ML\Classifiers\KNearestNeighbors;

class RubixMlTest extends TestCase
{
    private $_plug = 'ml';

    public function pmvc_setup()
    {
        $plug = \PMVC\plug($this->_plug);
        $rubixMl = $plug->rubixMl();
        $samples = [[3, 4, 50.5], [1, 5, 24.7], [4, 4, 62.0], [3, 2, 31.1]];

        $labels = ['hot', 'cute', 'hot', 'cute'];
        $this->dataset = $rubixMl->initDataSet($samples, $labels);
        $samples = [[4, 3, 44.2], [2, 2, 16.7], [2, 4, 19.5], [3, 3, 55.0]];
        $this->sampleDataset = $rubixMl->initDataSet($samples);
    } 

    public function testRubix()
    {
        $estimator = new KNearestNeighbors(3);
        $estimator->train($this->dataset);
        $predictions = $estimator->predict($this->sampleDataset);
        var_dump($predictions);
    }

    public function testNeural()
    {

        $plug = \PMVC\plug($this->_plug);
        $neural = $plug->
            rubixMl()->
            neural();
        $neural->assign();
        $neural->train($this->dataset);
        $predictions = $neural->predict($this->sampleDataset);
        var_dump($predictions);
    }
}
