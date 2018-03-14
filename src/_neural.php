<?php
namespace PMVC\PlugIn\ml;
use Phpml\Classification\MLPClassifier;

# Activation Functions
use Phpml\NeuralNetwork\ActivationFunction\BinaryStep;
use Phpml\NeuralNetwork\ActivationFunction\Gaussian;
use Phpml\NeuralNetwork\ActivationFunction\HyperbolicTangent;
use Phpml\NeuralNetwork\ActivationFunction\PReLU;
use Phpml\NeuralNetwork\ActivationFunction\Sigmoid;
use Phpml\NeuralNetwork\ActivationFunction\ThresholdedReLU;

# Layer
use Phpml\NeuralNetwork\Layer;
use Phpml\NeuralNetwork\Node\Neuron;

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

    public function getLayer($num, $name)
    {
        $act = null;
        switch ($name) {
            case 'BinaryStep':
                $act = new BinaryStep();
                break;
            case 'Gaussian':
                $act = new Gaussian();
                break;
            case 'HyperbolicTangent':
                $act = new HyperbolicTangent();
                break;
            case 'PReLU':
                $act = new PReLU();
                break;
            case 'ThresholdedReLU':
                $act = new ThresholdedReLU();
                break;
            default:
            case 'Sigmoid':
                $act = new Sigmoid();
                break;
        }
        $layer = new Layer($num, Neuron::class, $act);
        return $layer;
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
