<?php

namespace PMVC\PlugIn\ml;

use Rubix\ML\Classifiers\MultilayerPerceptron;
use Rubix\ML\NeuralNet\Layers\Dense;
use Rubix\ML\NeuralNet\Layers\PReLU;
use Rubix\ML\NeuralNet\Layers\Activation;
use Rubix\ML\NeuralNet\Layers\BatchNorm;
use Rubix\ML\NeuralNet\ActivationFunctions\LeakyReLU;
use Rubix\ML\NeuralNet\Optimizers\AdaMax;

${_INIT_CONFIG}[_CLASS] = __NAMESPACE__ . '\GetRubixMlNeuralNetwork';

class GetRubixMlNeuralNetwork
{
    public function __invoke()
    {
        return new RubixMlNeuralNetwork();
    }
}

class RubixMlNeuralNetwork extends BaseAlgorithm
{
    public function getDefaultProps()
    {
        return [
            'hiddenLayers' => [
                new Dense(100),
                new Activation(new LeakyReLU()),
                new Dense(100),
                new Activation(new LeakyReLU()),
                new Dense(100, 0.0, false),
                new BatchNorm(),
                new Activation(new LeakyReLU()),
                new Dense(50),
                new PReLU(),
                new Dense(50),
                new PReLU(),
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
    public function getAlgo(...$params)
    {
        return new MultilayerPerceptron(...$params);
    }
}