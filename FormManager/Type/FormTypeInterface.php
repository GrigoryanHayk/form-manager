<?php
/**
 * (c) Hayk Grigoryan <hayk@safanlab.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace FormManager\Type;

interface FormTypeInterface extends \Countable {
    /**
     * @param $type
     * @param $options
     * @return mixed
     */
    public function setFormType($type, $options);

    /**
     * @param $name
     * @return mixed
     */
    public function getFormType($name);

    /**
     * @return mixed
     */
    public function count();

}