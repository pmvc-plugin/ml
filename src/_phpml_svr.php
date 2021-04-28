<?php

namespace PMVC\PlugIn\ml;

use Phpml\SupportVectorMachine\Kernel;
use Phpml\Regression\SVR;

${_INIT_CONFIG}[_CLASS] = __NAMESPACE__.'\PhpmlGetSVR';

class PhpmlGetSVR {
  public function __invoke() {
      return new PhpmlSVR();
  }
}

class PhpmlSVR extends PhpmlBaseRegression
{
    public function getDefaultProps()
    {
        return [
            'kernel' => Kernel::LINEAR,
            'degree' => 3,
            'epsilon' => 0.1,
            'cost'   => 1.0,
            'gamma'  => null,
            'coef0'  => 0.0,
            'tolerance' => 0.001,
            'cacheSize' => 100,
            'shrinking' => true,
        ];
    }

    public function getAlgo(...$params)
    {
        return new SVR(...$params);
    }
}
