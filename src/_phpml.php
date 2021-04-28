<?php
namespace PMVC\PlugIn\ml;

\PMVC\l(__DIR__ . '/PhpmlBaseAlgorithm');
\PMVC\l(__DIR__ . '/PhpmlBaseRegression');

const PHPML_BIN_DIR = '[VENDOR]/php-ai/php-ml/bin/libsvm';
const PHPML_SVMTRAIN = '/svm-train';
const LOCAL_SVMTRAIN = '/usr/local/bin/svm-train';

${_INIT_CONFIG}[_CLASS] = __NAMESPACE__ . '\PHPML';

class PHPML
{
    public function __construct()
    {
        $binDir = $this->_getVendor(PHPML_BIN_DIR);
        $svmTrainBinPath = $binDir. PHPML_SVMTRAIN;
        $files = ['svm-train', 'svm-predict', 'svm-scale'];
        if (is_file(LOCAL_SVMTRAIN)) {
            if (!is_link($svmTrainBinPath)) {
                foreach ($files as $file) {
                    rename(
                        $binDir . '/' . $file,
                        $binDir . '/' . $file . '-bak'
                    );
                    symlink(
                        '/usr/local/bin/' . $file,
                        $binDir . '/' . $file
                    );
                }
            }
        } else {
            if (!is_file($svmTrainBinPath)) {
                foreach ($files as $file) {
                    symlink(
                        $binDir . '/' . $file . '-bak',
                        $binDir . '/' . $file
                    );
                }
            }
        }
    }

    private function _getVendor($path) {
        $vendor = \PMVC\realPath(__DIR__.'/../vendor');
        if (!$vendor) {
            $vendor = \PMVC\realPath(__DIR__.'/../../../../vendor');
        }
        $nextPath = str_replace('[VENDOR]', $vendor, $path);
        return $nextPath;
    }

    public function __invoke()
    {
        return $this;
    }

    public function __call($method, $args)
    {
        return call_user_func_array([$this->caller, 'phpml_' . $method], $args);
    }
}
