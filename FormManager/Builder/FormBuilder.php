<?php
/**
 * (c) Hayk Grigoryan <hayk@safanlab.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace FormManager\Builder;

use FormManager\Exceptions\FieldNotFoundException;

class FormBuilder implements FormBuilderInterface {

    private $formStorage = [];

    /**
     * @param $action
     * @return $this
     */
    public function addAction($action)
    {
        $this->formStorage['action'] = $action;
        return $this;
    }

    /**
     * @param $child
     * @param null $type
     * @param array $options
     * @return $this
     */
    public function add($child, $type = null, array $options = [])
    {
        $this->formStorage[$child] = [
            'type' => $type,
            'options' => $options,
            'validation' => isset($options['validation']) ? $options['validation'] : []
        ];

        return $this;
    }

    /**
     * @param $method
     * @return $this
     */
    public function addMethod($method)
    {
        $this->formStorage['method'] = $method;
        return $this;
    }

    /**
     * @param $enctype
     * @return $this
     */
    public function addEnctype($enctype)
    {
        $this->formStorage['enctype'] = $enctype;
        return $this;
    }

    /**
     * @param $name
     * @param null $type
     * @param array $options
     */
    public function create($name, $type = null, array $options = [])
    {
        // TODO: Implement create() method.
    }

    /**
     * @param $name
     * @return mixed
     */
    public function get($name)
    {
        if(isset($this->formStorage[$name])) {
            return $this->formStorage[$name];
        } else {
            throw new FieldNotFoundException("The Field you want to use is not declared in FormBuilder");
        }
    }

    /**
     * @return array
     */
    public function all()
    {
        return $this->formStorage;
    }

    /**
     * @param $name
     */
    public function remove($name)
    {
        // TODO: Implement remove() method.
    }

    /**
     * @param $name
     */
    public function has($name)
    {
        // TODO: Implement has() method.
    }

    public function getForm()
    {
        // TODO: Implement getForm() method.
    }

    /**
     * @return mixed
     */
    public function count()
    {
        return count($this->formStorage);
    }

}