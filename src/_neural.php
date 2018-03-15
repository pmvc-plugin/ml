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
    private $_layers = [];

    function __invoke($app = null)
    {
        if (!is_null($this->_app)) {
            $this->_app = $app;
        }
        return $this;
    }

    public function getInstance (array $params)
    {
        $params = array_replace(
            [
                'inputLayerFeatures' => null,
                'hiddenLayers'       => null,
                'classes'            => null,
                'iterations'         => 10000,
                'activationFunction' => null,
                'learningRate'       => 1,
            ],
            $params
        );
        extract($params, EXTR_PREFIX_SAME, 'unsafe');
        return new MLPClassifier(
            $inputLayerFeatures,
            $hiddenLayers,
            $classes,
            $iterations,
            $activationFunction,
            $learningRate
        );
    }

    public function assign(array $params)
    {
        if (empty($params['hiddenLayers']) && !empty($this->_layers)) {
            $params['hiddenLayers'] = $this->_layers;
        }

        $this->_app = $this->getInstance($params);
        return $this;
    }

    public function addLayer($num, $name)
    {
        $this->_layers[] = $this->getLayer($num, $name);
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
            case 'Sigmoid':
                $act = new Sigmoid();
                break;
            default:
                trigger_error('[ML] assign a wrong action function');
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
        $a = $this->_app->predict([array_values($sample)]);
        return $a[0];
    }
}
