<?php
/**
 * Zend Framework
 *
 * LICENSE
 *
 * This source file is subject to the new BSD license that is bundled
 * with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://framework.zend.com/license/new-bsd
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@zend.com so we can send you a copy immediately.
 *
 * @category   Zend
 * @package    Zend_Filter
 */

namespace Zend\Filter\Compress;

use Traversable;
use Zend\Stdlib\ArrayUtils;

/**
 * Abstract compression adapter
 *
 * @category   Zend
 * @package    Zend_Filter
 */
abstract class AbstractCompressionAlgorithm implements CompressionAlgorithmInterface
{
    /**
     * @var array
     */
    protected $options = array();

    /**
     * Class constructor
     *
     * @param null|array|Traversable $options (Optional) Options to set
     */
    public function __construct($options = null)
    {
        if ($options instanceof Traversable) {
            $options = ArrayUtils::iteratorToArray($options);
        }

        if (is_array($options)) {
            $this->setOptions($options);
        }
    }

    /**
     * Returns one or all set options
     *
     * @param  string $option (Optional) Option to return
     * @return mixed
     */
    public function getOptions($option = null)
    {
        if ($option === null) {
            return $this->options;
        }

        if (!array_key_exists($option, $this->options)) {
            return null;
        }

        return $this->options[$option];
    }

    /**
     * Sets all or one option
     *
     * @param  array $options
     * @return AbstractCompressionAlgorithm
     */
    public function setOptions(array $options)
    {
        foreach ($options as $key => $option) {
            $method = 'set' . $key;
            if (method_exists($this, $method)) {
                $this->$method($option);
            }
        }

        return $this;
    }
}
