<?php
namespace PMVC\PlugIn\ml;

use PMVC\TestCase;

class PhpmlNeuralTest extends TestCase
{
    private $_plug='ml';
    function testSimpleInput()
    {
        $plug = \PMVC\plug($this->_plug);
        $neural = $plug->
            phpml()->
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

    function testComplexInput()
    {
        $plug = \PMVC\plug($this->_plug);
        $neural = $plug->
            phpml()->
            neural()->
            assign([
                'inputLayerFeatures'=>4,
                'hiddenLayers'=>[2],
                'classes'=>['a', 'b', 'c']
            ])->
            setNormalizer()-> 
            train(
                [
                    [100, 100, 100, 10],
                    [100, 100, 100, 1],
                    [100, 0, 0, 1],
                ],
                ['a', 'a', 'b']
            );
        $actual = $neural->predictOne([100, 0, 0, 1]);
        $this->assertEquals('b', $actual);
    }
}
