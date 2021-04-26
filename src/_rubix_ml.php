<?php
namespace PMVC\PlugIn\ml;
use Rubix\ML\Datasets\Labeled;
use Rubix\ML\Datasets\Unlabeled;

${_INIT_CONFIG}[_CLASS] = __NAMESPACE__ . '\RubixMl';

class RubixMl
{
    public function __invoke()
    {
        return $this;
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
