<?php

namespace PMVC\PlugIn\ml;

use PMVC\PlugIn;

\PMVC\l(__DIR__ . '/src/BaseAlgorithm');
\PMVC\l(__DIR__ . '/src/NormalizeProcessor');


${_INIT_CONFIG}[_CLASS] = __NAMESPACE__.'\ml';

class ml extends PlugIn
{
    public function init()
    {
    }
}
