<?php
/**
 * (c) Hayk Grigoryan <hayk@safanlab.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace FormManager\Builder;

use FormManager\Exceptions\FieldNotFoundException;
use Safan\Safan;

class FormBuilder implements FormBuilderInterface {

    private $formStorage = [];

    public function addAction($action)
    {
        $this->formStorage['action'] = $action;
        return $this;
        // TODO: Implement addAction() method.
    }

    public function add($child, $type = null, array $options = [])
    {
        $this->formStorage[$child] = [
            'type' => $type,
            'options' => $options,
            'validation' => isset($options['validation']) ? $options['validation'] : []
        ];

        return $this;
    }

    public function addMethod($method)
    {
        $this->formStorage['method'] = $method;
        return $this;
    }

    public function addEnctype($enctype)
    {
        $this->formStorage['enctype'] = $enctype;
        return $this;
    }

    public function create($name, $type = null, array $options = [])
    {
        // TODO: Implement create() method.
    }

    public function get($name)
    {
        if(isset($this->formStorage[$name])) {
            return $this->formStorage[$name];
        } else {
            throw new FieldNotFoundException("The Field you want to use is not declared in FormBuilder");
        }
        
        // TODO: Implement get() method.
    }

    public function remove($name)
    {
        // TODO: Implement remove() method.
    }

    public function has($name)
    {
        // TODO: Implement has() method.
    }

    public function all()
    {
        return $this->formStorage;
    }

    public function getForm()
    {
        // TODO: Implement getForm() method.
    }

    public function count()
    {
        return count($this->formStorage);
    }

}