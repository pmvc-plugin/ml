<?php

namespace PMVC\PlugIn\ml;

use Phpml\SupportVectorMachine\Kernel;
use Phpml\Classification\SVC;

${_INIT_CONFIG}[_CLASS] = __NAMESPACE__.'\PhpmlGetSVC';

class PhpmlGetSVC {
  public function __invoke() {
      return new PhpmlSVC();
  }
}

class PhpmlSVC extends PhpmlBaseRegression
{
    public function getDefaultProps()
    {
        return [
            'kernel' => Kernel::LINEAR,
            'cost'   => 1.0,
            'degree' => 3,
            'gamma'  => null,
            'coef0'  => 0.0,
            'tolerance' => 0.001,
            'cacheSize' => 100,
            'shrinking' => true,
            'probabilityEstimates' => true
        ];
    }

    public function getAlgo($configs)
    {
        return new SVC(...$configs);
    }
}
