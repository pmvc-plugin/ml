<?php

namespace PMVC\PlugIn\ml;

use Rubix\ML\Classifiers\MultilayerPerceptron;
use Rubix\ML\NeuralNet\Layers\Dense;
use Rubix\ML\NeuralNet\Layers\PReLU;
use Rubix\ML\NeuralNet\Layers\Activation;
use Rubix\ML\NeuralNet\Layers\BatchNorm;
use Rubix\ML\NeuralNet\ActivationFunctions\LeakyReLU;
use Rubix\ML\NeuralNet\ActivationFunctions\Sigmoid;
use Rubix\ML\NeuralNet\Optimizers\AdaMax;

${_INIT_CONFIG}[_CLASS] = __NAMESPACE__ . '\GetRubixMlNeuralNetwork';

class GetRubixMlNeuralNetwork
{
    public function __invoke()
    {
        return new RubixMlNeuralNetwork();
    }
}

class RubixMlNeuralNetwork extends RubixMlBaseAlgorithm
{
    public function getDefaultProps()
    {
        return [
            'hiddenLayers' => [
                new Dense(128),
                new PReLU(),
                new Dense(128),
                new Activation(new Sigmoid()),
                new BatchNorm(),
            ],
            'batchSize' => 256,
            'optimizer' => new AdaMax(0.0001),
        ];
    }

    /**
     * MultilayerPerceptron
     * https://github.com/RubixML/ML/blob/master/tests/Classifiers/MultilayerPerceptronTest.php
     *
     * https://docs.rubixml.com/1.0/classifiers/multilayer-perceptron.html
     */
    public function getAlgo($configs)
    {
        return new MultilayerPerceptron(...$configs);
    }
}
