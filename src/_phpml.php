<?php
namespace PMVC\PlugIn\ml;

\PMVC\l(__DIR__ . '/PhpmlBaseAlgorithm');
\PMVC\l(__DIR__ . '/PhpmlBaseRegression');

const PHPML_BIN_DIR = __DIR__ . '/../vendor/php-ai/php-ml/bin/libsvm';
const PHPML_SVMTRAIN = PHPML_BIN_DIR . '/svm-train';
const LOCAL_SVMTRAIN = '/usr/local/bin/svm-train';

${_INIT_CONFIG}[_CLASS] = __NAMESPACE__ . '\PHPML';

class PHPML
{
    public function __construct()
    {
        $files = ['svm-train', 'svm-predict', 'svm-scale'];
        if (is_file(LOCAL_SVMTRAIN)) {
            if (!is_link(PHPML_SVMTRAIN)) {
                foreach ($files as $file) {
                    rename(
                        PHPML_BIN_DIR . '/' . $file,
                        PHPML_BIN_DIR . '/' . $file . '-bak'
                    );
                    symlink(
                        '/usr/local/bin/' . $file,
                        PHPML_BIN_DIR . '/' . $file
                    );
                }
            }
        } else {
            if (!is_file(PHPML_SVMTRAIN)) {
                foreach ($files as $file) {
                    symlink(
                        PHPML_BIN_DIR . '/' . $file . '-bak',
                        PHPML_BIN_DIR . '/' . $file
                    );
                }
            }
        }
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
