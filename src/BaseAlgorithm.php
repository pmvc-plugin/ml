<?php

namespace PMVC\PlugIn\ml;

use InvalidArgumentException;

abstract class BaseAlgorithm
{
    protected $state = [];
    protected $persistency;
    private $_app;
    private $_normalizer = false;

    abstract public function getDefaultProps();
    abstract public function getAlgo($configs);

    public function getDefaultNormalizer()
    {
        return null;
    }

    protected function preGetConfigs($params, $samples, $labels) {
        return $params;
    }

    public function getInstance($samples, $labels)
    {
        $default = $this->getDefaultProps();
        $params = array_replace($default, $this->state);
        $params = $this->preGetConfigs($params, $samples, $labels);
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
        return $this->getAlgo($configs);
    }

    public function assign(array $params = [])
    {
        $this->state = array_replace($this->state, $params);
        return $this;
    }

    public function clean()
    {
        $this->state = [];
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

    public function setPersistency($file)
    {
        $this->_persistency = $file;
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
        $this->_app = $this->getInstance($samples, $labels);
        $this->preTrain($this->_app)->train($samples, $labels);
        return $this->postTrain($this->_app);
    }

    public function predict($samples)
    {
        if ($this->_normalizer) {
            $samples = $this->normalize($samples, $this->_normalizer);
        }
        return $this->prePredict($this->_app)->predict($samples);
    }

    public function predictOne($sample)
    {
        $result = $this->predict([$sample]);
        return $result[0];
    }
}
