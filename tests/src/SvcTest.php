<?php

namespace PMVC\PlugIn\ml;

use PHPUnit_Framework_TestCase;

class SvcTest extends PHPUnit_Framework_TestCase
{
    private $_plug='ml';
    function testSimple()
    {
        $samples = [[1, 3], [1, 4], [2, 4], [3, 1], [4, 1], [4, 2]];
        $labels = ['a', 'a', 'a', 'b', 'b', 'b'];
        $plug = \PMVC\plug($this->_plug);
        $result = $plug->
            svc()->
            assign([
                'cost'=> 1000
            ])->
            train($samples, $labels)->
            predicts([[3, 2], [1, 5]]);
        $this->assertEquals(['b', 'a'], $result);
    }
}
