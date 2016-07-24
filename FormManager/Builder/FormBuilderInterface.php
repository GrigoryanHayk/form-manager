<?php
/**
 * (c) Hayk Grigoryan <hayk@safanlab.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace FormManager\Builder;

interface FormBuilderInterface extends \Countable {

    /**
     * @param $action
     * @return mixed
     */
    public function addAction($action);

    /**
     * @param $child
     * @param null $type
     * @param array $options
     * @return mixed
     */
    public function add($child, $type = null, array $options = []);

    /**
     * @param $name
     * @param null $type
     * @param array $options
     * @return mixed
     */
    public function create($name, $type = null, array $options = []);

    /**
     * @param $name
     * @return mixed
     */
    public function get($name);

    /**
     * @param $name
     * @return mixed
     */
    public function remove($name);

    /**
     * @param $name
     * @return mixed
     */
    public function has($name);

    /**
     * @return mixed
     */
    public function all();

    /**
     * @return mixed
     */
    public function getForm();
}