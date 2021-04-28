<?php
namespace PMVC\PlugIn\ml;
use Rubix\ML\Datasets\Labeled;
use Rubix\ML\Datasets\Unlabeled;


\PMVC\l(__DIR__ . '/RubixMlBaseAlgorithm');


${_INIT_CONFIG}[_CLASS] = __NAMESPACE__ . '\RubixMl';

class RubixMl
{
    public function __invoke()
    {
        return $this;
    }

    public function __call($method, $args)
    {
        return call_user_func_array([$this->caller, 'rubix_ml_' . $method], $args);
    }

    public function initDataSet($samples, $labels = null)
    {
        if (is_null($labels)) {
            $dataset = new Unlabeled($samples);
        } else {
            $dataset = new Labeled($samples, $labels);
        }
        return $dataset;
    }

    public function train($dataset, $estimator)
    {
        $estimator->train($dataset);
    }
}
