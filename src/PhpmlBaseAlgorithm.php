<?php

namespace PMVC\PlugIn\ml;

use InvalidArgumentException; 

# Normalization
use Phpml\Preprocessing;
use Phpml\ModelManager;

abstract class PhpmlBaseAlgorithm extends BaseAlgorithm 
{
    public function getDefaultNormalizer() {
        return new Preprocessing\Normalizer();
    }

    protected function postTrain($app) {
        if ($this->persistency) {
            $modelManager = new ModelManager();
            $modelManager->saveToFile($app, $this->persistency);
        }
        return $this;
    }

    protected function prePredict($app) {
        if ($this->persistency) {
            $modelManager = new ModelManager();
            $app = $modelManager->restoreFromFile($this->persistency);
        }
        return $app;
    }
}
