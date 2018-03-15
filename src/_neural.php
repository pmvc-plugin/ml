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

class NeuralNetwork extends BaseAlgorithm
{
    public function getDefaultProps()
    {
        return [
            'inputLayerFeatures' => null,
            'hiddenLayers'       => null,
            'classes'            => null,
            'iterations'         => 10000,
            'activationFunction' => null,
            'learningRate'       => 1,
        ];
    }

    public function getAlgo(...$params)
    {
        return new MLPClassifier(...$params);
    }

    public function addLayer($num, $name)
    {
        if (!isset($this->_state['hiddenLayers']) ||
            !is_array($this->_state['hiddenLayers'])
        ) {
            $this->_state['hiddenLayers'] = [];
        }
        $this->_state['hiddenLayers'][] = 
            $this->getLayer($num, $name);
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

}
