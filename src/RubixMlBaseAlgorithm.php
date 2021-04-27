<?php

namespace PMVC\PlugIn\ml;


abstract class RubixMlBaseAlgorithm extends BaseAlgorithm 
{
    public function train($samples, $labels = null)
    {
        if (is_array($samples)) {
          $samples = \PMVC\plug('ml')->rubixMl()->initDataSet($samples, $labels);
        }
        return parent::train($samples);
    }

    public function predict($samples)
    {
        if (is_array($samples)) {
          $sample = \PMVC\plug('ml')->rubixMl()->initDataSet($samples);
        }
        return parent::predict($samples);
    }
}
