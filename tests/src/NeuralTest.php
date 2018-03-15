<?php
namespace PMVC\PlugIn\ml;

use PHPUnit_Framework_TestCase;

class NeuralTest extends PHPUnit_Framework_TestCase
{
    private $_plug='ml';
    function testSimple()
    {
        $plug = \PMVC\plug($this->_plug);
        $neural = $plug->
            neural()->
            assign([
                'inputLayerFeatures'=>4,
                'hiddenLayers'=>[2],
                'classes'=>['a', 'b', 'c']
            ])->
            train(
                [
                    [1, 0, 0, 0],
                    [0, 1, 1, 0],
                    [1, 1, 1, 1],
                    [0, 0, 0, 0]
                ],
                ['a', 'a', 'b', 'c']
            );
        $b = $neural->predict([1, 1, 1, 1]);
        $c = $neural->predict([0, 0, 0, 0]);
        $this->assertEquals(['b', 'c'], [$b, $c]);
    }
}
