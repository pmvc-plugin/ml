<?php

namespace PMVC\PlugIn\ml;

use InvalidArgumentException;

abstract class BaseAlgorithm
{
    protected $_app;
    protected $_state = [];
    protected $_normalizer = false;

    abstract public function getDefaultProps();
    abstract public function getAlgo();

    public function getDefaultNormalizer()
    {
        return null;
    }

    public function __invoke($app = null)
    {
        if (!is_null($this->_app)) {
            $this->_app = $app;
        }
        return $this;
    }

    public function getInstance(array $params)
    {
        $default = $this->getDefaultProps();
        $params = array_replace($default, $params);
        $keys = array_keys($default);
        $configs = [];
        foreach ($keys as $key) {
            $configs[] = $params[$key];
            unset($params[$key]);
        }
        if (count($params)) {
            throw new InvalidArgumentException(
                json_encode([
                    'Error' => 'Config key not correct.',
                    'params' => $params,
                ])
            );
        }
        return $this->getAlgo(...$configs);
    }

    public function assign(array $params = [])
    {
        $params = array_replace($this->_state, $params);
        $this->_app = $this->getInstance($params);
        return $this;
    }

    public function normalize($samples, $normalizer = false, $labels = null)
    {
        $oNormalizer = new NormalizeProcessor($normalizer, $this);
        $samples = $oNormalizer->transform($samples, $labels);
        return $samples;
    }

    public function setNormalizer($normalizer = true)
    {
        $this->_normalizer = $normalizer;
        return $this;
    }

    protected function preTrain($app) {
        return $app;
    }

    protected function postTrain($app) {
        return $this;
    }

    protected function prePredict($app) {
        return $app;
    }

    public function train($samples, $labels = null)
    {
        if ($this->_normalizer) {
            $samples = $this->normalize($samples, $this->_normalizer, $labels);
        }
        $this->preTrain($this->_app)->train($samples, $labels);
        return $this->postTrain($this->_app);
    }

    public function predict($sample)
    {
        return $this->prePredict($this->_app)->predict($sample);
    }
}
