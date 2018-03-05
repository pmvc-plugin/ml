<?php
namespace PMVC\PlugIn\ml;
use Phpml\Classification\MLPClassifier;

${_INIT_CONFIG}[_CLASS] = __NAMESPACE__.'\NeuralNetwork';

class NeuralNetwork {

    private $_app;

    function __invoke($app = null)
    {
        if (!is_null($this->_app)) {
            $this->_app = $app;
        }
        return $this;
    }

    public function getInstance(
        $inputLayerFeatures,
        $hiddenLayers,
        $classes,
        $iterations = 10000,
        $activationFunction = null,
        $learningRate = 1 
    )
    {
        return new MLPClassifier(
            $inputLayerFeatures,
            $hiddenLayers,
            $classes,
            $iterations,
            $activationFunction,
            $learningRate
        );
    }

    public function assign(...$params)
    {
        $this->_app = $this->getInstance(
            ...$params
        );
        return $this;
    }

    public function train($samples, $target)
    {
        $this->_app->train($samples, $target); 
        return $this;
    }

    public function predict($sample)
    {
        $a = $this->_app->predict([$sample]);
        return $a[0];
    }
}
