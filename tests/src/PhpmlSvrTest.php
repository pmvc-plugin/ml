<?php

namespace PMVC\PlugIn\ml;

use PMVC\TestCase;

class PhpmlSvrTest extends TestCase
{
    private $_plug='ml';
    function testSimple()
    {
        $samples = [[60], [61], [62], [63], [65]];
        $targets = [3.1, 3.6, 3.8, 4, 4.1];
        $plug = \PMVC\plug($this->_plug);
        $result = $plug->
            phpml()->
            svr()->
            assign()->
            train($samples, $targets)->
            predict([64]);
        $this->assertEquals(4.03, round($result,2));
    }
}
