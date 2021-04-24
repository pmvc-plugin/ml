<?php
namespace PMVC\PlugIn\ml;

use PMVC\TestCase;

class MlTest extends TestCase
{
    private $_plug = 'ml';
    function testPlugin()
    {
        ob_start();
        print_r(\PMVC\plug($this->_plug));
        $output = ob_get_contents();
        ob_end_clean();
        $this->haveString($this->_plug,$output);
    }

}
