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

    public function getDefaultNormalizer() {
        return null;
    }

    public function __invoke($app = null)
    {
        if (!is_null($this->_app)) {
            $this->_app = $app;
        }
        return $this;
    }

    public function getInstance (array $params)
    {
        $default = $this->getDefaultProps(); 
        $params = array_replace(
            $default,
            $params
        );
        $keys = array_keys($default);
        $configs = [];
        foreach ($keys as $key) {
            $configs[] = $params[$key];
            unset($params[$key]);
        }
        if (count($params)) {
            throw new InvalidArgumentException(json_encode([
                'Error'  => 'Config key not correct.',
                'params' => $params
            ]));
        }
        return $this->getAlgo(...$configs);
    }

    public function assign(array $params = [])
    {
        $params = array_replace(
            $this->_state,
            $params
        );
        $this->_app = $this->getInstance($params);
        return $this;
    }

    public function normalize($samples, $normalizer=false)
    {
        $oNormalizer = new Normalizer($normalizer, $this);
        $samples = $oNormalizer->transform($samples);
        return $samples;
    }

    public function setNormalizer($normalizer = true)
    {
        $this->_normalizer = $normalizer;
        return $this;
    }

    public function train($samples, $target)
    {
        if ($this->_normalizer) {
            $samples = $this->normalize($samples, $this->_normalizer);
        }
        $this->_app->train($samples, $target); 
        return $this;
    }

    public function predicts(array $samples)
    {
        if ($this->_normalizer) {
            $samples = $this->normalize($samples, $this->_normalizer);
        }
        return  $this->_app->predict($samples);
    }

    public function predict($sample)
    {
        if (is_array($sample)) {
            $sample = array_values($sample);
        }
        $a = $this->predicts([$sample]);
        return $a[0];
    }
}
