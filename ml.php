<?php

namespace PMVC\PlugIn\ml;

use PMVC\PlugIn;

\PMVC\l(__DIR__.'/src/BaseAlgorithm.php');
\PMVC\l(__DIR__.'/src/BaseRegression.php');

${_INIT_CONFIG}[_CLASS] = __NAMESPACE__.'\ml';

class ml extends PlugIn
{
    public function init()
    {
    }
}
