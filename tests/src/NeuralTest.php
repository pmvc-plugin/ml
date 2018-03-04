<?php
namespace PMVC\PlugIn\ml;

use PHPUnit_Framework_TestCase;

class NeuralTest extends PHPUnit_Framework_TestCase
{
    private $_plug='ml';
    function testSimple()
    {
        $plug = \PMVC\plug($this->_plug);
        $neural = $plug->neural()
            ->assign(4, [2], ['a', 'b', 'c'])
            ->train(
                [[1, 0, 0, 0], [0, 1, 1, 0], [1, 1, 1, 1], [0, 0, 0, 0]],
                ['a', 'a', 'b', 'c']
            )
            ->predict([[1, 1, 1, 1], [0, 0, 0, 0]]);
        $this->assertEquals(['b', 'c'], $neural);
    }
}
