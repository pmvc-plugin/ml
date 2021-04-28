<?php

namespace PMVC\PlugIn\ml;

use Rubix\ML\PersistentModel;
use Rubix\ML\Persisters\Filesystem;


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
          $samples = \PMVC\plug('ml')->rubixMl()->initDataSet($samples);
        }
        return parent::predict($samples);
    }

    protected function preTrain($app) {
        $nextApp = null;
        if ($this->persistency) {
            $nextApp = new PersistentModel(
                $app,
                new Filesystem($this->persistency, true)
            );
        } else {
            $nextApp = $app;
        }
        return $nextApp;
    }

    protected function prePredict($app) {
        if ($this->persistency) {
            $app = PersistentModel::load(new Filesystem($this->persistency));
        }
        return $app;
    }
}
