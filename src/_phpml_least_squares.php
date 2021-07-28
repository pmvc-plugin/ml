<?php

namespace PMVC\PlugIn\ml;

use Phpml\Regression\LeastSquares;

${_INIT_CONFIG}[_CLASS] = __NAMESPACE__.'\PhpmlGetLeastSquares';

class PhpmlGetLeastSquares {
  public function __invoke() {
      return new PhpmlLeastSquares();
  }
}

class PhpmlLeastSquares extends PhpmlBaseRegression
{
    public function getDefaultProps()
    {
        return [ ];
    }

    public function getAlgo($configs)
    {
        return new LeastSquares();
    }
}
