<?php

namespace PMVC\PlugIn\ml;

# Normalization
use Phpml\Preprocessing\Normalizer;

use InvalidArgumentException; 

abstract class BaseAlgorithm
{
    protected $_app;
    protected $_state = [];

    abstract public function getDefaultProps();
    abstract public function getAlgo();

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

    public function normalize($samples, $normalizer=null)
    {
        if (!is_bool($normalizer)) {
            $oNormalizer = new Normalizer();
        } else {
            $oNormalizer = new Normalizer($normalizer);
        }
        $oNormalizer->transform($samples);
        return $samples;
    }

    public function train($samples, $target, $normalizer=false)
    {
        if ($normalizer) {
            $samples = $this->normalize($samples, $normalizer);
        }
        $this->_app->train($samples, $target); 
        return $this;
    }

    public function predicts(array $samples)
    {
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
