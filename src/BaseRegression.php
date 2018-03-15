<?php

namespace PMVC\PlugIn\ml;

use Phpml\SupportVectorMachine\Kernel;

abstract class BaseRegression extends BaseAlgorithm  
{
    public function setKernel($type)
    {
        $v = null;
        switch($type) {
            case 'LINEAR':
                $v = Kernel::LINEAR;
                break;
            case 'POLYNOMIAL':
                $v = Kernel::POLYNOMIAL;
                break;
            case 'RBF':
                $v = Kernel::RBF;
                break;
            case 'SIGMOID':
                $v = Kernel::SIGMOID;
                break;
            default:
                return trigger_error('No such kernel type. ['.$type.']');
                break;
        }
        $this->_state['kernel'] = $v;
        return $this;
    }
}
