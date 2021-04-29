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

${_INIT_CONFIG}[_CLASS] = __NAMESPACE__ . '\GetPhpmlNeuralNetwork';

class GetPhpmlNeuralNetwork
{
    public function __invoke()
    {
        return new PhpmlNeuralNetwork();
    }
}

class PhpmlNeuralNetwork extends PhpmlBaseAlgorithm
{
    public function getDefaultProps()
    {
        return [
            'inputLayerFeatures' => null,
            'hiddenLayers' => [[2, new PReLU()], [2, new Sigmoid()]],
            'classes' => null,
            'iterations' => 10000,
            'activationFunction' => null,
            'learningRate' => 1,
        ];
    }

    public function preGetConfigs($params, $samples, $labels)
    {
        if (is_null($params['inputLayerFeatures'])) {
            $params['inputLayerFeatures'] = count($samples[0]);
        }
        if (is_null($params['classes'])) {
            $params['classes'] = array_unique($labels);
        }
        return $params;
    }

    public function getAlgo($configs)
    {
        return new MLPClassifier(...$configs);
    }

    public function addLayer($num, $name)
    {
        if (
            !isset($this->state['hiddenLayers']) ||
            !is_array($this->state['hiddenLayers'])
        ) {
            $this->state['hiddenLayers'] = [];
        }
        $this->state['hiddenLayers'][] = $this->getLayer($num, $name);
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
